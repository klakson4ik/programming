<?php

namespace App\Models\Base;

use Bitrix\Iblock\InheritedProperty\ElementValues;
use Bitrix\Iblock\InheritedProperty\IblockValues;
use Bitrix\Iblock\InheritedProperty\SectionValues;
use Bitrix\Main\SiteTable;
use Bitrix\Main\Context;
use CIBlock;
use CIBlockElement;
use CIBlockProperty;
use CIBlockResult;
use CIBlockSection;

abstract class IBlockModel
{
	/**
	 * @var string Символьный код инфоблока
	 */
	protected static string $code = '';
	protected static array $entities = [];
	public static string $lastAddError = '';

	public static function add(array $params = []): bool|int
	{
		if (!static::$code || !$params) {
			return false;
		}

		$iblock = new CIBlockElement();
		$data = static::make($params);

		$id = $iblock->Add(array_merge(
			['IBLOCK_ID' => static::getIBlockId()],
			$data
		));

		if (!$id) {
			static::$lastAddError = $iblock->LAST_ERROR;
		}

		return $id ?: false;
	}

	public static function update(array $params = []): bool
	{
		if (!isset($params['ID'])) {
			return false;
		}

		$params['IBLOCK_ID'] = static::getIBlockId();
		$ID = (int)$params['ID'];
		unset($params['ID']);

		if ($result = CIBlockElement::GetProperty(static::getIBlockId(), $ID)) {
			while ($property = $result->Fetch()) {
				$params['PROPERTY_VALUES'][$property['CODE']] =
					($needs_to_unset = isset($params[$property['CODE']]))
						? $params[$property['CODE']]
						: $property['VALUE'];

				if ($property['PROPERTY_TYPE'] == 'F' && $property['MULTIPLE'] == 'Y') {
					$params['PROPERTY_VALUES'][$property['CODE']] =
						($needs_to_unset = isset($params[$property['CODE']]))
							? $params[$property['CODE']]
							: null;
				}

				if ($needs_to_unset) {
					unset($params[$property['CODE']]);
				}
			}
		}

		$ib_element = new CIBlockElement;
		return $ib_element->Update($ID, $params);
	}

	public static function getIBlockId(): int
	{
		$IBlockData = self::getIblockData();

		return (int)$IBlockData['ID'];
	}

	public static function getIBlockType(): string
	{
		$IBlockData = self::getIblockData();

		return (string)$IBlockData['IBLOCK_TYPE_ID'];
	}

	public static function getCode(): string
	{
		return static::$code;
	}

	public static function getIblockData()
	{
		if (!isset(static::$entities[static::$code])) {
			$res = CIBlock::GetList([],[
				'SITE_ID' => self::getSiteID(),
				'ACTIVE' => 'Y',
				'CODE' => static::$code
			]);

			static::$entities[static::$code] = $res->Fetch();
		}

		return static::$entities[static::$code];
	}

	public static function find(array $filter = [], array $select = [], array $sort = []): false|array
	{
		$item = self::select($filter, $select, $sort, limit: 1);

		return reset($item);
	}

	public static function findById(int $id, array $select = []): false|array
	{
		if (!$id) {
			return false;
		}

		return self::find(['ID' => $id], $select);
	}

	public static function findByName(string $name, array $select = [], array $sort = []): false|array
	{
		if (!$name) {
			return false;
		}

		return self::find(['NAME' => $name], $select, $sort);
	}

	public static function findByCode(string $code, array $select = [], array $sort = []): false|array
	{
		if (!$code) {
			return false;
		}

		return self::find(['CODE' => $code], $select, $sort);
	}

	public static function getItemsAround(int $id, array $sort = [], array $filter = []): array
	{
		if (empty($sort)) {
			$sort = [
				'ID' => 'DESC'
			];
		}

		$items = self::select(
			$filter,
			sort: $sort,
			nav_params: [
				'nPageSize' => 1,
				'nElementID' => $id,
			]
		);

		$res = [];

		if (count($items) === 3) {
			$res['next'] = $items[0];
			$res['prev'] = $items[2];
		} elseif (count($items) === 2) {
			if ((int)$items[0]['ID'] !== $id) {
				$res['next'] = $items[0];
			} else {
				$res['prev'] = $items[1];
			}
		}

		return $res;
	}

	public static function count(array $filter = [], array $sort = [], array $nav_params = []): int
	{
		$res = self::selectItemsIterator($filter, select: ['ID'], sort: $sort, nav_params: $nav_params);

		return $res->SelectedRowsCount();
	}

	public static function select(
		array $filter = [],
		array $select = [],
		array $sort = [],
		int $limit = 0,
		int $page = 0,
		array $nav_params = [],
		bool|array $groupBy = false
	): array
	{
		$res = self::selectItemsIterator(...func_get_args());
		$items = [];

		while ($item = $res->Fetch()) {
			$items[] = $item;
		}

		return $items;
	}

	public static function countSection(array $filter = [], array $sort = [], array $nav_params = []): int
	{
		$res = self::selectSectionsIterator($filter, sort: $sort, nav_params: $nav_params);

		return $res->SelectedRowsCount();
	}

	public static function getSections(
		array $filter = [],
		array $select = [],
		array $sort = [],
		bool $count = false,
		int $limit = 0,
		int $page = 0,
		array $nav_params = [],
	): array {
		$res = self::selectSectionsIterator(...func_get_args());

		$items = [];

		while ($item = $res->Fetch()) {
			$items[] = $item;
		}

		return $items;
	}

	public static function findSection(array $filter = [], array $select = [], array $sort = [], bool $count = false): array|bool
	{
		$sections = self::getSections($filter, $select, $sort, $count, 1);

		return reset($sections);
	}

