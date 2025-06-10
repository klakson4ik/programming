<?php

namespace App\Bundle\Order\Service\Order;

use App\Bundle\Order\Service\Order\DTO\PaySystemDTO;
use App\Bundle\Order\Service\Support\Enums\OrderProps;
use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Sale\BasketBase;
use Bitrix\Sale\Order;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\PaymentCollection;
use Bitrix\Sale\PaySystem\Manager as BitrixPaySystemManager;
use Bitrix\Sale\PaySystem\ServiceResult;
use Bitrix\Sale\PropertyValueCollectionBase;
use Bitrix\Sale\ShipmentCollection;
use CUser;
use Exception;

/**
 * Базовый класс для работы с заказом
 */
class BaseOrder
{
    /**
     * Битриксовый объект заказа
     *
     * @var Order|null
     */
    public ?Order $bitrix_order = null;

    /**
     * Объект данного класса, после инициализации не изменяется
     *
     * @var BaseOrder|null
     */
    protected static ?self $_instance = null;

    /**
     * Базовая валюта
     *
     * @var string|null
     */
    protected ?string $base_currency;

    /**
     * Базовый тип плательщика
     *
     * @var int
     */
    protected int $base_person_type_id = 1;

    /**
     * Установленна ли козрина
     *
     * @var bool
     */
    protected bool $have_basket = false;

    /**
     * Базовый код местоположения
     *
     * @var string
     */
    protected string $default_location = '0000073738';

    /**
     * @var string
     */
    protected string $order_id_get_parameter = 'order_id';

    /**
     *  При создании объекта устанавливает валюту и иницирует класс для работы с купонами и скидками
     *
     * @see DiscountCouponsManager
     */
    public function __construct()
    {
        $this->base_currency = CurrencyManager::getBaseCurrency();
        DiscountCouponsManager::init();
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return static::$_instance ??= new static();
    }

    /**
     * Устанавливает корзину, в случает если корзина у заказа уже установленна выбрасывает исключение
     *
     * @param BasketBase $bitrix_basket
     * @return $this
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     * @throws Exception
     */
    public function setBasket(BasketBase $bitrix_basket): self
    {
        if ($this->have_basket) {
            throw new Exception('Корзина уже установленна');
        }

        $result = $this->bitrix_order->setBasket($bitrix_basket);

        if (!$result->isSuccess()) {
            throw new Exception('Ошибка при добавлении корзины в заказ - ' .  implode('; ', $result->getErrorMessages()));
        }

        $this->have_basket = true;
        return $this;
    }

    /**
     * Устанавливает статус заказа
     *
     * @param string $status_id
     * @return $this|self
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     */
    public function setStatus(string $status_id): static
    {
        return $this->setField('STATUS_ID', $status_id);
    }

    /**
     * Возвращает id статуса заказа
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->getField('STATUS_ID');
    }


    /**
     * Возвращает поле заказа по коду
     *
     * @param string $code
     * @return string|null
     */
    public function getField(string $code): ?string
    {
        return $this->bitrix_order->getField($code);
    }

    /**
     * Возвращает массив полей заказа
     *
     * @return array
     */
    public function getFieldsArray(): array
    {
        return $this->bitrix_order->getFields()->getValues();
    }

    /**
     * Возвращает id службы доставки, применненной к заказу
     *
     * @return int
     */
    public function getSelectedDeliveryId(): int
    {
        return (int)$this->getField('DELIVERY_ID');
    }

    /**
     * Возвращает id службы оплаты, применненной к заказу
     *
     * @return int
     */
    public function getSelectedPaySystemId(): int
    {
        return (int)$this->getField('PAY_SYSTEM_ID');
    }

    /**
     * Устанавливает поле заказа
     *
     * @param string $code
     * @param mixed $value
     * @return $this
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     */
    public function setField(string $code, mixed $value): self
    {
        $this->bitrix_order->setField($code, $value);

        return $this;
    }

