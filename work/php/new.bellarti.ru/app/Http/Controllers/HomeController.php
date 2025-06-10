<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Helpers\ImageHelpers;
use App\Models\HomeSlider;
use App\Models\Page\HomePage;

class HomeController extends Controller
{
	public function __invoke()
	{
		$data = HomePage::get();
		$mainCards = HomeSlider::getItemsArray();
		ImageHelpers::resizeImagesFromArrayByKey($mainCards, ['1366', '768', false]);
		$productCards = Product::getItemsArray();
		ImageHelpers::resizeImagesFromArrayByKey($productCards, [false, false, '540'], 'images');

		$data['main']['slider'] = [
			'cards' => $mainCards,
			'action' => 'nav-pag',
			'cardTemplate' => 'pages.home.part.main-card'
		];

		$data['product']['slider'] = [
			'cards' => $productCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.home.part.product-card'
		];
		return view('home', $data);
	}
}
