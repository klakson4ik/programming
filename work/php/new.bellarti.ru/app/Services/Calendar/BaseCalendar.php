<?php

namespace App\Services\Calendar;

use App\Helpers\SiteHelpers;

class BaseCalendar
{
	private const MONTH_RU = [
		'01' => ['январь', 'января'],
		'02' => ['февраль', 'февраля'],
		'03' => ['март', 'марта'],
		'04' => ['апрель', 'апреля'],
		'05' => ['май', 'мая'],
		'06' => ['июнь', 'июня'],
		'07' => ['июль', 'июля'],
		'08' => ['август', 'августа'],
		'09' => ['сентябрь', 'сентября'],
		'10' => ['октябрь', 'октября'],
		'11' => ['ноябрь', 'ноября'],
		'12' => ['декабрь', 'декабря']
	];

	private static $currentTimestamp;

	public static function getCurrentMonthAndYear()
	{
		$month = self::MONTH_RU[date('m')][0];
		return $month . ' ' . date('Y');
	}

	public static function getDateFormat(string $date)
	{
		$dateArr = explode('-', $date);
		return self::MONTH_RU[$dateArr[1]][0] . ' ' . $dateArr[0];
	}


	public static function getRangeMonth(string|false $date = false, string $type = 'select', int $addToRangeDays = 6)
	{
		$dateArr = self::getDateArr($date);
		$month = match ($type) {
			'next' => $dateArr[1] + 1,
			'prev' => $dateArr[1] - 1,
			'select' => $dateArr[1]
		};
		return [
			date('Y-m-d', mktime(0, day: 1 - $addToRangeDays, year: $dateArr[0], month: $month)),
			date('Y-m-d', mktime(0, day: date('t') + $addToRangeDays, year: $dateArr[0], month: $month)),

		];
	}

	public static function getTypeSelectDates(string $date, string $type)
	{
		return match ($type) {
			'next' => self::getCloseMonthAndYearNext($date),
			'prev' => self::getCloseMonthAndYearPrev($date),
			'select' => self::getCloseMonthAndYear($date)
		};
	}

	public static function getTypeCurrentDate(string $date, string $type)
	{
		return match ($type) {
			'next' => self::getCurrentDateNext($date),
			'prev' => self::getCurrentDatePrev($date),
			'select' => self::getCurrentDateSelect($date)
		};
	}

	public static function getCloseMonthAndYear(string|false $date = false)
	{
		$resultTmp = [];
		$result = [];
		$dateArr = self::getDateArr($date);
		for ($i = 5; $i >= 0; $i--) {
			$resultTmp[] = self::getDateTamplate($dateArr, $i, false);
		}

		for ($i = 1; $i < 7; $i++) {
			$resultTmp[] = self::getDateTamplate($dateArr, $i);
		}
		foreach ($resultTmp as $item) {
			$result[$item] = self::getDateFormat($item);
		}
		return $result;
	}

	protected static function getDateArr(string|false $date = false)
	{
		return $date
			? explode('-', $date)
			: [date('Y'), date('m')];
	}

	protected static function getFormatData(array $data, string|false $date)
	{
		self::$currentTimestamp = strtotime(date('Y-m-d'));
		$date = implode('-', self::getDateArr($date));
		$countDays = (int)self::getCountDay($date);
		$countDaysPrev = (int)self::getCountPrevDay($date);
		$firstDayMonth = (int)self::getMonthFirstDayWeek($date) - 1;
		$result = [];
		$firstDayMonthPrev = $countDaysPrev - (($firstDayMonth < 0) ? 6 : $firstDayMonth) + 1;

		$prevMonth = self::MONTH_RU[explode('-', self::getCurrentDatePrev($date))[1]][1];
		for ($i = $firstDayMonthPrev; $i <= $countDaysPrev; $i++) {
			$prevDate = self::getCurrentDatePrev($date);
			$result[] = self::getCalendarDay($data, $prevDate, $i, $prevMonth);
		}

		$currMonth = self::MONTH_RU[explode('-', $date)[1]][1];
		for ($i = 1; $i <= $countDays; $i++) {
			$result[] = self::getCalendarDay($data, $date, $i, $currMonth, false);
		}

		$countCurrent = count($result);
		$add = ($countCurrent > 35)
			? 43 - $countCurrent
			: 36 - $countCurrent;
		$nextMonth = self::MONTH_RU[explode('-', self::getCurrentDateNext($date))[1]][1];
		for ($i = 1; $i < $add; $i++) {
			$nextDate = self::getCurrentDateNext($date);
			$result[] = self::getCalendarDay($data, $nextDate, $i, $nextMonth);
		}
		return $result;
	}

	private static function getCountDay(string|false $date = false)
	{
		$dateArr = self::getDateArr($date);
		return date('t', mktime(0, day: 1, year: $dateArr[0], month: $dateArr[1]));
	}

	private static function getCountPrevDay(string|false $date = false)
	{
		$dateArr = self::getDateArr($date);
		return date('t', mktime(0, day: 1, year: $dateArr[0], month: ($dateArr[1] - 1)));
	}

	private static function getMonthFirstDayWeek(string|false $date = false)
	{
		$dateArr = self::getDateArr($date);
		return date("w", mktime(0, day: 1, year: $dateArr[0], month: $dateArr[1]));
	}

	private static function getCloseMonthAndYearNext(string $date)
	{
		return self::getCloseMonthAndYear(self::getCurrentDateNext($date));
	}

	private static function getCloseMonthAndYearPrev(string $date)
	{
		return self::getCloseMonthAndYear(self::getCurrentDatePrev($date));
	}

	private static function getCurrentDateNext(string $date)
	{
		$dateArr = explode('-', $date);
		return self::getDateTamplate($dateArr);
	}

	private static function getCurrentDatePrev(string $date)
	{
		$dateArr = explode('-', $date);
		return self::getDateTamplate($dateArr, plus: false);
	}

	private static function getCurrentDateSelect(string $date)
	{
		$dateArr = explode('-', $date);
		return date('Y-m', mktime(0, day: 1, year: $dateArr[0], month: ($dateArr[1])));
	}

	private static function getCalendarDay(array $data, string $date, int $i, string $month, bool $out = true)
	{
		$day = $date . '-' . (($i < 10) ? '0' . $i : $i);
		$timestamp = strtotime($day);
		$events = array_key_exists($day, $data) ? $data[$day] : false;
		return [
			'number' => $i,
			'month' => $month,
			'day' => $day,
			'events' => $events,
			'passed' => $timestamp < self::$currentTimestamp ? true : false,
			'out' => $out,
			'current' => $timestamp === self::$currentTimestamp ? true : false,
			'events-count' => $events ? SiteHelpers::numWord(count($events), ['событие', 'события', 'событий']) : false
		];
	}

	private static function getDateTamplate(array $date, int $count = 1, bool $plus = true)
	{
		return $plus
			? date('Y-m', mktime(0, day: 1, year: $date[0], month: ((int)$date[1] + $count)))
			: date('Y-m', mktime(0, day: 1, year: $date[0], month: ((int)$date[1] - $count)));
	}
}
