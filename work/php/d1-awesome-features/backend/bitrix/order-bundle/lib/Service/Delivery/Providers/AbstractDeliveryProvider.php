<?php

namespace App\Bundle\Order\Service\Delivery\Providers;

use App\Bundle\Order\Service\Delivery\DTO\DeliveryPointDTO;
use App\Bundle\Order\Service\Delivery\DTO\DeliveryProfileDTO;
use App\Bundle\Order\Service\Support\Enums\DeliveryType;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Sale\Delivery\Services\Manager as BitrixDeliveryManager;
use Bitrix\Sale\Order;


/**
 *  Абстрактный класс провайдера, реализует в себе базовые методы для работы с провайдером доставок
 */
abstract class AbstractDeliveryProvider
{
    /**
     * id службы доставки
     *
     * @var int
     */
    public int $id;

    /**
     * Название(код) службы доставки
     *
     * @var string
     */
    public string $name;

    /**
     * Массив профилей службы доставки
     * Каждый профиль имеет структуру:
     * (anykey) => [
     *     id => (int),
     *     type => (string), // Типы указываются чере константы класса DeliveryType
     * ]
     *
     * @var array
     * @see DeliveryType
     */
    public array $profiles;

    /**
     * Битриксовый объект заказа, передается по ссылке
     *
     * @var Order
     */
    protected Order $bitrix_order;

    /**
     * Клас для отправки http запросов
     *
     * @var HttpClient
     */
    protected object $http_client;

    /**
     * @param $bitrix_order
     */
    public function __construct(&$bitrix_order)
    {
        $this->bitrix_order =& $bitrix_order;
        $this->http_client = new HttpClient();
    }

    /**
     * Возвращает id профилей данной службы доставки
     *
     * @return array
     */
    public function getProfilesIds(): array
    {
        return array_column($this->profiles, 'id');
    }

    /**
     * Возвращает массив профилей доставок в виде объекта DeliveryProfileDTO
     *
     * @param array $ids
     * @param bool $with_pickup_data
     * @return DeliveryProfileDTO[]
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     * @throws SystemException
     * @see DeliveryProfileDTO
     */
    public function getProfileDTOs(array $ids, bool $with_pickup_data = false): array
    {
        $profiles = array_filter($this->profiles, function ($profile) use ($ids) {
            return in_array($profile['id'], $ids);
        });

        return array_filter(array_map(function ($profile) use ($with_pickup_data) {
            return $this->getProfileData($profile, $with_pickup_data);
        }, $profiles));
    }

    /**
     * Получает объект DeliveryProfileDTO для переданного профиля
     *
     * @param array $profile
     * @param bool $with_pickup_data
     * @return DeliveryProfileDTO
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     * @throws SystemException
     * @see DeliveryProfileDTO
     */
    public function getProfileData(array $profile, bool $with_pickup_data = false): DeliveryProfileDTO
    {
        $calculateData = $this->calculateProfile($profile);

        $points = [];
        $widget = [];

        if ($with_pickup_data && $profile['type'] === DeliveryType::PICKUP) {
            $points = $this->getPickupPoints($calculateData);
        }

        if ($profile['type'] === DeliveryType::PICKUP_WIDGET) {
            $widget = $this->getPickupWidget($calculateData);
        }

        return DeliveryProfileDTO::fromArray([
            'id' => $profile['id'],
            'name' => $calculateData['shipment']->getDelivery()->getName(),
            'description' => $calculateData['shipment']->getDelivery()->getDescription(),
            'provider' => $this->name,
            'type' => $profile['type'],
            'price' => $calculateData['calculate_result']->getDeliveryPrice(),
            'delivery_time' => $calculateData['calculate_result']->getPeriodDescription(),
            'points' => $points,
            'widget' => $widget,
        ]);
    }

    /**
     * Проводит рассчет доставки по переданному профилю
     * Возвараещт массив, содержащий результаты рассчета и объект отгрузки
     *
     * @param array $profile
     * @return array
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     * @throws SystemException
     */
    public function calculateProfile(array $profile): array
    {
        $this->bitrix_order->getShipmentCollection()->clearCollection();
        $shipmentCollection = $this->bitrix_order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(
            BitrixDeliveryManager::getObjectById($profile['id'])
        );

        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($this->bitrix_order->getBasket() as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }

        return [
            'calculate_result' => BitrixDeliveryManager::calculateDeliveryPrice($shipment, $profile['id'], []),
            'shipment' => $shipment,
        ];
    }

    /**
     * @param $bitrix_order
     * @return static
     */
    abstract public static function getInstance(&$bitrix_order): static;

    /**
     * Возвращает пункты самоввывоза для карты
     *
     * @return DeliveryPointDTO[]
     */
    abstract public function getPickupPoints(array $data): array;

    /**
     * Возварщает массив с данными о виджете
     *
     * @param array $data
     * @return array
     */
    abstract public function getPickupWidget(array $data): array;

    /**
     * Возвращает необходимые и валидируемые свйоства заказа из реквеста
     *
     * @param array $request
     * @param int $profile_id
     * @return array
     */
    abstract public function getPropsByRequest(array $request, int $profile_id = 0): array;
}