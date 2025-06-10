<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\Blog;
use App\Models\City;
use App\Models\ClinicalExamples;
use App\Models\FAQ;
use App\Models\Page\PatientPage;
use App\Models\Product;

class PatientController extends Controller
{
	public function __invoke()
	{
		$data = PatientPage::get();

		$productCards = Product::getItemsArray();
		ImageHelpers::resizeImagesFromArrayByKey($productCards, [false, false, '540'], 'images');

		$exampleCards = ClinicalExamples::getItemsArray();
		ImageHelpers::getImagesArrayByKey($exampleCards, ['img_before', 'img_after']);

		$blogCards = Blog::getItemsArray();
		ImageHelpers::getImagesArray($blogCards);

		$faqs = FAQ::getItemsArray();
		$data['faq']['items'] = $faqs;

		$data['product']['slider'] = [
			'cards' => $productCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.home.part.product-card'
		];

		$data['example']['slider'] = [
			'cards' => $exampleCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.cosmetology.example-card'
		];

		$data['blog']['slider'] = [
			'cards' => $blogCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.patient.blog-card'
		];

		$cities = City::isActive()->sort(['sort' => 'asc', 'name' => 'asc'])->get()->toArray();
		$data['ymap']['cities']['999'] = 'Выбрать город';
		foreach ($cities as $city) {
			$data['ymap']['cities'][$city['id']] = $city['name'];
		}

		return view('patient', $data);
	}
}
