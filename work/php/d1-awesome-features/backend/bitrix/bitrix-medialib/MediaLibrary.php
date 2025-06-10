<?php

namespace App\Services\MediaLibrary;

use CFile;
use CMedialib;
use CMedialibCollection;
use CMedialibItem;
use CModule;
use COption;
use CSite;

class MediaLibrary
{
	public function __construct()
	{
		CModule::IncludeModule("fileman");
		CMedialib::Init();
	}

	public static function new(): MediaLibrary
	{
		return new self;
	}

	public function getById(int $id): ?array
	{
		$items = $this->getItems([
			'id' => $id
		]);

		return $items ? reset($items) : null;
	}

	public function getByCollectionName(string $name): array
	{
		$collection = $this->getCollectionsIds(['NAME' => $name]);

		return $collection
			? $this->getItems(['arCollections' => $collection])
			: [];
	}

	public function getItems(array $params = []): array
	{
		return CMedialibItem::GetList($params);
	}

	public function getCollectionsIds(array $filter = [], array $order = ['ID' => 'ASC']): array
	{
		$collection = $this->getCollections($filter, $order);

		return array_column($collection, 'ID');
	}

	public function getCollectionsTree(array $filter = [], array $order = ['ID' => 'ASC']): array
	{
		$collections = $this->getCollections($filter, $order);

		$tmp = [];

		foreach ($collections as $collection) {
			$tmp[$collection['ID']] = $collection;
		}

		function buildTree(array &$elements, $parentId = 0) {
			$branch = array();
			foreach ($elements as $key => $element) {
				if ($element['PARENT_ID'] == $parentId) {
					$children = \App\Services\MediaLibrary\buildTree($elements, $key);
					if ($children) {
						$element['sub'] = $children;
					}
					$branch[$key] = $element;
					unset($elements[$key]);
				}
			}
			return $branch;
		}

		return \App\Services\MediaLibrary\buildTree($tmp);
	}

	public function getCollections(array $filter = [], array $order = ['ID' => 'ASC']): array
	{
		return CMedialibCollection::GetList([
			'arOrder'=> $order,
			'arFilter' => array_merge(['ACTIVE' => 'Y'], $filter)
		]);
	}

	public function updateItemCollectionsByItemID(int|string $id, array $collections)
	{
		return $this->updateItemByID($id, [
			'collections' => $collections
		]);
	}

	public function updateItemByID(int|string $id, array $params)
	{
		$params['ID'] = $id;
		$collections = $params['collections'];
		unset($params['collections']);

		$params = array_merge($this->getById($id), $params);

		return $this->updateItem([
			'fields' => $params,
			'collections' => $collections
		]);
	}

	public function updateItem(array $_params)
	{
		$params = [];

		if ($_params['fields']) {
			$params['arFields'] = $_params['fields'];
		}

		if ($_params['collections']) {
			$params['arCollections'] = $_params['collections'];
		}

		if (!$params) {
			return false;
		}

		return CMedialibItem::Edit($params);
	}

	public function getCollectionTypes()
	{
		return CMedialib::GetTypes();
	}

	public function getItemsByFileName(array|string $fileName): array
	{
		global $DB;

		$q = '';

		if (!is_array($fileName)) {
			$fileName = [$fileName];
		}

		foreach ($fileName as $name) {
			$q .= $q ? ' OR F.FILE_NAME="'.$name.'"' : 'WHERE F.FILE_NAME="'.$name.'"';
		}

		$err_mess = CMedialibCollection::GetErrorMess()."<br>Function: CMedialibItem::GetList<br>Line: ";
		$strSql = "SELECT
					MI.*,MCI.COLLECTION_ID, F.HEIGHT, F.WIDTH, F.FILE_SIZE, F.CONTENT_TYPE, F.SUBDIR, F.FILE_NAME, F.HANDLER_ID,
					".$DB->DateToCharFunction("MI.DATE_UPDATE")." as DATE_UPDATE2
				FROM b_medialib_collection_item MCI
				INNER JOIN b_medialib_item MI ON (MI.ID=MCI.ITEM_ID)
				INNER JOIN b_file F ON (F.ID=MI.SOURCE_ID) ".$q;

		$res = $DB->Query($strSql, false, $err_mess);
		$arResult = [];
		$rootPath = CSite::GetSiteDocRoot(false);
		$tmbW = COption::GetOptionInt('fileman', "ml_thumb_width", 140);
		$tmbH = COption::GetOptionInt('fileman', "ml_thumb_height", 105);


		while($arRes = $res->Fetch())
		{
			CMedialibItem::GenerateThumbnail($arRes, array('rootPath' => $rootPath, 'width' => $tmbW, 'height' => $tmbH));
			$arRes['PATH'] = CFile::GetFileSRC($arRes, false, false);
			$arRes['PATH_EXTERNAL'] = CFile::GetFileSRC($arRes, false, true);
			$arResult[]=$arRes;
		}

		return $arResult;
	}
}
