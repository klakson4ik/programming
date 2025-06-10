<?php

namespace App\Bundle\Basket\Service\Base;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use Bitrix\Sale\BasketBase;
use Bitrix\Sale\Order;
use CUser;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Registry;
use Bitrix\Sale\DiscountCouponsManager;
use Bitrix\Sale\Basket as BitrixBasket;
use App\Bundle\Basket\Interfaces\Basket;
use App\Bundle\Basket\Interfaces\BasketItem;
use Exception;

/**
 * Базовый класс для работы с корзиной битрикса
 *
 * @see BasketBase
 */
class BaseBasket implements Basket
{
    /**
     * Битриксовый объект корзины
     *
     * @var BasketBase
     */
    public BasketBase $bitrix_basket;

    /**
     * Инстанс данного класса(синглтон)
     *
     * @var static|null
     */
    protected static $_instance = null;

    /**
     * Битриксовый объект заказа, без него невозможно применить скидки
     *
     * @var object|null
     */
    protected ?object $bitrix_order = null;

    /**
     * FUserId пользователя
     *
     * @var int
     * @see Fuser
     */
    protected int $user_id;

    /**
     * Неймспейс объекта для работы с товаром в корзине.
     * Должен реализоавать интерфейс Basket\Support\Interfaces\BasketItem
     *
     * @var string
     * @see BasketItem
     */
    protected string $basketItemClass = BaseBasketItem::class;

    /**
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @throws SystemException
     */
    public function __construct()
    {
        global $USER;

        $this->user_id = ($USER instanceof CUser && (int)$USER->GetID() > 0) ? (int)Fuser::getIdByUserId($USER->GetID()) : (int)Fuser::getId();

        $this->loadBitrixBasketByFUser();
        $this->initializeBitrixOrder();
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return static::$_instance ??= new static();
    }

    /**
     * Применяет купон к корзине пользователя
     * при указании true вторго аргумента ощущесвляет проверку купона на сущесвовании
     * (да,да в битриксе можно применить не сущесвующий купон)
     * После применения купона приходится получать инстанс корзины заного, иначе данные не обновляются
     *
     * @param string $coupon
     * @param bool $check
     * @return bool
     * @throws Exception
     * @see DiscountCouponsManager
     * @see reload()
     */
    public function addCoupon(string $coupon, bool $check = true): bool
    {
        if ($check && !$this->checkCouponExist($coupon)) {
            throw new Exception('Купон - ' . $coupon . 'не найден');
        }

        $res = DiscountCouponsManager::add($coupon);
        $this->couponFinalAction();

        if ($res) {
            $this->reload();
        }

        return $res;
    }

    /**
     * Работает как addCoupon, только удаляет купон
     *
     * @param string $coupon
     * @param bool $check
     * @return bool
     * @throws Exception
     * @see DiscountCouponsManager
     * @see addCoupon()
     * @see reload()
     */
    public function removeCoupon(string $coupon, bool $check = true): bool
    {
        if ($check && !$this->checkCouponExist($coupon)) {
            throw new Exception('Купон - ' . $coupon . 'не найден');
        }

        $res = DiscountCouponsManager::delete($coupon);
        $this->couponFinalAction();

        if ($res) {
            $this->reload();
        }

        return $res;
    }

    /**
     * Удаляет применение всех купонв в корзине
     *
     * @return void
     * @see DiscountCouponsManager
     * @see reload()
     */
    public function clearCoupons(): void
    {
        DiscountCouponsManager::clear(true);
        $this->couponFinalAction();
        $this->reload();
    }

    /**
     * Возвращет массив объектов товаров к корзине
     *
     * @return BasketItem[]
     * @see BasketItem
     */
    public function getItems(): array
    {
        return array_map(function ($bitrix_item) {
            return new $this->basketItemClass($bitrix_item);
        }, $this->bitrix_basket->getBasketItems());
    }

