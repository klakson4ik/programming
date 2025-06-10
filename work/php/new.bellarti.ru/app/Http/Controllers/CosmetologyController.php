<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\ClinicalExamples;
use App\Models\Cosmetology;
use App\Models\Expert;
use App\Models\Page\CosmetologyPage;
use App\Models\Product;
use App\Models\Publications;
use App\Models\CombinedProtocols;
use App\Services\Calendar\CalendarFHD;
use Illuminate\Support\Facades\View;

class CosmetologyController extends Controller
{
	public function __invoke($code = null)
	{
		$data = CosmetologyPage::get();

		$productCards = Product::getItemsArray();
		ImageHelpers::resizeImagesFromArrayByKey($productCards, [false, false, '540'], 'images');

		$exampleCards = ClinicalExamples::getItemsArray();
		ImageHelpers::getImagesArrayByKey($exampleCards, ['img_before', 'img_after']);

		$expertCards = Expert::getItemsArray();
		ImageHelpers::getImagesArrayByKey($expertCards);

		$publicationCards = Publications::getItemsArray();
		ImageHelpers::getImagesArray($publicationCards, 'image');

		// Получение слайдера для экрана "Техника введения"
		$technologies =  CombinedProtocols::get()->toArray();
		$filteredTechnologies = [];
		$clearTechnologies = [];


		// TODO: Переназвать переменные
		foreach ($technologies as $item) {
			$clearTechnologies[$item['title']] =  $item['technologies'];
		}

		foreach ($clearTechnologies as $morphotype => $items) {
			foreach ($items as $index => $el) {
				$filteredTechnologies[$morphotype][$index]['image'] = ImageHelpers::getImage('/storage/' . $el['image']);

				$filteredTechnologies[$morphotype][$index]['value'] = $el['value'];
				$filteredTechnologies[$morphotype][$index]['subtitle'] = $el['subtitle'];
			}
		}

		// Сочетанные протоколы
		$index = 0;
		$slide = 0;
		foreach ($filteredTechnologies as $elem => $el) {
			$data['protocol']['sliders'][] = [
				'classHelper' => 'item-' . $slide++,
				'title' => $elem,
				'cards' => array_map(function ($e) use (&$index) {
					$e['number'] = ++$index;
					return $e;
				}, $el),
				'cardTemplate' => 'pages.cosmetology.part.protocol-card'
			];
			$index = 0;
		}

		if (!isset($data['protocol']['sliders'])) {
			foreach ($data['pagination'] as $key => $el) {
				if ($el['anchor'] == 'b-protocol') {
					unset($data['pagination'][$key]);
				}
			}
		}

		$data['pagination'] = array_values($data['pagination']);

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

		$data['expert']['slider'] = [
			'cards' => $expertCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.cosmetology.expert-card'
		];

		$data['publications']['slider'] = [
			'cards' => $publicationCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.detail-product.part.publications-card',
		];

		$events = Cosmetology::isActive()->with('city')->whereBetween('date', CalendarFHD::getRangeMonth())->get()->toArray();
		$data['education']['cities']['999'] = 'Выбрать город';
		foreach ($events as $event) {
			if (!isset($data['education']['cities'][$event['city']['id']])) {
				$data['education']['cities'][$event['city']['id']] = $event['city']['name'];
			}
		}

		$data['education']['calendar'] = View::make('pages.cosmetology.calendar', ['data' => CalendarFHD::getCalendarData($events), 'page' => 'cosmetology']);
		$data['link'] = '/cosmetology';

		return view('cosmetology', $data);
	}
}
