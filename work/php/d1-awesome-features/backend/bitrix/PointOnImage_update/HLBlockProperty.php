<?php

namespace App\Bitrix\Fields\PointOnImage;

use Bitrix\Main\UserField\Types\StringType;
use CUserTypeManager;

class HLBlockProperty extends StringType
{
	use FieldTrait;

	public const USER_TYPE_ID = 'images_point';

	public static function getDescription(): array
	{
		return [
			'USER_TYPE_ID' => static::USER_TYPE_ID,
			'CLASS_NAME' => __CLASS__,
			'DESCRIPTION' => "Точки на изображении",
			'BASE_TYPE' => CUserTypeManager::BASE_TYPE_STRING,
		];
	}

	public static function getDbColumnType(): string
	{
		return 'text';
	}

	public static function getEditFormHTML($userField, $additionalParameters): string
	{
		$value = self::unserialize_from_html($additionalParameters['VALUE']);

		return self::addAssets() . self::render($value, $userField['ID'], $additionalParameters['NAME']);
	}

	public static function onBeforeSave($userField, $value): string
	{
		return self::serialize($userField['ID'], $value);
	}
}