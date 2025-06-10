<?php

namespace App\Models\Page;

class NewsBasePage extends StaticModel
{
	protected const PAGE = 'news';
	protected static $img;
	protected static $active;
	protected static $more;
	protected static $main_title;
	protected static $seo_title;
	protected static $seo_description;
	protected static $template = 'content';
	protected static $newsCount = 9;

	public static function get()
	{
		$data =  [
			'newsCount' => static::$newsCount,
			'trash' => self::getTrash(),
			'main' => self::getMain(),
			'content' => self::getContent(),
			'template' => static::$template,

			'main_title' => static::$main_title,
			'seo_title' => static::$seo_title,
			'seo_description' => static::$seo_description,
			'seo_keywords' => 'Bellarti',
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getNewsCount()
	{
		return static::$newsCount;
	}

	public static function getTrash()
	{
		return [
			self::getImage('trash.png'),
		];
	}

	public static function getMain()
	{
		return [
			'block' => getBlockName('main'),
			'title' =>	'Блог и новости',
			'title_events' => 'События',
			'img' => self::getImage(static::$img)
		];
	}

	public static function getContent($block = 'content')
	{
		return [
			'block' => getBlockName($block),
			'tabs' => [
				[
					'caption' => 'Блог',
					'link' => getLink('/blogs'),
					'active' => static::$active === 'blogs' ? 'active' : ''
				],
				[
					'caption' => 'Новости',
					'link' => getLink('/news'),
					'active' => static::$active === 'news' ? 'active' : ''
				],
				[
					'caption' => 'События',
					'link' => getLink('/events'),
					'active' => static::$active === 'events' ? 'active' : ''
				],
			],
			'more' => static::$more,
			'active' => static::$active
		];
	}
}
