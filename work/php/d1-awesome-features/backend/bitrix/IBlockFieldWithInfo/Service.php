<?php

namespace App\Bitrix\PropertyFields\IBlockFieldWithInfo;

use Bitrix\Highloadblock\HighloadBlockTable;

class Service
{
	public static function getElements(array|false $ids = false, array $property = [], string $iblockID): array|false
	{
		$arFilter = array('IBLOCK_ID' => $iblockID, 'ACTIVE' => 'Y', 'ID' => $ids);
		$arSelect = array_merge(['IBLOCK_ID', 'ID'], self::getRealProps($property));
		$arElems = \CIBlockElement::GetList(arFilter: $arFilter, arSelectFields: $arSelect);
		$result = [];
		while ($ob = $arElems->GetNextElement()) {
			$fields = $ob->GetFields();
			$result[$fields['ID']] = $fields;
		}

		return $result;
	}

	public static function getPropsString(array|false $props, array|false $elem = false, string $delimiter): string
	{
		if (!$elem) {
			return '';
		}
		$data = array_map(fn ($prop) => PropertyAction::getData($prop, $elem), $props);

		return implode($delimiter, $data);
	}

	public static function getHtmlElement(string $prop, string|false $key, string $linkIblockId, string $tableId, array|false $element = false, array|false $propView = false,  string $value = '', string $delimiter = ' | '): string
	{
		$fixIBlock = $linkIblockId > 0;
		$html = '<div class="b-iblock-element-with-info__elem">';
		$html .= '<input type="text" name="' . $prop . ($key ? '[' . $key . ']' : '') . '" id="' . $prop . '[' . $key . ']" value="' . $value . '">' .
			'<input type="button" value="..." onClick="jsUtils.OpenWindow(\'/bitrix/admin/iblock_element_search.php?lang=' . LANGUAGE_ID . '&amp;IBLOCK_ID=' . $linkIblockId . '&amp;n=' . $prop . '&amp;k=' . $key . ($fixIBlock ? '&amp;iblockfix=y' : '') . '&amp;tableId=' . $tableId . '\', 1200, 900);">' .
			'&nbsp;<span id="sp_' . $tableId . '_' . $key . '">' . self::getPropsString($propView, $element, $delimiter) . '</span>';
		$html .= '</div>';
		return $html;
	}

	public static function getHBlockEntity(string $id)
	{
		$hlblock = HighloadBlockTable::getById($id)->fetch();
		return HighloadBlockTable::compileEntity($hlblock)->getDataClass();
	}

	private static function getRealProps(array $props): array
	{
		return array_map(
			fn ($prop) =>
			str_contains($prop, 'PROPERTY')
				? explode(':', $prop)[0]
				: $prop,
			$props
		);
	}
}
