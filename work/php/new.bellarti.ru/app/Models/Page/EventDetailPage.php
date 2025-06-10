<?php

namespace App\Models\Page;

use App\Models\Event;
use App\Services\Calendar\Calendar;

class EventDetailPage extends StaticModel
{
	protected const PAGE = 'event-detail';

	public static function get()
	{
		return [
			'main' => self::getMain(),
			'common' => self::getCommon(),
			'otherEvents' => self::getOtherEvents(),
			'block' => getBlockName('event-detail'),
			'asset' => 'event-detail'
		];
	}

	public static function getCommon()
	{
		return [
			'other' => self::getOther(),
			'calendar' => [
				'arrow' => self::getIcon('arrow'),
				'arrowDropdown' => self::getIcon('arrow-dropdown'),
				'selected' => Calendar::getCurrentMonthAndYear(),
				'items' => Calendar::getCloseMonthAndYear(),
				'days' => Calendar::getCalendarData(Event::isActive()->whereBetween('date', Calendar::getRangeMonth())->get()->toArray())
			]
		];
	}

	public static function getOther()
	{
		return [
			'future' => 'Запланированные мероприятия',
			'past' => 'Прошедшие мероприятия',
			'link' => [
				'caption' => 'ссылка на регистрацию',
				'icon' => getCommonIcon('arrow-more')
			],
			'discl' => 'В настоящее время в расписании отсутствуют мероприятия.',
		];
	}

	public static function getMain()
	{
		return [
			'block' => getBlockName('main'),
			'title' =>	'Блог и новости',
			'img' => self::getImage('events-bg.png'),
		];
	}

	public static function getOtherEvents()
	{
		return [
			'block' => getBlockName('other-events'),
			'title' =>	'Другие мероприятия',
		];
	}
}
