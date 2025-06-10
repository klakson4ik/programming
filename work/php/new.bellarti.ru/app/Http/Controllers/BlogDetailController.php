<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\City;
use App\Models\Blog;
use App\Helpers\ImageHelpers;
use App\Services\SocialShareService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Models\Page\NewsDetailPage;

class BlogDetailController extends Controller
{
	public function __invoke($code = null)
	{
		$data = NewsDetailPage::get();
		$productCards = Product::getItemsArray();

		ImageHelpers::resizeImagesFromArrayByKey($productCards, [false, false, '540'], 'images');

		$data['otherProduct']['slider'] = [
			'cards' => $productCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.home.part.product-card'
		];

		// Яндекс карта
		$cities = City::isActive()->sort(['sort' => 'asc', 'name' => 'asc'])->get()->toArray();
		$data['ymap']['cities']['999'] = 'Выбрать город';
		foreach ($cities as $city) {
			$data['ymap']['cities'][$city['id']] = $city['name'];
		}


		// Получение данных конкретной страницы
		$newsPage = Blog::GetItemsArray();
		$found = false;

		foreach ($newsPage as $el) {
			if ($el['code'] === $code) {
				$data['text']['info'] = $el;
				$data['main']['title'] = $el['title'];
				$found = true;
				break;
			}
		}

		// Если нет такой записи в бд
		if (!$found) throw new NotFoundHttpException();

		// Обработка картинок json и подготовка данных для слайдера;
		if (isset($data['text']['info']['json_img'])) {
			ImageHelpers::resizeImagesFromArrayByKey($data['text']['info']['json_img'], ['1366', '768', '540'], 'value');
			$data['text']['slider'] = [
				'cards' => $data['text']['info']['json_img'],
				'action' => 'pag-default',
				'cardTemplate' => 'pages.news-detail.part.image-card',
			];
		}

		// Работа с блогом
		$blogCards = $newsPage;
		ImageHelpers::getImagesArray($blogCards);

		$data['blog']['slider'] = [
			'cards' => $blogCards,
			'action' => 'nav-default',
			'cardTemplate' => 'pages.patient.blog-card'
		];

		// Работа с meta
		$meta = [
			'title' => strip_tags($data['text']['info']['meta_title'] ?? $data['text']['info']['title'] . ' | Блог Bellarti'),
			'description' => strip_tags($data['text']['info']['meta_description'] ?? implode(' ', array_slice(preg_split('/(?<=[.!?])\s+/', strip_tags($data['text']['info']['description'])), 0, 2)) . ' Советы, рекомендации и последние тренды в косметологии от экспертов Bellarti.' ?? 'Bellarti'),
			'keywords' => $data['text']['info']['meta_keywords'] ?? 'Bellarti',
			'seo_type' => 'article',
		];

		$data['seo_title'] = $meta['title'];
		$data['main_title'] = $data['text']['info']['title'];
		$data['seo_description'] = $meta['description'];
		$data['seo_keywords'] = $meta['keywords'];
		$data['seo_type'] = $meta['seo_type'];

		$data['text']['socialShare']['info'] = SocialShareService::getData($meta, ['telegram', 'wa', 'vk', 'ok']);
		$data['text']['socialShare']['title'] = 'Поделиться';

		$data['breadcrumbsAdd'] = [
			[
				'name' => $data['text']['info']['title'],
				'url' => '/blogs/' . $data['text']['info']['code'],
			],
		];

		return view('news-detail', $data);
	}
}
