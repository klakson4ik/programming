<?php

namespace App\Services\SitemapService;

use App\Models\Product;
use App\Models\Cosmetology;


class LocAction
{
	private static $products = false;
	private static $cosmetology = false;

	public static function offer(mixed $element): string
	{
		if (!self::$products) {
			$tmp = Product::getItemsArray(columns: ['id', 'url']);
			foreach ($tmp as $value) {
				self::$products[$value['id']] = $value['url'];
			}
		}

		if (!empty($element['product_id'])) return '';

		return self::$products[$element['product_id']] . '/' . $element['url'];
	}

	public static function cosmetology(mixed $element): string
	{
		if (!self::$cosmetology) {
			$tmp = Cosmetology::getItemsArray(columns: ['id', 'code']);
			foreach ($tmp as $value) {
				self::$cosmetology[$value['id']] = $value['code'];
			}
		}

		return self::$cosmetology[$element['id']] . '/' . $element['url'];
	}
}
