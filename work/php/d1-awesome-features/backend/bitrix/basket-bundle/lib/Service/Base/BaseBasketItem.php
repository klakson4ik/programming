<?php

namespace App\Bundle\Basket\Service\Base;

use App\Bundle\Basket\Interfaces\BasketItem;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Sale\BasketItemBase;
use CCatalogProduct;
use Exception;
use Bitrix\Currency\CurrencyManager;
use TAO;

/**
 * Базовый класс для работы с товаром в корзине (не путать с просто товаром или торговым предложением, это разные сущности)
 * Данная реализация полностью рабочая, но, вероятнее всего, нужно будет унаследовать этот класс для реализации под конкретный проект
 *
 * @property int $id
 * @property int $product_id
 * @property int $price
 * @property int $base_price
 * @property int|float $discount_percent
 * @property int $sum
 * @property int $quantity
 * @property string|int $weight
 * @property bool $can_buy
 * @property string $name
 * @property string $product_url
 * @property int $available_quantity
 * @property array $properties
 * @see BasketItemBase
 */
class BaseBasketItem implements BasketItem
{
    /**
     * Битриксовый объект товара в корзине
     *
     * @var BasketItemBase
     */
    public BasketItemBase $bitrix_item;

    /**
     * Код инфоблока торгового предложения
     *
     * @var string
     */
    public string $iblock_code = '';

    /**
     * Объект инфоблока с торговыми предложениями
     *
     * @var null|TAO\Infoblock
     */
    protected static ?TAO\Infoblock $iblock = null;

    /**
     * Массив, содержащий загруженные элементы инфоблока(торговые предложения)
     *
     * @var array
     */
    protected static array $iblock_items = [];

    /**
     * @param $bitrix_item
     */
    public function __construct($bitrix_item)
    {
        $this->bitrix_item = $bitrix_item;
    }

    /**
     * Получение поля товара в корзине по коду
     *
     * @param string $field
     * @return string|float|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public function getField(string $field): string|null|float
    {
        return $this->bitrix_item->getField($field);
    }

    /**
     * Установление поля товара в корзине по коду
     *
     * @param string $code
     * @param mixed $field
     * @return object
     * @throws ArgumentOutOfRangeException
     */
    public function setField(string $code, mixed $field): object
    {
        return $this->bitrix_item->setField($code, $field);
    }

    /**
     * Массовое установление полей товара в корзине
     *
     * @param array $fields
     * @return object
     * @throws ArgumentOutOfRangeException
     * @throws NotSupportedException
     */
    public function setFields(array $fields): object
    {
        return $this->bitrix_item->setFields($fields);
    }

    /**
     * Удаление товара из корзины
     *
     * @return object
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     */
    public function delete(): object
    {
        return $this->bitrix_item->delete();
    }

    /**
     * Сохранение товара в корзине
     *
     * @return void
     * @throws ArgumentNullException
     * @throws ArgumentException
     */
    public function save(): void
    {
        $this->bitrix_item->save();
    }

