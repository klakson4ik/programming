<?php

namespace App\Services\Calendar;

use App\Services\Calendar\BaseCalendar;

class Calendar extends BaseCalendar
{

	public static function getCalendarData(array $data, string|false $date = false)
	{
		foreach ($data as $item) {
			$data[$item['date']][] = [
				'id' => $item['id'],
			];
		}

		return self::getFormatData($data, $date);
	}

	// Возвращает массив с двумя ключами: future (будущие события) и past (прошедшие события). 
	// Будущие события возвращаются в обратном порядке, 
	// чтобы самые близкие к текущей дате события были первыми.
	public static function getCloseEvents(array $data, int $count = 999)
	{
		$future = [];
		$past = [];
		$currentDate = date('Y-m-d');
		foreach ($data as $item) {
			if ($currentDate <= $item['date']) {
				if (count($future) < $count) {
					$future[] = $item;
				} else {
					$future = array_slice($future, 1);
					$future[] = $item;
				}
			} elseif (count($past) < $count)
				$past[] = $item;
		}
		return [
			'future' => array_reverse($future),
			'past' => $past
		];
	}


	public static function getRangeYear(string|false $date = false, int $plusYears = 0)
	{
		$dateArr = self::getDateArr($date);
		return [
			date('Y-m-d', mktime(0, day: 1, year: $dateArr[0], month: 1)),
			date('Y-m-d', mktime(0, day: 31, year: $dateArr[0] + $plusYears, month: 12)),

		];
	}

	public static function getRangeYearCurrentDate(int $plusYears = 0)
	{
		$dateArr = self::getDateArr(date('Y-m-d'));
		return [
			date('Y-m-d', mktime(0, year: $dateArr[0], month: $dateArr[1])),
			date('Y-m-d', mktime(0, day: 31, year: $dateArr[0] + $plusYears, month: 12)),

		];
	}
}
