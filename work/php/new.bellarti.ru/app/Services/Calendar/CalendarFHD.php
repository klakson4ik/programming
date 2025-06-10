<?php

namespace App\Services\Calendar;

class CalendarFHD extends BaseCalendar
{
	private const WEEKDAY = [
		'Пн',
		'Вт',
		'Ср',
		'Чт',
		'Пт',
		'Сб',
		'Вс'
	];

	public static function getCalendarData(array $data, string|false $date = false)
	{
		foreach ($data as $item) {
			$data[$item['date']][] = [
				'id' => $item['id'],
				'time' => $item['time'],
				'title' => $item['title'],
				'description' => $item['description'],
				'code' => $item['code'],
				'city' => [
					'id' => $item['city_id'],
					'name' => $item['city']['name']
				]
			];
		}

		return [
			'days' => self::getFormatData($data, $date),
			'header' => self::WEEKDAY
		];
	}
}
