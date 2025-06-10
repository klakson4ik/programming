<?php

namespace App\Services;

use App\Models\Direction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
	public static function getProductsWithTrade($products, Collection $trades)
	{
		foreach ($products as &$product) {
			$allTrades = [];
			$export = false;
			foreach ($trades as $trade) {
				if (($trade->product_id == $product->id)) {
					$allTrades[] = $trade;

					$export = ($trade->export == 1 && !$export) ? 1 : 0;
				}
			}
			if($export) {
				$product->export = $export;
			}
			$product->trades = $allTrades;
		}
		return $products;
	}

	public static function getProductsWithNovelty($products) {
		$curDate = Carbon::now()->subMonth(6);
		foreach($products as $product) {
			if($product->created_at > $curDate && !$product->is_exclude_novelty) {
				$product->novelty = true;
			} else {
				$product->novelty = false;
			}
		}

		return $products;
	}

	public static function prepareProducts($products, Collection $trades) {
		$products = self::getProductsWithTrade($products, $trades);
		$products = self::getProductsWithNovelty($products);

		return $products;
	}

	public static function getFilters($params)
	{
		$productService = new ProductService();
		$filters = [];
		$rawParams = explode('/', $params);
		foreach ($rawParams as $str) {
			if ($str && $productService->getFilter($str)) {
				$filters[] =  $productService->getFilter($str);
			}
		}
		return $filters;
	}

	public function getFilter($str)
	{
		$filterName = explode('-', $str)[0];
		switch ($filterName) {
			case 'direction':
				return self::getProductsIds($str);
			case 'export':
			case 'recept':
			case 'otc':
				return self::isTrue($str);
			case 'novelty':
				return [
					'name' => 'created_at',
					'localName' => 'novelty',
					'value' => Carbon::now()->subMonth(6),
					'method' => 'whereDate',
					'operator' => '>='
				];
			default:
				return false;
		}
	}

	public  function getProductsIds($data)
	{
		$arrFiltersName = self::getFiltersName($data, 'direction');
		if ($arrFiltersName) {
			$directionsRaw = Direction::all()->whereIn('url_slug', $arrFiltersName);
			$directionsList = Direction::getCached();
			$directionsWithChilds = DirectionService::getDirectionsWithChildrens($directionsList)->toArray();

			$parentIds = array_unique($directionsRaw->pluck('parent_id')->toArray());
			$productIds = $directionsRaw->pluck('id')->toArray();

			$diffIds = array_diff($productIds, $parentIds);
			$directionsSearchIds = [];
			foreach($diffIds as $id) {
				$index = array_search($id, array_column($directionsWithChilds, 'id'));

				$directionsSearchIds[] = $id;

				if(($index !== false) && isset($directionsWithChilds[$index]['children'])) {
					$childrenKeys = $directionsWithChilds[$index]['children'];

					foreach($childrenKeys as $childrenKey) {
						$directionsSearchIds[] = $directionsWithChilds[$childrenKey]['id'];	
					}
				}
			}

			$products = [];

			$filteredDirection = $directionsList->filter(function($value) use($directionsSearchIds) {
				return in_array($value->id, $directionsSearchIds);
			});

			foreach($filteredDirection as $direction) {
				$products = array_merge($products, array_column($direction->products()->get()->toArray(), 'id'));
			}
			$products = array_unique($products);

			return  [
				'name' => 'id',
				'value' => $products,
				'method' => 'whereIn',
				'direction_id' => $directionsRaw->pluck('id')->toArray(),
				'direction_search_ids' => $directionsSearchIds
			];
		}
	}

	public  function isTrue($data)
	{
		if (preg_match('/(recept|export|otc)-is-true/', $data, $matches)) {
			return [
				'name' => $matches[1],
				'value' => 1,
				'method' => 'where'
			];
		}
	}

	private  function getFiltersName($data, $name)
	{
		if (preg_match('/' . $name . '-is-(.+)/', $data, $mathes)) {
			return explode('-or-', $mathes[1]);
		} else {
			return false;
		}
	}
}
