<?php

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

use Bitrix\Main\Page\Asset;

trait AssetTrait
{
	public const ASSETS_PATH = '/local/lib/Bitrix/PropertyFields/IBlockElementWithInfo/assets/';

	protected static function addAssets(): void
	{
		Asset::getInstance()->addJs(self::ASSETS_PATH . 'script.js', true);
	}
}
