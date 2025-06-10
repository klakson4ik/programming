<?php

namespace App\Bundle\Order\Service\Delivery;

use App\Bundle\Order\Service\Delivery\DTO\DeliveryProfileDTO;
use App\Bundle\Order\Service\Delivery\Providers\AbstractDeliveryProvider;
use App\Bundle\Order\Service\Delivery\Providers\RupostDeliveryProvider;
use App\Bundle\Order\Service\Delivery\Providers\BoxberryDeliveryProvider;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\SystemException;
use Bitrix\Sale\Services\Base\RestrictionManager;
use Bitrix\Sale\Shipment;
use Bitrix\Sale\Delivery\Restrictions\Manager as BitrixRestrictionsManager;

/**
 * Класс для получения провайдеров служб доставки
 * Провайдер представляет собой класс работы с конкретной службой доставки,
 * Включая получения пунктов выдачи на карте, время доставки и виджета доставки.
 * При добавлении новой службы необходимо обязательно создать для нее провайдера и подключить в этом классе
 * Подключение происходит при добавлении неймспейса класса провайдера в свйство providers_list
 * Класс провайдера обязательно должен быть унаследован от AbstractDeliveryProvider
 *
 * @see AbstractDeliveryProvider
 */
class DeliveryManager
{
    /**
     * Инастнс данного класса
     *
     * @var DeliveryManager|null
     */
    protected static ?self $_instance = null;

    /**
     * Битриксовый объект заказа, передается по ссылке
     *
     * @var object
     */
    protected object $bitrix_order;

    /**
     * Массив неймспейсов провайдеров служб доставки
     *
     * @var AbstractDeliveryProvider[]
     */
    protected array $providers_list = [
        BoxberryDeliveryProvider::class,
        RupostDeliveryProvider::class
    ];

    /**
     * Массив провайдеров служб доставки
     * Тут содежрутся уже полученные объекты каждого провайдера
     * Создаются и записываются они в конструкторе данного класса
     *
     * @var AbstractDeliveryProvider[]
     */
    protected array $providers;

    /**
     * @param $bitrix_order
     */
    public function __construct(&$bitrix_order)
    {
        $this->bitrix_order =& $bitrix_order;

        $this->providers = array_map(function ($provider_class) {
            return $provider_class::getInstance($this->bitrix_order);
        }, $this->providers_list);
    }

    /**
     * @param $bitrix_order
     * @return self
     */
    public static function getInstance(&$bitrix_order): self
    {
        return self::$_instance ??= new self($bitrix_order);
    }

    /**
     * Возвращает класс провайдера по его названию
     *
     * @param string $name
     * @return AbstractDeliveryProvider|null
     */
    public function getProviderByName(string $name): ?AbstractDeliveryProvider
    {
        foreach ($this->providers as $provider) {
            if ($provider->name === $name) {
                return $provider;
            }
        }

        return null;
    }

    /**
     * Возвращает класс провайдера по его id
     *
     * @param int $id
     * @return AbstractDeliveryProvider|null
     */
    public function getProviderById(int $id): ?AbstractDeliveryProvider
    {
        foreach ($this->providers as $provider) {
            if ($provider->id === $id || in_array($id, array_column($provider->profiles, 'id'))) {
                return $provider;
            }
        }

        return null;
    }

    /**
     * Получает доступные доставки(профиля) в виде объекта DeliveryProfileDTO,
     * содержаешьго всю необходимую информацию о доставке
     *
     * @param bool $with_pickup_data
     * @return DeliveryProfileDTO[]
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getAvailableDeliveries(bool $with_pickup_data = false): array
    {
        $providers_id = $this->getAvailableProfilesIds();
        $providers = array_map(function ($provider) use ($providers_id, $with_pickup_data) {
            return $providers_id[$provider->id] ? $provider->getProfileDTOs($providers_id[$provider->id], $with_pickup_data) : [];
        }, $this->providers);

        return $this->prepareResult($providers);
    }

    /**
     * Возвращает доступные id профилей доставок, учитывая ограничения
     *
     * @return array
     * @throws ArgumentException
     * @throws SystemException
     */
    public function getAvailableProfilesIds(): array
    {
        $shipmentCollection = $this->bitrix_order->getShipmentCollection();
        $shipment = Shipment::create($shipmentCollection);
        $delivery_ids = BitrixRestrictionsManager::getRestrictedIds($shipment, RestrictionManager::MODE_CLIENT);

        return $this->prepareAvailableProfilesIds(array_keys($delivery_ids));
    }

    /**
     * @param array $ids
     * @return array
     */
    protected function prepareAvailableProfilesIds(array $ids): array
    {
        $result = [];

        foreach ($this->providers as $provider) {
            $profiles = $provider->getProfilesIds();
            $parent_id = $provider->id;

           foreach ($ids as $id) {
               if (in_array($id, $profiles)) {
                   $result[$parent_id][] = $id;
               }
           }
        }

        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    protected function prepareResult(array $result): array
    {
        return array_merge(...array_values(array_filter($result)));
    }
}