	public static function findSectionById(int $id, array $select = [], bool $count = false): bool|array
	{
		return self::findSection(['ID' => $id], select: $select, count: $count);
	}

	public static function findSectionByCode(string $code, array $select = [], bool $count = false): bool|array
	{
		return self::findSection(['CODE' => $code], select: $select, count: $count);
	}

	public static function getItemSeo(int $itemId): array
	{
		$values = new ElementValues(self::getIBlockId(), $itemId);

		return $values->getValues();
	}

	public static function getIblockSeo(): array
	{
		$values = new IblockValues(self::getIBlockId());

		return $values->getValues();
	}

	public static function getSectionSeo(int $sectionId): array
	{
		$values = new SectionValues(self::getIBlockId(), $sectionId);

		return $values->getValues();
	}

	public static function enumItemsProperty(string $code, array $filter = [], array $sort = []): array
	{
		$values = [];
		$filter = array_merge(['IBLOCK_ID' => self::getIBlockId()], $filter);
		$res = CIBlockProperty::GetPropertyEnum($code, $sort, $filter);

		while ($value = $res->Fetch()) {
			$values[$value['ID']] = $value;
		}

		return $values;
	}

	public static function getPropertyInfoByCode(string $code)
	{
		$properties = static::getPropertiesInfo(['CODE' => $code]);

		return reset($properties);
	}

	public static function getPropertiesInfo(array $filter = [], array $sort = []): array
	{
		$items = [];

		$data = CIBlock::GetProperties(static::getIBlockId(), $sort, $filter);

		while ($item = $data->Fetch()) {
			$items[] = $item;
		}

		return $items;
	}

	protected static function selectItemsIterator(
		array $filter = [],
		array $select = [],
		array $sort = [],
		int $limit = 0,
		int $page = 0,
		array $nav_params = [],
		bool|array $groupBy = false
	): int|CIBlockResult {
		$filter = array_merge([
			'=ACTIVE' => 'Y',
			'IBLOCK_ID' => self::getIBlockId()
		], $filter);

		$select = array_merge(['ID', 'IBLOCK_ID'], $select ?: static::itemsSelectList());

		if (empty($nav_params) && ($limit || $page)) {
			$nav_params = [
				'nTopCount' => false,
				'nPageSize' => $limit,
				'iNumPage' => $page,
				'checkOutOfRange' => true
			];
		}

		return CIBlockElement::GetList(
			$sort,
			$filter,
			$groupBy,
			$nav_params,
			$select,
		);
	}

	protected static function selectSectionsIterator(
		array $filter = [],
		array $select = [],
		array $sort = [],
		bool $countItems = false,
		int $limit = 0,
		int $page = 0,
		array $nav_params = [],
	): CIBlockResult {
		$filter = array_merge([
			'ACTIVE' => 'Y',
			'GLOBAL_ACTIVE' => 'Y',
			'IBLOCK_ID' => self::getIBlockId()
		], $filter);

		$select = array_merge(['ID', 'IBLOCK_ID'], $select ?: static::sectionsSelectList());

		if (empty($nav_params) && ($limit || $page)) {
			$nav_params = [
				'nTopCount' => false,
				'nPageSize' => $limit,
				'iNumPage' => $page,
				'checkOutOfRange' => true
			];
		}

		return CIBlockSection::GetList(
			$sort, $filter, $countItems, $select, $nav_params ?: false
		);
	}

	public static function getSectionsTree(
		array $filter = [],
		array $select = [],
		array $sort = [],
		bool $count = false
	): array {
		$sections = self::selectSectionsIterator($filter, $select,	$sort, $count);

		$result = [];

		while($section = $sections->GetNext()) {
			$parentId = (int)$section['IBLOCK_SECTION_ID'];
			$id = (int)$section['ID'];

			$result[$parentId]['sub'][$id] = static::makeSectionTreeItem($section);
			$result[$id] = &$result[$parentId]['sub'][$id];
		}

		$result = array_values($result[0]['sub']);

		//костыль для корректной работы сортировки
		//т.к на фронте JSON парсинг пренебрегает порядком элементов и использует порядок ключей
		function reset_result_items(&$array): void
		{
			foreach ($array as &$item) {
				if (is_array($item['sub'])) {
					reset_result_items($item['sub']);
					$item['sub'] = array_values($item['sub']);
				}
			}
		}

		reset_result_items($result);

		return $result;
	}

	protected static function makeSectionTreeItem(array $section): array
	{
		return [
			'id' => $section['ID'],
			'name' => $section['NAME'],
			'lvl' => $section['DEPTH_LEVEL'],
		];
	}

	protected static function itemsSelectList(): array
	{
		return [
			'ID',
			'IBLOCK_ID',
			'NAME',
			'CODE',
		];
	}

	protected static function sectionsSelectList(): array
	{
		return [
			'ID',
			'IBLOCK_ID',
			'NAME',
			'CODE',
		];
	}

	public static function make(array $params = []): array
	{
		return [
			'NAME' => $params['NAME'],
			'XML_ID' => $params['XML_ID'],
		];
	}

	/**
	 * @deprecated
	 * @param int $id
	 * @return bool|array
	 */
	public static function get(int $id): bool|array
	{
		return static::findById($id);
	}

	protected static function getSiteId(): string
	{
		if (!defined('ADMIN_SECTION') || ADMIN_SECTION !== true) {
			return SITE_ID;
		}

		$sites = SiteTable::getList([
			"filter" => [
				"=DOC_ROOT" => Context::getCurrent()->getServer()->getDocumentRoot()() . "/",
				"=LANGUAGE_ID" => SITE_ID
			]
		]);

		return $sites->Fetch() ?: '';
	}
}
