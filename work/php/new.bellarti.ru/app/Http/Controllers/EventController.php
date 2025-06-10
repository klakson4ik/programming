<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\Event;
use App\Models\Page\EventPage;
use App\Services\Calendar\Calendar;

class EventController extends Controller
{

	public function __invoke()
	{
		$data = EventPage::get();
		$pagNewsData = Event::isActive()->sort(['date' => 'desc'])->with('city')->whereBetween('date', Calendar::getRangeYear(plusYears: 1))->get()->toArray();

		$data['cards'] = Calendar::getCloseEvents($pagNewsData, 5);
		ImageHelpers::getImagesArray($data['cards']['future']);
		ImageHelpers::getImagesArray($data['cards']['past']);
		return view('news', $data);
	}
}