    /**
     * Устанавливает сразу несколько полей заказа
     *
     * @param array $fields
     * @return $this
     * @throws Exception
     */
    public function setFields(array $fields): self
    {
        $result = $this->bitrix_order->setFields($fields);

        if (!$result->isSuccess()) {
            throw new Exception('Ошибка при заполнении свойств заказа - ' .  implode('; ', $result->getErrorMessages()));
        }

        return $this;
    }

    /**
     * Устанавливает тип платальщика
     *
     * @param int $id
     * @return void
     */
    public function setPersonTypeId(int $id): void
    {
        $this->bitrix_order->setPersonTypeId($id);
    }

    /**
     * Устанавливает службу доставки заказа
     * Так же можно 3 аргументом передать цену досатвки,
     * которая будет установленна у заказа, если не передать, то посчитает сам
     *
     * @param int $delivery_id
     * @param string $delivery_name
     * @param float $price
     * @return void
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     */
    public function setDelivery(int $delivery_id, string $delivery_name, float $price = 0.0): void
    {
        $this->getShipmentCollection()->clearCollection();
        $shipment = $this->getShipmentCollection()->createItem();
        $shipment->setFields([
            'DELIVERY_ID' => $delivery_id,
            'DELIVERY_NAME' => $delivery_name,
        ]);

        $shipment_item_collection = $shipment->getShipmentItemCollection();

        foreach ($this->bitrix_order->getBasket() as $basket_item) {
            $shipment_item = $shipment_item_collection->createItem($basket_item);
            $shipment_item->setQuantity($basket_item->getQuantity());
        }

        if ($price > 0) {
            $shipment->setBasePriceDelivery($price);
        }
    }

    /**
     * Устанавливает службу оплаты
     * Внимание: 1 аргументом нужно передавать не id службы доставки, а его pay_system_id (часто они совпадают)
     *
     * @param int $pay_system_id
     * @param string $pay_system_name
     * @return void
     * @throws ArgumentOutOfRangeException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     */
    public function setPayment(int $pay_system_id, string $pay_system_name): void
    {
        $this->getPaymentCollection()->clearCollection();
        $payment = $this->getPaymentCollection()->createItem();
        $payment->setFields([
            'PAY_SYSTEM_ID' => $pay_system_id,
            'PAY_SYSTEM_NAME' => $pay_system_name,
            'SUM' => $this->getPrice(),
            'CURRENCY' => $this->base_currency
        ]);
    }

    /**
     * Возвращает доступные (включая ограничения) службы доставки в виде объекта PaySystemDTO
     *
     * @return PaySystemDTO[]
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws SystemException
     * @see PaySystemDTO
     */
    public function getAvailablePaySystems(): array
    {
        $payment = $this->bitrix_order->getPaymentCollection()->createItem();
        $payment->setField('SUM', $this->bitrix_order->getPrice());

        return array_map(function ($item) {
            return PaySystemDTO::fromArray($item);
        }, array_values(BitrixPaySystemManager::getListWithRestrictions($payment)));
    }

    /**
     * Возвращает цену заказа, включая применение скидок
     *
     * @return int|float
     */
    public function getPrice(): int|float
    {
        return $this->bitrix_order->getPrice();
    }

    /**
     * Возвращает цену заказа, не включает применение скидок
     *
     * @return int|float
     */
    public function getBasePrice(): int|float
    {
        return $this->bitrix_order->getBasePrice();
    }

    /**
     * Возвращает цену доставки
     *
     * @return int|float
     */
    public function getDeliveryPrice(): int|float
    {
        return $this->bitrix_order->getDeliveryPrice();
    }

    /**
     * Возвращает цену товаров(корзины), включает примененные скидки
     *
     * @return int|float
     * @throws ArgumentNullException
     */
    public function getBasketPrice(): int|float
    {
        return $this->bitrix_order->getBasket()->getPrice();
    }

    /**
     * Возвращает цену товаров(корзины), не включает примененные скидки
     *
     * @return int|float
     * @throws ArgumentNullException
     */
    public function getBasketBasePrice(): int|float
    {
        return $this->bitrix_order->getBasket()->getBasePrice();
    }

