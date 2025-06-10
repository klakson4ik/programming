<?php

namespace App\Bundle\Basket\Service\Savage;

use App\Bundle\Basket\Interfaces\BasketItem;
use App\Bundle\Basket\Service\Base\BaseBasketItem;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\NotImplementedException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectNotFoundException;
use Exception;
use TAO;


/**
 * Класс товара в корзине для сайта savage
 *
 * @property int $size
 * @property string $article
 * @property string $image
 * @see BaseBasketItem
 */
class SavageBasketItem extends BaseBasketItem implements BasketItem
{
    public string $iblock_code = 'savage_offers';

    /**
     * При создании товара устанавливает свойства: размер
     *
     * @param array $props
     * @return void
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ArgumentTypeException
     * @throws NotImplementedException
     * @throws NotSupportedException
     * @throws ObjectNotFoundException
     * @see BaseBasketItem::setBaseProperties()
     */
    protected function setBaseProperties(array $props): void
    {
        $iblock_item = $this->getIblockItemByProductId($this->product_id);

        foreach ($props as $property_code) {
            $property = $iblock_item->property($property_code);

            if ($property) {
                $value = $property->value();

                if ($property->type() === 'directory') {
                    $value = $value['UF_NAME'];
                }

                $this->setProperty([
                    'CODE' => $property_code,
                    'SORT' => 100,
                    'NAME' => $property->title(),
                    'VALUE' => $value,
                ]);
            }
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'size' => $this->size,
            'image' => $this->image,
            'article' => $this->article,
        ]);
    }

    public function __get(string $property)
    {
        return match ($property) {
            'size' => $this->getSize(),
            'image' => $this->getProductImage(),
            'article' => $this->getArticle(),
            default => parent::__get($property),
        };
    }

    /**
     * Возвращает размер товара(свйоство торгового предложения)
     *
     * @return int
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws NotImplementedException
     * @throws ObjectNotFoundException
     */
    public function getSize(): int
    {
        $property = $this->getPropertyByCode('RAZMER');

        return (int)$property['VALUE'];
    }

    /**
     * Возвращает артикул товара.
     * Артикул указывается у товара, а не у торгового предложения
     *
     * @return string
     * @throws Exception
     */
    public function getArticle(): string
    {
        $sku_item = $this->getIblockItemByProductId($this->product_id);
        $product = TAO::infoblock('savage')->loadItem($sku_item->property('CML2_LINK')->value());

        return $product->property('CML2_ARTICLE')->value();
    }

    /**
     * Возвращает ссылку на изображение товара
     * Изображение указывается у товара, а не у торгового предложения
     *
     * @return string
     * @throws Exception
     */
    public function getProductImage(): string
    {
        $sku_item = $this->getIblockItemByProductId($this->product_id);
        $product = TAO::infoblock('savage')->loadItem($sku_item->property('CML2_LINK')->value());

        return current($product->property('MORE_PHOTO')->value())->url();
    }
}