    /**
     * Возвращает массив с данными о каждом товаре в корзине
     *
     * @return array
     */
    public function getItemsArray(): array
    {
        return array_map(function ($bitrix_item) {
            $item = new $this->basketItemClass($bitrix_item);

            return $item->toArray();
        }, $this->bitrix_basket->getBasketItems());
    }

    /**
     * Возращает массив данных о корзине(включая товары и скидки)
     *
     * @return array
     */
    public function getBasketArray(): array
    {
        return $this->bitrix_basket->toArray();
    }

    /**
     * Возвращает массив содержащйи количесво позиций(и товаров в них) в корзине
     * @example array(3) { [11]=> float(2) [12]=> float(1) }
     *
     * @return array
     * @throws ArgumentNullException
     */
    public function getPositionsList(): array
    {
        return $this->bitrix_basket->getQuantityList();
    }

    /**
     * Возвращает количесво  товаров в корзине
     *
     * @return float|int
     * @throws ArgumentNullException
     */
    public function getItemsCount(): float|int
    {
        return array_sum($this->getPositionsList());
    }

    /**
     * Возвращает количество позиций в корзине
     *
     * @return int
     * @throws ArgumentNullException
     */
    public function getPositionsCount(): int
    {
        return count($this->getPositionsList());
    }

    /**
     * Возвращает общий вес всех товаров в корзине
     *
     * @return float|int
     */
    public function getWeight(): float|int
    {
        return $this->bitrix_basket->getWeight();
    }

    /**
     * Добавляет несколько товаров в корзину
     *
     * @param array $products может содержать просто id торговых предложений
     * Или содержать массивы с данными под каждый товар
     *
     * @return void
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @example $products = [1234,543,43456]
     * @example $products = [
     *      ['id' => 43242, 'quantity' => 2, 'props' => (array)],
     *      ['id' => 543, 'quantity' => 1, 'props' => (array)],
     * ]
     *
     * @see addProduct()
     */
    public function addProducts(array $products): void
    {
        foreach ($products as $product) {
            if (!is_array($product)) {
                $this->addProduct($product);
            } else {
                $this->addProduct($product['id'], $product['quantity'], $product['props']);
            }
        }
    }

    /**
     * Добавляет товар в корзину, обязательно необходимо передавать id торгового предложения
     *
     * @param int $product_id
     * @param int $quantity
     * @param array $fields
     * @param array $props
     * @return mixed
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     */
    public function addProduct(int $product_id, int $quantity = 1, array $fields = [], array $props = []): object
    {
        $bitrix_item = $this->getExistsBasketItemByProductId($product_id);

        if ($bitrix_item) {
            $item = new $this->basketItemClass($bitrix_item);
            return $item->setQuantity($item->quantity + $quantity);
        }

        $bitrix_item = $this->bitrix_basket->createItem('catalog', $product_id);
        $item = new $this->basketItemClass($bitrix_item);
        return $item->create($quantity, $fields, $props);
    }

    /**
     * Очищает корзину, удаляя все товары
     *
     * @return void
     */
    public function clear(): void
    {
        foreach ($this->getItems() as $basket_item) {
            $basket_item->delete();
        }
    }

    /**
     * Удаляет из корзины товары с id из переданного массива
     * Внимание - id товаров в корзине, для удаления по id продкутов(тп)
     * воспользуйтесь removeItemsByProductId
     *
     * @param array $ids
     * @return void
     * @see removeItemById()
     */
    public function removeItemsById(array $ids): void
    {
        foreach ($ids as $id) {
            $this->removeItemById($id);
        }
    }

    /**
     * Работает аналогичено removeItemsById, только принимает массив id товаров(торговых предложений) в инфоблоке
     *
     * @param array $products_ids
     * @return void
     * @see removeItemByProductId
     */
    public function removeItemsByProductId(array $products_ids): void
    {
        foreach ($products_ids as $id) {
            $this->removeItemByProductId($id);
        }
    }

