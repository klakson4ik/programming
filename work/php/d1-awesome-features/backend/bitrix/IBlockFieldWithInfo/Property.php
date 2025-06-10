<?php

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

use Bitrix\Iblock\PropertyTable;
use CIBlockPropertyElementList;

class Property extends CIBlockPropertyElementList
{
	use AssetTrait;

	public static function GetUserTypeDescription(): array
	{
		return [
			"USER_TYPE_ID" => 'techart_iblock_element_with_info',
			'PROPERTY_TYPE' => PropertyTable::TYPE_ELEMENT,
			'USER_TYPE' => PropertyTable::USER_TYPE_ELEMENT_LIST,
			"DESCRIPTION" => 'Привязка к инфоблоку с выводом дополнительной информации',
			'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
			'GetPropertyFieldHtmlMulty' => [__CLASS__, 'GetPropertyFieldHtmlMulty'],
			'PrepareSettings' => [__CLASS__, 'PrepareSettings'],
			'GetSettingsHTML' => [__CLASS__, 'GetSettingsHTML'],
		];
	}

	public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
	{
		self::addAssets();

		$tableId = 'tb-' . md5($arProperty['NAME']);
		$prop = $strHTMLControlName['VALUE'];
		$propView = array_map(fn ($item) => trim($item), explode(',', $arProperty['USER_TYPE_SETTINGS']['fields']));
		$element = reset(Service::getElements([$value['VALUE']], $propView, $arProperty['LINK_IBLOCK_ID']));
		$delimiter = $arProperty['USER_TYPE_SETTINGS']['delimiter'] ?: ' | ';

		$html = '<div id="' . $tableId . '" class="b-iblock-element-with-info__container" data-iblock-id="' . $arProperty['LINK_IBLOCK_ID'] . '" data-props="' . implode(',', $propView) . '" data-delimiter="' . $delimiter . '">';
		$html .= '<div id="' . $tableId . '" class="b-iblock-element-with-info__list">';

		if ($value['VALUE']) {
			$html .= Service::getHtmlElement(
				$prop,
				false,
				$arProperty['LINK_IBLOCK_ID'],
				$tableId,
				$element,
				$propView,
				$value['VALUE'],
				$delimiter
			);
		} else {
			$html .= Service::getHtmlElement(
				$prop,
				false,
				$arProperty['LINK_IBLOCK_ID'],
				$tableId,
			);
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	public static function GetPropertyFieldHtmlMulty($arProperty, $value, $strHTMLControlName)
	{
		self::addAssets();

		$tableId = 'tb-' . md5($arProperty['NAME']);
		$prop = $strHTMLControlName['VALUE'];
		$propView = array_map(fn ($item) => trim($item), explode(',', $arProperty['USER_TYPE_SETTINGS']['fields']));
		$ids = array_map(fn ($item) => $item['VALUE'], $value);
		$elements = Service::getElements($ids, $propView, $arProperty['LINK_IBLOCK_ID']);

		$delimiter = $arProperty['USER_TYPE_SETTINGS']['delimiter'] ?: ' | ';

		$html = '<div id="' . $tableId . '" class="b-iblock-element-with-info__container" data-iblock-id="' . $arProperty['LINK_IBLOCK_ID'] . '" data-props="' . implode(',', $propView) . '" data-delimiter="' . $delimiter . '">';
		$html .= '<div id="' . $tableId . '" class="b-iblock-element-with-info__list">';

		if ($value) {
			foreach ($value as $key => $item) {
				if ($elements[$item['VALUE']]) {
					$html .= Service::getHtmlElement(
						$prop,
						$key,
						$arProperty['LINK_IBLOCK_ID'],
						$tableId,
						$elements[$item['VALUE']],
						$propView,
						$item['VALUE'],
						$delimiter
					);
				}
			}
		} else {
			$html .= Service::getHtmlElement(
				$prop,
				'n0',
				$arProperty['LINK_IBLOCK_ID'],
				$tableId,
			);
		}
		$html .= '</div>';

		$html .= '<input type="button" value="Добавить" onClick="addRowWithInfo(\'' . $tableId . '\',' . count($value) . ',\'' . $prop . '\')">';
		$html .= '</div>';

		return $html;
	}

	public static function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
	{
		$settings = self::PrepareSettings($arProperty);

		$arPropertyFields = [
			'HIDE' => [
				'ROW_COUNT',
				'COL_COUNT',
				'MULTIPLE_CNT',
			],
		];

		return '
		<tr valign="top">
			<td><img src="/bitrix/js/main/core/images/hint.gif" style="margin-left: 5px;" title="' . Info::get() . '"> Поля для отображения:</td>
			<td><input type="text" size="50" name="' . $strHTMLControlName["NAME"] . '[fields]" value="' . $settings['fields'] . '", placeholder="NAME, PROPERTY_EXAMPLE"></td>
		</tr>
		<tr valign="top">
		<td>Разделитель:</td>
		<td><input type="text" size="5" name="' . $strHTMLControlName["NAME"] . '[delimiter]" value="' . $settings['delimiter'] . '" placeholder=" | "></td>
	</tr>
		';
	}

	public static function PrepareSettings($arProperty)
	{
		return [
			'fields' => $arProperty['USER_TYPE_SETTINGS']['fields'] ?? '',
			'delimiter' => $arProperty['USER_TYPE_SETTINGS']['delimiter'] ?? ''
		];
	}
}
