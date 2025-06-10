<?php

namespace App\Models\Page;

use App\Models\Event;
use App\Services\Calendar\Calendar;

class EventPage extends NewsBasePage
{
	protected static $img = 'event-bg.png';
	protected static $active = 'events';
	protected static $more = 'Больше мероприятий';
	protected static $template = 'content-event';
	protected static $newsCount = 5;


	public static function get()
	{
		return [
			'newsCount' => static::$newsCount,
			'trash' => self::getTrash(),
			'common' => self::getCommon(),
			'main' => self::getMain(),
			'content' => self::getContent('content-event'),
			'template' => static::$template,
			'block' => getBlockName('event'),
			'asset' => 'event',

			'main_title' => 'Мероприятия Bellarti',
			'seo_title' => 'Мероприятия Bellarti: конференции, мастер-классы и тренинги',
			'seo_description' => 'Узнайте больше о&nbsp;мероприятиях Bellarti: участвуйте в&nbsp;профессиональных тренингах, мастер-классах и конференциях по&nbsp;биоревитализации и&nbsp;уходу за&nbsp;кожей',
			'seo_keywords' => 'Bellarti',
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
			'discl' => 'В настоящее время в&nbsp;расписании отсутствуют мероприятия.',
		];
	}
}