    /**
     * Изменяет количесво товара в корзине
     * Внимание - принимает id товара в корзине
     * Для изменения по id товара в инфоблоке воспользуейтесь changeItemQuantityByProductId
     *
     * @param int $id
     * @param int $quantity
     * @return object
     * @see getItemById
     * @see changeItemQuantity
     */
    public function changeItemQuantityById(int $id, int $quantity): array
    {
        $item = $this->getItemById($id);

        return [
            'result' => $this->changeItemQuantity($item, $quantity),
            'item' => $item
        ];
    }

    /**
     * Работает аналогичено changeItemQuantityById, только принимает id товара(торговых предложений) в инфоблоке
     *
     * @param int $product_id
     * @param int $quantity
     * @return array
     * @see getItemByProductId
     * @see changeItemQuantity
     */
    public function changeItemQuantityByProductId(int $product_id, int $quantity): array
    {
        $item = $this->getItemByProductId($product_id);

        return [
            'result' => $this->changeItemQuantity($item, $quantity),
            'item' => $item
        ];
    }

    /**
     * Удаляет товар в корзине
     * Внимание - принимает id товара в корзине
     * Для удаления по id товара в инфоблоке воспользуейтесь removeItemByProductId
     *
     * @param int $id
     * @return object
     * @see getItemById
     * @see removeItem
     */
    public function removeItemById(int $id): object
    {
        $item = $this->getItemById($id);

        return $this->removeItem($item);
    }

    /**
     * Работает аналогичено removeItemById, только принимает id товара(торговых предложений) в инфоблоке
     *
     * @param int $product_id
     * @return object
     * @see getItemByProductId
     * @see removeItem
     */
    public function removeItemByProductId(int $product_id): object
    {
        $item = $this->getItemByProductId($product_id);

        return $this->removeItem($item);
    }

    /**
     * Сохраняет корзину
     *
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws NotImplementedException
     * @throws ObjectNotFoundException
     */
    public function save(): void
    {
        $this->bitrix_basket->save();
    }

    /**
     * Возвращает базовую (без применения скидок и пр.) цену стоимости всех товаров в корзинне
     *
     * @return float|int
     * @throws ArgumentNullException
     */
    public function getBasePrice(): float|int
    {
        return $this->bitrix_basket->getBasePrice();
    }

    /**
     * Возвращает цену стоимости всех товаров в корзинне, учитывая применненные скидки
     *
     * @return float|int
     * @throws ArgumentNullException
     */
    public function getPrice(): float|int
    {
        return $this->bitrix_basket->getPrice();
    }

    /**
     * Устанавливает объект битриксовой корзины, получанный у FUser
     *
     * @return void
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @see BitrixBasket
     * @see Fuser
     */
    public function loadBitrixBasketByFUser(): void
    {
        $this->bitrix_basket = BitrixBasket::loadItemsForFUser($this->user_id, SITE_ID);
    }

    /**
     * Устанавливает объект битриксовой корзины, полученный из заказа
     *
     * @param string|int $order_id
     * @return void
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @see BitrixBasket
     * @see Order
     */
    public function loadBitrixBasketByOrderId(string|int $order_id): void
    {
        $this->bitrix_basket = BitrixBasket::loadItemsForOrder(Order::load($order_id));
    }

    /**
     * Обновляет все поля корзины
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->bitrix_basket->refresh();
    }

    /**
     * Обновляет переданные данные корзины
     *
     * @param array $fields
     * @return void
     * @throws ArgumentNullException
     */
    public function refreshData(array $fields): void
    {
        $this->bitrix_basket->refreshData($fields);
    }

    /**
     * Получает заного инстанст объекта, что дает получение акутальных данных
     * Требуется для работы с купонами (да да костыль)
     *
     * @return void
     */
    public function reload(): void
    {
        static::$_instance = new static();
    }

    /**
     * Возращает объект для работы с элементов корзины по id товара в инфоблоке
     *
     * @param int $product_id
     * @return BasketItem
     * @see basketItemClass
     * @see getExistsBasketItemByProductId
     */
    public function getItemByProductId(int $product_id): BasketItem
    {
        $bitrix_item = $this->getExistsBasketItemByProductId($product_id);

        return new $this->basketItemClass($bitrix_item);
    }

