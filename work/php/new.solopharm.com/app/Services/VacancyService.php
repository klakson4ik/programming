<?php

namespace App\Services;

class VacancyService
{

	public static function getByDepartment($items)
	{
		$array = [];

		foreach ($items as $item) {
			$array[$item->department][] = $item;
		}
		arsort($array);
		return $array;
	}

	public static function getByCity($items)
	{
		$array = [];

		foreach ($items as $item) {
			$array[$item->city][] = $item;
		}
		arsort($array);
		return $array;
	}

	public static function getCounts($items)
	{
		$spb = 0;
		$other = 0;
		foreach ($items as $item) {
			switch ($item->city) {
				case 'Санкт-Петербург':
					++$spb;
					break;
				default:
					++$other;
					break;
			}
		}

		return [
			'Санкт-Петербург' => $spb,
			'Другие' => $other
		];
	}
}