    /**
     * Установка базовых свойст и полей товара,
     * рекомендуется вызывать сразу после получения объекта класса
     *
     * @param int $quantity
     * @param array $fields - поля товара
     * @param array $props - свойства товара
     * @return object
     * @throws ArgumentOutOfRangeException
     * @throws NotSupportedException
     */
    public function create(int $quantity = 1, $fields = [], $props = []): object
    {
        $this->setBaseProperties($props);

        $fields = array_merge($fields, [
            'QUANTITY' => $quantity,
            'LID' => SITE_ID,
            'CURRENCY' => CurrencyManager::getBaseCurrency(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider'
        ]);

        return $this->setFields($fields);
    }

    /**
     * Устанавливает количесво товара в корзине
     *
     * @param int $quantity
     * @return object
     * @throws ArgumentOutOfRangeException
     */
    public function setQuantity(int $quantity): object
    {
        return $this->setField('QUANTITY', $quantity);
    }

    /**
     * Возвращает коллекцию свойств товара в корзине
     *
     * @return object
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ObjectNotFoundException
     * @throws NotImplementedException
     */
    public function getPropertyCollection(): object
    {
        return $this->bitrix_item->getPropertyCollection();
    }


    /**
     * Возващает массив с свойствами и полями товара в корзине
     * можно явно передать id торгового предложения, дефолтно берет значение из геттера
     * false в случае, если товар не найден
     *
     * @param int $product_id
     * @return bool|array
     */
    public function getProductPropertiesArray(int $product_id = 0): bool|array
    {
        if (!$product_id) {
            $product_id = $this->product_id;
        }

        return CCatalogProduct::GetByID($product_id);
    }

    /**
     * Возвращает доступное количесвто товара
     *
     * @return int
     */
    public function getAvailableQuantity(): int
    {
        $properties = $this->getProductPropertiesArray();

        return (int)$properties['QUANTITY'];
    }

    /**
     * Устанавлиае свойства товара из переданного массива
     *
     * @param array $data [ // массив свойств
     *		$anyKey => [
     * 			'NAME' => (string),
     *          'CODE' => (string),
     *          'VALUE' => (string),
     *          'SORT' => (int),
     *      ],
     * 	]
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     * @see BaseBasketItem::setProperty()
     */
    public function setProperties(array $data): void
    {
        $this->setProperty($data, true);
    }

    /**
     * Устанавлиае свойство или свойства товара из переданного массива
     * Для установления сразу множества свйоств рекоменджуется использовать метод setProperties()
     *
     * @param array $data [ // массив со свойством товара.
     * 		'NAME' => (string),
     *      'CODE' => (string),
     *      'VALUE' => (string),
     *      'SORT' => (int),
     *  ]
     * @param bool $is_arrays // true если передан массив с несколькими свойствами
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     * @throws ArgumentTypeException
     * @see BaseBasketItem::setProperties()
     */
    public function setProperty(array $data, bool $is_arrays = false): void
    {
        if (!$is_arrays) {
            $data = [$data];
        }

        $this->getPropertyCollection()->setProperty($data);
    }

    /**
     * Возвращает массив данных о свойстве товара по коду свойства
     *
     * @param string $code
     * @return array
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws NotImplementedException
     * @throws ObjectNotFoundException
     */
    public function getPropertyByCode(string $code): array
    {
        foreach ($this->getPropertyCollection() as $property) {
            if ($property->getField('CODE') === $code) {
                return $property->toArray();
            }
        }

        return [];
    }

    /**
     * Возвращает элемент инофблока торговых предложений
     *
     * @param int $product_id
     * @return TAO\Entity|null
     * @throws Exception
     * @see TAO\Entity
     */
    public function getIblockItemByProductId(int $product_id): TAO\Entity|null
    {
        if (isset(static::$iblock_items[$product_id])) {
            return static::$iblock_items[$product_id];
        }

        if (!static::$iblock) {
            $this->loadIblock();
        }

        $item = static::$iblock->loadItem($product_id, false);

        if ($item) {
            static::$iblock_items[$product_id] = $item;
        }

        return $item;
    }

    /**
     * Возвращает массив с полями и свойставми товара в корзине
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_url' => $this->product_url,
            'product_id' => $this->product_id,
            'price' => $this->price,
            'base_price' => $this->base_price,
            'discount_percent' => $this->discount_percent,
            'sum' => $this->sum,
            'quantity' => $this->quantity,
            'can_buy' => $this->can_buy,
            'name' => $this->name,
            'available_quantity' => $this->available_quantity,
            'properties' => $this->properties,
        ];
    }

    /**
     * Возвращает детальную ссылку на продукт в каталоге
     *
     * @return string
     * @throws Exception
     */
    public function getProductUrl(): string
    {
        $product = $this->getIblockItemByProductId($this->product_id);

        return $product->url();
    }

    /**
     * Возвращает примененную к товару скидку в процентах
     *
     * @return int|float
     */
    public function getDiscountPercent(): int|float
    {
        return ceil(($this->price * 100) / $this->base_price);
    }

    /**
     * @param string $property
     * @return float|int|mixed|string
     * @throws Exception
     */
    public function __get(string $property)
    {
        switch ($property)
        {
            case 'id':
                return $this->bitrix_item->getId();
            case 'product_id':
                return $this->bitrix_item->getProductId();
            case 'price':
                return (int)$this->bitrix_item->getPrice();
            case 'base_price':
                return (int)$this->bitrix_item->getBasePrice();
            case 'sum':
                return (int)$this->bitrix_item->getFinalPrice();
            case 'quantity':
                return (int)$this->bitrix_item->getQuantity();
            case 'weight':
                return $this->bitrix_item->getWeight();
            case 'can_buy':
                return $this->bitrix_item->canBuy();
            case 'name':
                return $this->getField('NAME');
            case 'product_url':
                return $this->getProductUrl();
            case 'available_quantity':
                return $this->getAvailableQuantity();
            case 'discount_percent':
                return $this->getDiscountPercent();
            case 'properties':
                return  $this->getPropertyCollection()->getPropertyValues();
        }

        throw new Exception(sprintf('Свойстово "%s" не найденно', $property));
    }

    /**
     * Загружает инфоблок торговых предложений в статичное свойство
     *
     * @return void
     * @throws Exception
     * @see BaseBasketItem::$iblock
     */
    protected function loadIblock(): void
    {
        if ($this->iblock_code) {
            self::$iblock = TAO::infoblock($this->iblock_code);
            return;
        }

        throw new Exception('Не указан код инфоблока');
    }

    /**
     * Устанавливает базовые свойства товара в корзине
     * выполняется при создании
     *
     * @param array $props
     * @return void
     * @see BaseBasketItem::create()
     */
    protected function setBaseProperties(array $props): void
    { }
}