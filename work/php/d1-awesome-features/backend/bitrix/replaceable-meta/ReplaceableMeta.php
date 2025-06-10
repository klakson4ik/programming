<?php

namespace App\Services;

class ReplaceableMeta
{
	private static array $properties;

	public static function get(string|int $iblockId, string|int $itemId, array $replaceArr): array
	{
		return self::create($iblockId, $itemId, $replaceArr);
	}

	public static function getSection(string|int $iblockId, string|int $itemId, array $replaceArr): array
	{
		return self::create($iblockId, $itemId, $replaceArr, true);
	}

	public static function set(string|int $iblockId, string|int $itemId, array $replaceArr): void
	{
		self::$properties = self::create($iblockId, $itemId, $replaceArr);
		self::setMeta();
	}

	public static function init(string|int $iblockId, string|int $itemId, array $replaceArr): void
	{
		self::$properties = self::create($iblockId, $itemId, $replaceArr);
	}

	public static function setMeta(): void
	{
		self::setMetaTitle();
		self::setMetaDescription();
	}

	public static function setPageTitle(): void
	{
		global $APPLICATION;
		$APPLICATION->SetTitle('title', self::$properties['ELEMENT_PAGE_TITLE']);
	}

	public static function setMetaTitle(): void
	{
		global $APPLICATION;
		$APPLICATION->SetPageProperty('title', self::$properties['ELEMENT_META_TITLE']);
	}

	public static function setMetaDescription(): void
	{
		global $APPLICATION;
		$APPLICATION->SetPageProperty('description', self::$properties['ELEMENT_META_DESCRIPTION']);
	}

	public static function setMetaKeywords(): void
	{
		global $APPLICATION;
		$APPLICATION->SetPageProperty('keywords', self::$properties['ELEMENT_META_KEYWORDS']);
	}

	private static function create(string|int $iblockId, string|int $itemId, array $replaceArr, bool $section = false): array
	{
		if ($section) {
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues($iblockId, $itemId);
		} else {
			$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($iblockId, $itemId);
		}
		self::$properties  = $ipropValues->getValues();
		return self::replace($replaceArr);
	}

	private static function replace(array $replaceArr): array
	{
		$result = [];
		foreach ($replaceArr as $key => $elem) {
			$str = self::$properties[$key];
			foreach ($elem as $pattern => $replacement) {
				$str = preg_replace("/\#" . $pattern . "\#/", $replacement, $str);
			}
			$result[$key] = $str;
		}

		return $result;
	}
}
