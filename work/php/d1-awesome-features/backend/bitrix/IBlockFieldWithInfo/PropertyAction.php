<?php

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

class PropertyAction
{
	private static $propArr;
	private static $elem;

	private static function choice()
	{
		return match (self::$propArr[1]) {
			'H' => self::hBlockElem(),
		};
	}

	public static function getData(string $prop, array $elem)
	{
		self::$propArr = explode(':', $prop);
		self::$elem = $elem;
		return count(self::$propArr) === 1
			? self::returnDefault()
			: self::choice();
	}

	private static function returnDefault(): string
	{
		return str_contains(self::$propArr[0], 'PROPERTY')
			? self::$elem[self::$propArr[0] . '_VALUE']
			: self::$elem[self::$propArr[0]];
	}


	private static function hBlockElem()
	{
		if (count(self::$propArr) === 4) {
			$hBlock = Service::getHBlockEntity(self::$propArr[2]);
			return $hBlock::getList(array(
				"select" => [self::$propArr[3]],
				"filter" => ['UF_XML_ID' => self::$elem[self::$propArr[0] . '_VALUE']]
			))->fetch()[self::$propArr[3]];
		} else {
			return self::returnDefault();
		}
	}
}