    /**
     * Возращает объект для работы с элементов корзины по id товара в корзине
     *
     * @param int $id
     * @return BasketItem
     * @throws ArgumentNullException
     * @see basketItemClass
     */
    public function getItemById(int $id): BasketItem
    {
        return new $this->basketItemClass($this->bitrix_basket->getItemById($id));
    }

    /**
     * Возвращает массив данных о корзине, включая цены, купоны, товары, вес и т.д.
     *
     * @return array
     * @throws ArgumentNullException
     */
    public function toArray(): array
    {
        return [
            'items' => $this->getItemsArray(),
            'price' => $this->getPrice(),
            'base_price' => $this->getBasePrice(),
            'count' => $this->getItemsCount(),
            'weight' => $this->getWeight(),
            'coupons' => $this->getAppliedCoupons(true)
        ];
    }

    /**
     * Возвращает применненные к корзине купоны
     * При перелачи аргумента как true, возвращает детальную инофрмацию о купоне
     * Иначе возвращает только сам купон(стрку)
     *
     * @param bool $with_data
     * @return array - массив примененных купонов
     */
    public function getAppliedCoupons(bool $with_data = false): array
    {
        return array_values(DiscountCouponsManager::get($with_data));
    }

    /**
     * Проверяет существует ли купон
     *
     * @param string $coupon
     * @return array|false
     */
    protected function checkCouponExist(string $coupon): array|false
    {
        return DiscountCouponsManager::isExist($coupon);
    }

    /**
     * Изменяет количесво товара в корзине
     *
     * @param BasketItem $item
     * @param int $quantity
     * @return object
     * @see BasketItem::setQuantity()
     */
    protected function changeItemQuantity(BasketItem $item, int $quantity): object
    {
        return $item->setQuantity($quantity);
    }

    /**
     * Удаляет товар из корзины
     *
     * @param BasketItem $item
     * @return object
     * @see BasketItem::delete()
     */
    protected function removeItem(BasketItem $item): object
    {
        return $item->delete();
    }

    /**
     * Проводит действия необходимые для применения купона
     *
     * @return void
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    protected function couponFinalAction(): void
    {
        $this->refreshData(['PRICE', 'COUPONS']);
        $result = $this->bitrix_order->getDiscount()->calculate();
        $this->bitrix_basket->applyDiscount($result->getData());
    }

    /**
     * Возвращает битриксовый объект товара в корзине, найденный по id товара в инфоблоке
     *
     * @param int $product_id
     * @return object|false
     * @see BasketItemBase
     */
    protected function getExistsBasketItemByProductId(int $product_id): object|false
    {
        if ($product_id > 0) {
            foreach ($this->bitrix_basket->getBasketItems() as $basket_item) {
                if ($basket_item->getProductId() === $product_id) {
                    return $basket_item;
                }
            }
        }

        return false;
    }

    /**
     * Создает заказ под данную корзину, необходимо для применения купонов
     *
     * @return void
     * @throws ArgumentException
     * @throws SystemException
     */
    protected function initializeBitrixOrder(): void
    {
        $order_class = $this->getOrderClass();
        $order = $order_class::create(SITE_ID, $this->user_id);
        $order->setBasket($this->bitrix_basket);

        $this->bitrix_basket->setOrder($order);
        $this->bitrix_order = $order;
    }

    /**
     * Создает битриксовый объект заказа
     *
     * @return object
     * @throws ArgumentException
     * @throws SystemException
     */
    protected function createOrder(): object
    {
        $order_class = $this->getOrderClass();
        $order = $order_class::create(SITE_ID, $this->user_id);
        $order->setBasket($this->bitrix_basket);
        $order->save();

        return $order;
    }

    /**
     * Возвращает класс для работы с заказом
     *
     * @return mixed
     * @throws ArgumentException
     * @throws SystemException
     */
    protected function getOrderClass(): mixed
    {
        $registry = Registry::getInstance(Registry::REGISTRY_TYPE_ORDER);
        return $registry->getOrderClassName();
    }
}