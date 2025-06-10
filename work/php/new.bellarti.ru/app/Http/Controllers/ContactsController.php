<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\Page\ContactsPage;
use App\Models\Partners;
use App\Models\City;
use App\Models\People;
use App\Models\Districts;


class ContactsController extends Controller
{
	public function index()
	{
		$data = ContactsPage::get();
		$partnersCard = Partners::getItemsArray();
		ImageHelpers::getImagesWithoutSVGArray($partnersCard, 'img');
		$data['partners']['partners'] = $partnersCard;

		$cities = City::isActive()->sort(['sort' => 'asc', 'name' => 'asc'])->get()->toArray();
		$data['ymap']['cities']['999'] = 'Выбрать город';
		foreach ($cities as $city) {
			$data['ymap']['cities'][$city['id']] = $city['name'];
		}

		$people = People::getItemsArray();
		$districtsRawData = Districts::getItemsArray();

		// Создаем массив районов по person_id
		$districtsByPersonId = [];
		foreach ($districtsRawData as $region) {
			$districtsByPersonId[$region['person_id']][] = $region['id'];
			$data['representatives']['districts'][$region['id']] = $region['title'];
		}

		$data['representatives']['people']  = array_map(function ($human) use ($districtsByPersonId) {
			$human['district_id'] = isset($districtsByPersonId[$human['id']]) ?  implode('|', $districtsByPersonId[$human['id']]) : '';
			return $human;
		}, $people);

		return view('contacts', $data);
	}
}
