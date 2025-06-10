<?php

namespace App\Http\Controllers;

use App\Models\Cosmetology;
use App\Models\Page\CosmetologyDetailPage;

use App\Helpers\ImageHelpers;

use App\Services\Calendar\Calendar;
use App\Services\SocialShareService;

class CosmetologyDetailController extends Controller
{
	public function __invoke($code = null)
	{
		$data = CosmetologyDetailPage::get();

		$otherEvents = Cosmetology::isActive()->sort(['date' => 'desc'])->with('city')->whereBetween('date', Calendar::getRangeYearCurrentDate(1))->get()->toArray();
		$currentEvents =  Cosmetology::isActive()->sort(['date' => 'desc'])->with('city')->where('code', $code)->get()->toArray();

		$data['cards'] = Calendar::getCloseEvents($otherEvents, 5);
		ImageHelpers::getImagesArray($data['cards']['future']);
		ImageHelpers::getImagesArray($data['cards']['past']);

		foreach ($otherEvents as &$el) {
			$el['img'] = isset($el['img']) ? ImageHelpers::getImage('/storage/' . $el['img']) : null;
			$el['full_img'] = isset($el['full_img']) ? ImageHelpers::getImage('/storage/' . $el['full_img']) : null;
		}

		ImageHelpers::getImagesArray($data['cards']['past']);


		$currentEventIds = array_column($currentEvents, 'id');
		$filteredOtherEvents = array_filter($otherEvents, function ($event) use ($currentEventIds) {
			return !in_array($event['id'], $currentEventIds);
		});

		// Переиндексируем массив, чтобы индексы начинались с 0
		$filteredOtherEvents = array_values($filteredOtherEvents);


		$data['otherEvents']['data'] = $filteredOtherEvents;


		$data['currentEvents']['data'] = $currentEvents;
		$data['currentEvents']['title'] = 'Ссылка на регистрацию';

		$data['main']['title'] = $data['currentEvents']['data'][0]['title'];


		if (isset($data['currentEvents']['data'][0]['full_img'])) {
			$data['currentEvents']['data'][0]['full_img'] = ImageHelpers::getImage('/storage/' . $data['currentEvents']['data'][0]['full_img']);
		}

		// Работа с meta
		$meta = [
			'title' => strip_tags($currentEvents[0]['meta_title'] ?? $data['text']['info']['title'] ?? $currentEvents[0]['title'] . ' — ' . $currentEvents[0]['date'] . ' | Мероприятия Bellarti' ?? 'Bellarti'),
			'description' => strip_tags($currentEvents[0]['meta_description'] ?? 'Уникальные знания, практический опыт и возможность узнать больше о новейших разработках Bellarti на встрече ' . implode(' ', array_slice(preg_split('/(?<=[.!?])\s+/', strip_tags($currentEvents[0]['description'])), 0, 2)) ?? 'Bellarti'),
			'keywords' => $currentEvents[0]['meta_keywords'] ?? 'Bellarti',
			'seo_type' => 'article',
		];

		// Заполнение данных
		$data['seo_title'] = $meta['title'];
		$data['main_title'] = $currentEvents[0]['title'] ?? '';
		$data['seo_description'] = $meta['description'];
		$data['seo_keywords'] = $meta['keywords'];
		$data['seo_type'] = $meta['seo_type'];

		$data['currentEvents']['data'][0]['link'] = isset($data['currentEvents']['data'][0]['link']) ? $data['currentEvents']['data'][0]['link'] : '';

		$data['socialShare']['info'] = SocialShareService::getData($meta, ['telegram', 'wa', 'vk', 'ok']);
		$data['socialShare']['title'] = 'Поделиться';

		$data['breadcrumbsAdd'] = [
			[
				'name' => $data['currentEvents']['data'][0]['title'],
				'url' => '/events/' . $data['currentEvents']['data'][0]['code'],
			],
		];

		return view('event-detail', $data);
	}
}
