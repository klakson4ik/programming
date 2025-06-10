<?php

namespace App\Http\Controllers;

use App\Models\Pages\MainPage;
use App\Models\Development;
use App\Models\Direction;
use App\Models\Project;
use App\Models\News;
use App\Models\Pages\ValuePage;
use App\Models\Product;
use App\Models\Trade;
use App\Services\MetaService;
use App\Services\ProductService;
use App\Services\DirectionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MainController extends Controller
{
	private static function getFilteredProducts($trades, $id)
	{
		$directions = DirectionService::getDirectionsWithChildrens(Direction::getCached())->toArray();
		$direction = array_filter($directions, function($value) use ($id) {
			return $value['id'] == $id;
		});
		$direction = reset($direction);
		$str = "";
		if($direction === false) {
			return;
		}
		if(isset($direction)) {
			$str = '/direction-is-'.$direction['url_slug'];
			if(isset($direction['children']) && (count($direction['children']) > 0)) {
				foreach($direction['children'] as $childId) {
					$str .= '-or-'.$directions[$childId]['url_slug'];
				}
			}
		}
		$productIds = ProductService::getFilters($str);
		$productIds = reset($productIds)['value'];
		$query = Product::query()->whereIn("id", $productIds);
		$directionId = $id;

		$filteredTrades = array_filter($trades->toArray(), function($value, $key) use($directionId) {
			return $value['direction_id'] == $directionId;
		}, ARRAY_FILTER_USE_BOTH);
		
		$children = Direction::query()->where('parent_id', $directionId)->isActive()->get();

		if(count($children) > 0) {
			$ids = array_column($children->toArray(), 'id');
			$query->whereIn('direction_id', $ids, 'or');
		}

		if(count($filteredTrades) > 0) {
			$ids = array_column($filteredTrades, 'product_id');
			$query->whereIn('id', $ids, 'or');
		}

		$products = $query->isActive()->sort(['title' => 'asc'])->get();
		$products = ProductService::prepareProducts($products, $trades);
		
		echo self::getViewDirections($products);
	}

	private function getNovelties($trades)
	{
		$query = Product::query()
			->whereDate('created_at', '>=', Carbon::now()->subMonth(6))
			->where('active', true)
			->where('lang', app()->getLocale());
		$products = $query->isActive()->sort(['title' => 'asc'])->get();
		$products = ProductService::prepareProducts($products, $trades);
		echo self::getViewDirections($products);
	}

	private function getBool($trades, $code = 'export', $checkTrades = true)
	{
		$query = Product::query()
			->where($code, 1)
			->where('active', true)
			->where('lang', app()->getLocale());

		if($checkTrades === true) {
			$expFiltered = array_filter($trades->toArray(), function($value, $key) use($code) {
				return $value[$code] == 1;
			}, ARRAY_FILTER_USE_BOTH);
	
			if(count($expFiltered) > 0) {
				$ids = array_column($expFiltered, 'product_id');
				$query->whereIn('id', $ids, 'or');
			}
		}

		$products = $query->isActive()->sort(['title' => 'asc'])->get();
		$products = ProductService::prepareProducts($products, $trades);

		echo self::getViewDirections($products);
	}

	private static function getViewDirections($products)
	{
		$pages = array_chunk($products->toArray(), 6);
		echo view('partials.direction-wrapper-items', [
			'pages' => $pages,
			'svgArrow' => file_get_contents('images/icons/arrow-short.svg'),
			'svgExclamate' => file_get_contents('images/icons/exclamate.svg'),
		]);
	}

	public function getProducts(Request $request)
	{
		$id = $request->route('id');
		$trades = Trade::isActive()->lang()->sort([ 'is_main' => 'desc', 'sort' => 'asc'])->forList()->get();

		switch($id) {
			case 'novelties':
				self::getNovelties($trades);
				break;
				case 'export':
					self::getBool($trades, $id);
				break;
			case 'otc':
			case 'recept':
				self::getBool($trades, $id, false);
				break;
			default:
				self::getFilteredProducts($trades, $id);
				break;
		}
	}

	public function index()
	{        
		$product = "";
		$pageInfo = MainPage::getPage();
		$valuePage = ValuePage::getPage();

		$developments = Development::getCached();

		$project = Project::getCached();

		$direction = Direction::getCached()->where('parent_id', 0);

		$news = News::getItems('desc')->where("show_in_main", 1)->get();

		$titleImg = array(
			'titleText' => $pageInfo->block_1_title,
			'text1' => $pageInfo->block_1_text_1,
			'text2' => $pageInfo->block_1_text_2,
			'img' => $pageInfo->block_1_img,
			'youtube' => $valuePage->youtube,
            'videoFile' => true
		);

		$block2 = array(
			'titleText' => $pageInfo->block_2_title,
			'textLeft' => $pageInfo->block_2_description,
			'textArr' => $pageInfo->block_2_text,
			'btnText' => $pageInfo->block_2_btn_caption,
			'btnLink' => $pageInfo->block_2_btn_link,
		);



		$params2 = array(
			'asset' => 'main',
			'meta' => MetaService::getData($pageInfo),
			'titleImg' => $titleImg,
			'block2' => $block2,
			'block3' => $developments,
			'block4' => $direction,
			'block5' => $news,
			'block6' => $project,
			'block6Text' => $pageInfo->block_6_text,
			'titles' => [$pageInfo->block_3_title, $pageInfo->block_4_title, $pageInfo->block_5_title, $pageInfo->block_6_title, $pageInfo->block_7_title, $pageInfo->block_8_title],
			'linkText'  => [$pageInfo->block_3_url_caption, $pageInfo->block_4_url_caption, $pageInfo->block_5_url_caption, $pageInfo->block_6_url_caption],
			'linkUrl'  => [$pageInfo->block_3_url_link, $pageInfo->block_4_url_link, $pageInfo->block_5_url_link, $pageInfo->block_5_url_link],
			'product' => $product
		);

		return view('main', $params2);
	}
}
