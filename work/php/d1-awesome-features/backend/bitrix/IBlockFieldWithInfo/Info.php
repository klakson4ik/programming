<?php

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

class Info
{
	public static function get(): string
	{
		$text = 'Через запятую, порядок важен' . PHP_EOL;
		$text .= 'PROPERTY_EX:H:52:UF_NAME' . PHP_EOL;
		$text .= 'PROPERTY_EX - свойство, H - работа с highblock, 52 - id highblock, UF_NAME - выводить имя';

		return $text;
	}
}
