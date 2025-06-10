<?php

namespace App\Bundle\Basket\Service\Savage;

use App\Bundle\Basket\Interfaces\Basket;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\NotImplementedException;
use App\Bundle\Basket\Service\Base\BaseBasket;

/**
 * Реализация корзины для сайта savage
 *
 * @method SavageBasketItem[] getItems
 * @see BaseBasket
 */
class SavageBasket extends BaseBasket implements Basket
{
    protected string $basketItemClass = SavageBasketItem::class;

    /**
     * Добавляет товар в корзину, предварительно добавляя размер как обязательное свойство в корзине
     *
     * @param int $product_id
     * @param int $quantity
     * @param array $fields
     * @param array $props
     * @return object
     * @throws ArgumentException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @see BaseBasket::addProduct()
     */
    public function addProduct(int $product_id, int $quantity = 1, array $fields = [], array $props = []): object
    {
        $props = array_merge(['RAZMER'], $props);

        return parent::addProduct($product_id, $quantity, $fields, $props);
    }
}