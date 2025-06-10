<?php

namespace App\Http\Controllers;

use App\Models\AboutSlider;
use App\Helpers\ImageHelpers;
use App\Models\Page\AboutPage;

class AboutController extends Controller
{
	protected $data;

	public function __construct()
	{
		$this->data = AboutPage::get();
	}

	public function index()
	{

		$mainCards = AboutSlider::getItemsArray();

		ImageHelpers::resizeImagesFromArrayByKey($mainCards, ['1366', '768', false]);

		$this->data['topSlider']['slider'] = [
			'cards' => $mainCards,
			'action' => 'nav-pag',
			'cardTemplate' => 'pages.home.part.main-card'
		];

		return view('about', $this->data);
	}
}
