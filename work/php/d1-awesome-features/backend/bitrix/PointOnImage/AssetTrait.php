<?php

namespace App\Bitrix\PropertyFields\PointOnImage;

use Bitrix\Main\Page\Asset;

trait AssetTrait
{
	public const ASSETS_PATH = '/local/lib/Bitrix/PropertyFields/PointOnImage/assets/';

	protected static function addAssets(): string
	{
		Asset::getInstance()->addJs(self::ASSETS_PATH . 'script.js', true);

		return '<link rel="stylesheet" media="screen" type="text/css" href="' . self::ASSETS_PATH .'style.css?v='. md5(date("h:i:s")) .'" />';
	}
}

