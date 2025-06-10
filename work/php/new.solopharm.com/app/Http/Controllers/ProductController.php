<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Pages\ProductPage;
use App\Models\Product;
use App\Models\Trade;
use App\Services\BreadcrumbService;
use App\Services\MetaService;
use App\Services\ProductService;
use App\Services\DirectionService;
use App\Services\SocialShareService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
	public function index(Request $request): View
	{
		$page = ProductPage::getPage();
		$meta = MetaService::getData($page);
		$directions = DirectionService::getDirectionsWithChildrens(Direction::getCached());

		if ($request->query('search')) {
			$products = Product::isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->where('title', 'LIKE', '%' . $request->query('search') . '%')
				->paginate(12);
		} else {
			$products = Product::isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->paginate(12);
		}
		$productsArray = $products->toArray()['data'];
		$prodIds = array_column($productsArray, 'id');
		$trades = Trade::isActive()->lang()->sort(['is_main' => 'desc', 'sort' => 'asc'])->forList()->whereIn('product_id', $prodIds)->get();

		$products = ProductService::prepareProducts($products, $trades);
		$data = [
			'asset' => 'product',
			'meta' => $meta,
			'page' => $page,
			'directions' => $directions,
			'products' => $products
		];

		return view('product', $data);
	}

	public function filter(Request $request): View
	{
		if ($filter = $request->route('filters')) {
			$filters = ProductService::getFilters($filter);
		}
		$choiceFilters = [];
		$directionIds = [];

		$directions = DirectionService::getDirectionsWithChildrens(Direction::getCached());
		$query = Product::query();

		if (!empty($filters)) {
			foreach ($filters as $filter) {
				$method = $filter['method'];
				if (isset($filter['operator'])) {
					$query->$method($filter['name'], $filter['operator'], $filter['value']);
				} else {
					$query->$method($filter['name'], $filter['value']);
				}
				if(isset($filter['localName']) && $filter['localName'] === 'novelty'){
					$query->where('is_exclude_novelty', false);
				}
				$choiceFilters[$filter['localName'] ?? $filter['name']] = $filter['value'];
				if (isset($filter['direction_id'])) {
					$directionIds = $filter['direction_id'];
				}
			}

			if ($request->query('search')) {
				$products = $query->isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->where('title', 'LIKE', '%' . $request->query('search') . '%')
					->paginate(12);
			} else {
				$products = $query->isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->paginate(12);
			}
		} else {
			if ($request->query('search')) {
				$products = Product::isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->where('title', 'LIKE', '%' . $request->query('search') . '%')
					->paginate(12);
			} else {
				$products = Product::isActive()->lang()->sort(['title' => 'asc', 'sort' => 'asc'])->paginate(12);
			}
		}

		$productsArray = $products->toArray()['data'];
		$prodIds = array_column($productsArray, 'id');
		$trades = Trade::isActive()->lang()->sort(['is_main' => 'desc', 'sort' => 'asc'])->forList()->whereIn('product_id', $prodIds)->get();

		$products = ProductService::prepareProducts($products, $trades);
		$page = ProductPage::getPage();

		$data = [
			'asset' => 'product',
			'meta' => MetaService::getData($page),
			'page' => $page,
			'directions' => $directions,
			'products' => $products,
			'choiceFilters' => $choiceFilters,
			'directionIds' => $directionIds
		];
		return view('product', $data);
	}

	public function show(Request $request)
	{
		$data = [];
		if ($product = Product::isActive()->lang()->where('url_slug', $request->route('name'))->with('direction')->first()) {
			$trades = $product->trades()->with('technology')->getItems()->get();

			if ($request->route('form')) {
				$currentTrade = $trades->where('url_slug', $request->route('form'))->first();
				if (!$currentTrade) {
					return abort(404);
				}
			} else {
				$currentTrade = $trades->where('is_main', 1)->first();
			}
			$catalogPage = ProductPage::getPage();

			$meta = [
				'title' => $product->title . ' ' . __('pages.product.meta.title'),
				'description' => $product->title . ' ' . __('pages.product.meta.description') . ' ' . $product->title,
				'keywords' => __('pages.product.meta.keywords'),
				'img' => $product->img,
				'type' => 'article'
			];

			$shares = app()->getLocale() != 'ru'
				? ['wa', 'telegram', 'ln']
				: ['vk', 'ok', 'telegram', 'wa'];

			$utekaIds = $currentTrade->uteka_id ?? $product->uteka_id;
			$utekaIds = str_replace(' ', '', $utekaIds);
			$links = [
				'ozon' => $currentTrade->ozon_link ?? $product->ozon_link,
				'wb' => $currentTrade->wb_link ?? $product->wb_link,
				'uteka' => $utekaIds
			];

			$data = [
				'asset' => 'product-item',
				'meta' => $meta,
				'product' => $product,
				'trades' => $trades,
				'catalogPage' => $catalogPage,
				'currentTrade' => $currentTrade,
				'socialShare' => SocialShareService::getData($meta, $shares),
				'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
					[
						[
							'name' => $product->title,
							'url' => isset($product->url_slug) ? 'products/' . $product->url_slug : 'products/'
						],
						[
							'name' => isset($currentTrade->form) ? $currentTrade->form : __('pages.equipment.packaging_type'),
							'url' => isset($currentTrade->url_slug) ? $currentTrade->url_slug : 'products/'
						]
					]
				),
				'links' => $links
			];
		} else {
			return abort(404);
		}

		return view('product-item', $data);
	}
}
