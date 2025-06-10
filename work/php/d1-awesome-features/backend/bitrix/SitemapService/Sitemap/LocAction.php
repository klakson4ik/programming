<?php

namespace App\Services\Sitemap;

use App\Models\IBlocks\CatalogCategory;
use App\Models\IBlocks\CatalogCollection;
use App\Models\IBlocks\CatalogProduct;
use CUtil;

class LocAction
{
	private static array $collection = [];
	private static array $catalogCategory = [];

	public static function storelocator(array $fields, array $props): string
	{
		$arParams = array("replace_space" => "-", "replace_other" => "-");
		$region = CUtil::translit($props['region']['VALUE'], "ru", $arParams);
		$city = CUtil::translit($props['city']['VALUE'], "ru", $arParams);
		return '/' . $fields['IBLOCK_CODE'] . '/' . $region . '/' . $city . '/' . $fields['CODE'] . '/';
	}

	public static function catalogCategory(array $fields, array $props): string
	{
		if (empty(self::$catalogCategory)) {
			$result = CatalogCategory::select(
				['=ACTIVE' => ''],
				['PROPERTY_url', 'PROPERTY_rels_url']
			);
			foreach ($result as $value) {
				self::$catalogCategory[$value['ID']] = $value;
			}
		}
		return CatalogCategory::urlByCategory(self::$catalogCategory[$fields['ID']]);
	}

	public static function catalog(array $fields, array $props): string|false
	{
		if (empty(self::$collection)) {
			$select = [
				'IBLIOCK_ID',
				'ID',
				'CODE'
			];

			$data = CatalogCollection::select(
				['=ACTIVE' => ''],
				$select
			);

			foreach ($data as $item) {
				self::$collection[$item['ID']] = $item['CODE'];
			}
		}

		$collectonID = $props['collection']['VALUE'];
		if (self::$collection[$collectonID] === null) {
			return false;
		}

		return CatalogProduct::url(self::$collection[$collectonID], $fields['CODE']);
	}
}