    //TODO: проверить корректность данного метода
    /**
     * Возвращает скидку (разница между базовой ценой и общей
     * Если передать первым аргументом true, то вернет значение из поля DISCOUNT_PRICE,
     * которое к общей сумме скидки имеет весьма отдаленное отношение(цитата разработчика битрикс)
     *
     * @param bool $by_field
     * @return int|float
     * @see getBasePrice
     * @see getPrice
     */
    public function getDiscountPrice(bool $by_field = false): int|float
    {
        if ($by_field) {
            return $this->bitrix_order->getDiscountPrice();
        }

        return $this->getBasePrice() - $this->getPrice();
    }

    /**
     * Создает объект заказа, рекомендуется сразу передать аргументом битриксовую корзину
     * при создании так же заполняет базовые свойства и поля заказа, а так же применяет скидки
     *
     * @param BasketBase|null $bitrix_basket
     * @return $this
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectException
     * @throws ObjectNotFoundException
     * @see applyDiscount
     * @see setBasket
     * @see setFieldsAfterCreate
     */
    public function create(?BasketBase $bitrix_basket = null): static
    {
        global $USER;
        $userId = $USER instanceof CUser ? $USER->GetID() : 0;

        $this->bitrix_order = Order::create(SITE_ID, $userId);

        if ($bitrix_basket !== null) {
            $this->setBasket($bitrix_basket);
            $this->applyDiscount();
        }

        $this->setFieldsAfterCreate();

        return $this;
    }

    /**
     * Сохраняет заказ
     *
     * @return object
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function save(): object
    {
        return $this->bitrix_order?->save();
    }

    /**
     * Возвращает id заказа
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->bitrix_order->getId();
    }

    /**
     * Загружает заказ по id
     *
     * @param int $order_id
     * @return static
     * @throws ArgumentNullException
     * @throws Exception
     * @see Order::load
     */
    public static function load(int $order_id): static
    {
        $instance = new static();

        $instance->bitrix_order = Order::load($order_id);

        if (!$instance->bitrix_order) {
            throw new Exception('Не удалось получить заказа по id ' . $order_id);
        }

        return $instance;
    }

    /**
     * Инициализирует шаблон для оплаты
     *
     * @param int|null $order_id
     * @return ServiceResult
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ArgumentTypeException
     * @throws LoaderException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws Exception
     * @see BitrixPaySystemManager
     */
    public function initialPay(?int $order_id = null): ServiceResult
    {
        $request = Application::getInstance()->getContext()->getRequest();

        if (!$order_id) {
            $order_id = (int)$request->get($this->order_id_get_parameter);
        }

        if ($order_id === 0) {
            throw new Exception('Ошибка при получении id заказа ' . $order_id);
        }

        $payment = $this->getPaymentCollection()[0];
        $service = BitrixPaySystemManager::getObjectById($payment->getPaymentSystemId());
        return $service->initiatePay($payment, $request);
    }

    /**
     * Прмиеняет скидки
     *
     * @param array $data
     * @return object
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotSupportedException
     */
    public function applyDiscount(array $data = []): object
    {
        if (empty($data)) {
            $data = $this->bitrix_order->getDiscount()->calculate()->getData();
        }

        return $this->bitrix_order->applyDiscount($data);
    }

    /**
     * Финальная обработка заказа
     *
     * @param bool $hasMeaningfulField
     * @return void
     * @throws ArgumentNullException
     * @throws ObjectNotFoundException
     */
    public function doFinalAction(bool $hasMeaningfulField = false): void
    {
        $this->bitrix_order->doFinalAction($hasMeaningfulField);
    }

    /**
     * Возвращает коллекцию свойств
     *
     * @return PropertyValueCollectionBase
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getPropertyCollection(): PropertyValueCollectionBase
    {
        return $this->bitrix_order->getPropertyCollection();
    }

    /**
     * Возвращает коллекцию отгрузок
     *
     * @return ShipmentCollection
     * @throws ArgumentException
     * @throws ArgumentNullException
     */
    public function getShipmentCollection(): ShipmentCollection
    {
        return $this->bitrix_order->getShipmentCollection();
    }

