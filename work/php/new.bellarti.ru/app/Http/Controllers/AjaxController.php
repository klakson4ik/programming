<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\Blog;
use App\Models\City;
use App\Models\Clinic;
use App\Models\Event;
use App\Models\Cosmetology;
use App\Models\News;
use App\Models\Page\BlogPage;
use App\Models\Page\EventPage;
use App\Models\Page\EventDetailPage;
use App\Models\Page\NewsPage;
use App\Services\Calendar\Calendar;
use App\Services\Calendar\CalendarFHD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AjaxController extends Controller
{
	// Возвращает JSON-ответ с данными о датах,
	// текущей дате и сгенерированным HTML-кодом для календаря.(Большой календарь на странице косметологов)
	public function fullCalendar(Request $request, $type,  $cityId, $date, $page)
	{
		$this->isAjax($request);
		$selectDates = CalendarFHD::getTypeSelectDates($date, $type);
		$currentDate = CalendarFHD::getTypeCurrentDate($date, $type);

		$modelClass = $page === 'cosmetology' ? Cosmetology::class : Event::class;

		$eventsQuery = $modelClass::isActive()
			->with('city')
			->whereBetween('date', CalendarFHD::getRangeMonth($date, $type));

		if ($cityId !== '999') {
			$eventsQuery->where('city_id', $cityId);
		}

		$events = $eventsQuery->get()->toArray();

		return response()->json([
			'success' => true,
			'data' => [
				'date' => $selectDates,
				'currentDate' => $currentDate,
				'currentDateFormat' => CalendarFHD::getDateFormat($currentDate),
				'calendar' => View::make('pages.cosmetology.calendar', ['data' => CalendarFHD::getCalendarData($events, $currentDate)])->render()
			]
		]);
	}

	// Возвращает JSON-ответ с данными о датах, текущей дате,
	// содержимом календаря и карточками событий.
	public function calendar(Request $request, $type, $date, $page)
	{
		$this->isAjax($request);
		$selectDates = Calendar::getTypeSelectDates($date, $type);
		$currentDate = Calendar::getTypeCurrentDate($date, $type);

		$modelClass = $page === 'cosmetology' ? Cosmetology::class : Event::class;

		$events = $modelClass::isActive()->with('city')->whereBetween('date', Calendar::getRangeMonth($date, $type))->sort(['date' => 'desc'])->get()->toArray();
		$cards = Calendar::getCloseEvents($events);
		ImageHelpers::getImagesArray($cards['future']);
		ImageHelpers::getImagesArray($cards['past']);

		return response()->json([
			'success' => true,
			'data' => [
				'date' => $selectDates,
				'currentDate' => $currentDate,
				'currentDateFormat' => Calendar::getDateFormat($currentDate),
				'content' => View::make('component.calendar.content', ['days' => Calendar::getCalendarData($events, $currentDate)])->render(),
				'events' => View::make('pages.news.cards-event', [
					'cards' => $cards,
					'common' => [
						'other' => EventPage::getOther()
					]
				])->render()

			]
		]);
	}

	// Возвращает JSON-ответ с карточками событий,
	// сгенерированными с помощью шаблонов.
	public function calendarDay(Request $request, $date, $page)
	{
		$this->isAjax($request);

		$modelClass = $page === 'cosmetology' ? Cosmetology::class : Event::class;

		$events = $modelClass::isActive()->with('city')->where('date', $date)->sort(['time' => 'desc'])->get()->toArray();
		$cards = Calendar::getCloseEvents($events);
		ImageHelpers::getImagesArray($cards['future']);
		ImageHelpers::getImagesArray($cards['past']);

		return response()->json([
			'success' => true,
			'data' => [
				'events' => View::make('pages.news.cards-event', [
					'cards' => $cards,
					'common' => [
						'other' => EventPage::getOther()
					]
				])->render()
			]
		]);
	}

	// Возвращает JSON-ответ с данными о датах, текущей дате,
	// содержимом календаря и карточками событий.
	public function detailCalendar(Request $request, $type, $date, $page)
	{
		$this->isAjax($request);
		$selectDates = Calendar::getTypeSelectDates($date, $type);
		$currentDate = Calendar::getTypeCurrentDate($date, $type);

		$modelClass = $page === 'cosmetology' ? Cosmetology::class : Event::class;

		$events = $modelClass::isActive()->with('city')->whereBetween('date', Calendar::getRangeMonth($date, $type))->sort(['date' => 'desc'])->get()->toArray();
		$cards = Calendar::getCloseEvents($events);
		ImageHelpers::getImagesArray($cards['future']);
		ImageHelpers::getImagesArray($cards['past']);

		return response()->json([
			'success' => true,
			'data' => [
				'date' => $selectDates,
				'currentDate' => $currentDate,
				'currentDateFormat' => Calendar::getDateFormat($currentDate),
				'content' => View::make('component.calendar.content', ['days' => Calendar::getCalendarData($events, $currentDate)])->render(),
				'events' => View::make('pages.event-detail.one-news-response-event', [
					'cards' => $cards,
					'common' => [
						'other' => EventPage::getOther()
					],
				])->render()
			]
		]);
	}


	// Возвращает JSON-ответ с карточками событий,
	// сгенерированными с помощью шаблонов.
	public function detailCalendarDay(Request $request, $date, $page)
	{
		$this->isAjax($request);

		$modelClass = $page === 'cosmetology' ? Cosmetology::class : Event::class;

		$events = $modelClass::isActive()->with('city')->where('date', $date)->sort(['time' => 'desc'])->get()->toArray();
		$cards = Calendar::getCloseEvents($events);
		ImageHelpers::getImagesArray($cards['future']);
		ImageHelpers::getImagesArray($cards['past']);

		return response()->json([
			'success' => true,
			'data' => [
				'events' => View::make('pages.event-detail.one-news-response-event', [
					'cards' => $cards,
					'common' => [
						'other' => EventDetailPage::getOtherEvents(),
					],
					'link' => $events,
				])->render()
			]
		]);
	}

	// Возвращает JSON-ответ с успешным статусом и данными о клиниках.
	public function getClinicList(Request $request, $page = 'contacts')
	{
		$this->isAjax($request);
		$clinics = Clinic::isActive()->where('page', $page)->get()->toArray();
		return response()->json([
			'success' => true,
			'data' => $clinics
		]);
	}
	//  Возвращает JSON-ответ с успешным статусом и
	//  сгенерированным HTML-кодом для отображения информации о клинике.
	public function getClinic(Request $request, int $id)
	{
		$this->isAjax($request);
		$clinic = Clinic::find($id)->toArray();
		if (!$clinic) {
			$this->ajaxFailed('Клиники с id: [' . $id . '] не существует');
		}
		return response()->json([
			'success' => true,
			'data' => View::make('pages.patient.balloon', $clinic)->render()
		]);
	}

	// Возвращает JSON-ответ с успешным статусом и данными о городе.
	public function getCity(Request $request, int $id, $page = 'contacts')
	{
		$this->isAjax($request);
		$city = City::find($id);
		if (!$city) {
			$this->ajaxFailed('Города с id: [' . $id . '] не существует');
		}
		return response()->json([
			'success' => true,
			'data' => [
				'city' => $city->toArray(),
				'clinics' => implode('', array_map(fn($clinic) => View::make('pages.patient.balloon', $clinic)->render(), $city->clinics()->where('page', $page)->get()->toArray()))
			]
		]);
	}

	// Возвращает JSON-ответ с успешным статусом,
	// сгенерированными карточками и информацией о наличии дополнительных данных.
	public function getNextPage(Request $request, string $type)
	{
		$this->isAjax($request);
		$newsCount = match ($type) {
			'news' => NewsPage::getNewsCount(),
			'blogs' => BlogPage::getNewsCount(),
			'events' => EventPage::getNewsCount()
		};

		$query = match ($type) {
			'news' => News::getItems(),
			'blogs' => Blog::getItems(),
			'events' => Event::isActive()->sort(['date' => 'desc'])
		};

		$pagNewsData = $query->paginate($newsCount)->toArray();
		ImageHelpers::getImagesArray($pagNewsData['data']);
		$isMore = ($pagNewsData['to'] < $pagNewsData['total'])
			? true
			: false;

		return response()->json([
			'success' => true,
			'data' => [
				'cards' => implode('', array_map(fn($item) => View::make('pages.news.card', $item)->render(), $pagNewsData['data'])),
				'isMore' => $isMore
			]
		]);
	}
}
