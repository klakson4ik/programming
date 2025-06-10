<?php

namespace App\Models\Base;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

abstract class HBlockModel
{
	protected static string $code = '';
	protected static array $entities = [];
	protected static int $id = 0;

	public static function add(array $params = []): bool|int
	{
		if (!static::$code) {
			return false;
		}

		$result = call_user_func_array(
			[self::getEntityClass(), 'add'],
			['data' => static::make($params)]
		);

		return $result ? $result->getId() : false;
	}

	public static function update(int $id, array $params)
	{
		$result = call_user_func_array(
			[self::getEntityClass(), 'update'],
			[$id, static::make($params)]
		);

		return $result ? $result->getId() : false;
	}

	public static function delete(int $id)
	{
		$result = call_user_func_array(
			[self::getEntityClass(), 'delete'],
			[$id]
		);

		return $result ? $result : false;
	}

	public static function getHLBlockID(): int
	{
		static::getEntityClass();

		return static::$id;
	}

	public static function find($filter = [], $sort = [])
	{
		if (!$filter) {
			return false;
		}

		$data = ['filter' => $filter];
		if ($sort) {
			$data['order'] = $sort;
		}

		return call_user_func_array(
			[self::getEntityClass(), 'getRow'],
			[$data]
		);
	}

	public static function select(array $filter = [], array $sort = [], int $limit = 0, int $offset = 0)
	{
		$data = ['filter' => $filter];

		if ($sort) {
			$data['order'] = $sort;
		}

		if (0 < $limit) {
			$data['limit'] = $limit;
		}

		if (0 < $offset) {
			$data['offset'] = $offset;
		}

		$result = call_user_func_array(
			[self::getEntityClass(), 'getList'],
			[$data]
		);

		if ($result) {
			return $result->fetchAll();
		}

		return null;
	}

	public static function formItems(array $filter = [], array $sort = [], int $limit = 0, int $offset = 0): array
	{
		$items = [];

		$result = self::select($filter, $sort, $limit, $offset);

		foreach ($result as $item) {
			$items[] = [
				'label' => $item['UF_NAME'],
				'value' => $item['UF_XML_ID'],
			];
		}

		return $items;
	}

	public static function listItems(array $filter = [], array $sort = [], int $limit = 0, int $offset = 0): array
	{
		$items = [];

		$result = self::select($filter, $sort, $limit, $offset);

		foreach ($result as $item) {
			$items[$item['UF_XML_ID']] = $item['UF_NAME'];
		}

		return $items;
	}

	public static function findById(int $id)
	{
		return self::find(['ID' => $id]);
	}

	public static function findByName(string $name)
	{
		return self::find(['=UF_NAME' => $name]);
	}

	public static function findByXMLID(int|string $id)
	{
		return self::find(['=UF_XML_ID' => $id]);
	}

	public static function nameByXMLID($xml_id): ?string
	{
		return self::find(['=UF_XML_ID' => $xml_id])['UF_NAME'];
	}

	public static function idByXMLID($xml_id)
	{
		return self::find(['=UF_XML_ID' => $xml_id])['ID'];
	}

	public static function getCode(): string
	{
		return static::$code;
	}

	public static function getEntityClass()
	{
		Loader::includeModule("highloadblock");

		if (!static::$entities[static::$code]) {
			$table = HighloadBlockTable::getList(['filter' => ['NAME' => static::$code]])->fetch();
			static::$entities[static::$code] = HighloadBlockTable::compileEntity($table)->getDataClass();
			static::$id = (int)$table['ID'];
		}

		return static::$entities[static::$code];
	}

	public static function make(array $params = []): array
	{
		return [
			'UF_XML_ID' => $params['XML_ID'],
			'UF_NAME' => $params['NAME'],
		];
	}
}