    /**
     * Возвращает коллекцию платежных систем
     *
     * @return PaymentCollection
     */
    public function getPaymentCollection(): PaymentCollection
    {
        return $this->bitrix_order->getPaymentCollection();
    }

    /**
     * Устанавливает свойства заказа из переданного массива
     * массив должен иметь ввид: [(код свойства) => (значение)]
     * код свойства должен быть в нижнем регистре
     *
     * @param array $properties
     * @return void
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function setPropertiesByArray(array $properties): void
    {
        $properties = array_change_key_case($properties, CASE_UPPER);

        foreach ($this->getPropertyCollection() as $property) {
            $code = $property->getField('CODE');

            if ($properties[$code]) {
                $property->setValue($properties[$code]);
            }
        }
    }

    /**
     * Возвражает трекномер заказа
     *
     * @return object|bool
     */
    public function getDeliveryTrackCode(): object|bool
    {
        return $this->getPropertyByCode(OrderProps::PROPERTY_TRACK_CODE);
    }

    /**
     * Устанавливает покупателя заказа по id пользователя
     *
     * @param int $user_id
     * @return void
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     */
    public function setUser(int $user_id): void
    {
        $this->bitrix_order->setFieldNoDemand('USER_ID', $user_id);
    }

    /**
     * Устанавливает свойство заказа "индекс"
     *
     * @param string|int $zip
     * @return object|false
     */
    public function setZip(string|int $zip): object|false
    {
        return $this->setPropertyById(OrderProps::PROPERTY_ZIP_ID, $zip);
    }

    /**
     * Устанавливает свойство заказа "местоположение"
     *
     * @param string|int $location
     * @return object|false
     */
    public function setLocation(string|int $location): object|false
    {
        return $this->setPropertyById(OrderProps::PROPERTY_LOCATION_ID, $location);
    }

    /**
     * Получает установленное в заказ свойство "местоположение"
     *
     * @return string|null
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getLocation(): ?string
    {
        $locationProperty = $this->getPropertyCollection()->getDeliveryLocation();

        if ($locationProperty) {
            return $locationProperty->getValue();
        }

        return '';
    }

    /**
     * Получает установленное в заказ свойство "индекс"
     *
     * @return string|null
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getZip(): ?string
    {
        $zipProperty = $this->getPropertyCollection()->getDeliveryLocationZip();

        if ($zipProperty) {
            return $zipProperty->getValue();
        }

        return '';
    }

    /**
     * Устанавливает значение свйоства по коду
     *
     * @param string $code
     * @param mixed $value
     * @return object|false
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function setPropertyByCode(string $code, mixed $value): object|false
    {
        foreach ($this->getPropertyCollection() as $property) {
            if ($property->getField('CODE') === $code) {
                return $property->setValue($value);
            }
        }

        return false;
    }

    /**
     * Получает значение свойства по коду
     *
     * @param string $code
     * @return object|null
     * @throws ArgumentException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getPropertyByCode(string $code): object|null
    {
        foreach ($this->getPropertyCollection() as $property) {
            if ($property->getField('CODE') === $code) {
                return $property->getValue();
            }
        }

        return null;
    }

    /**
     * Устанавливает значение свойства по его id
     *
     * @param int $id
     * @param mixed $value
     * @return object|false
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function setPropertyById(int $id, mixed $value): object|false
    {
        $property = $this->getPropertyCollection()->getItemByOrderPropertyId($id);

        if ($property) {
            return $property->setValue($value);
        }

        return false;
    }

    /**
     * Устанавливает базовые поля и свойства заказа,
     * так же еще устанавливает базовый тип плательщика
     *
     * @return void
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     */
    protected function setFieldsAfterCreate(): void
    {
        $this->setPersonTypeId($this->base_person_type_id);
        $this->setField('CURRENCY', $this->base_currency);

        if ($this->default_location) {
            $this->setLocation($this->default_location);
        }
    }
}