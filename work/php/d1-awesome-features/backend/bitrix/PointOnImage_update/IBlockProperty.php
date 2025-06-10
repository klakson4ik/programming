<?php

namespace App\Bitrix\Fields\PointOnImage;

class IBlockProperty
{
	use FieldTrait;

	public const USER_TYPE = 'image-points';

    public static function GetUserTypeDescription(): array
    {
        return [
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => self::USER_TYPE,
            "DESCRIPTION" => "Точки на изображении",
            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
            'ConvertToDB' => [__CLASS__, 'ConvertToDB'],

		];
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName): string
    {
		$value = unserialize($value['VALUE']);

		return self::addAssets() . self::render($value, $arProperty['ID'], $strHTMLControlName['VALUE']);
    }

	public static function ConvertToDB($arProperty, $value): string
	{
		return self::serialize($arProperty['ID'], $value['VALUE']);
	}
}
