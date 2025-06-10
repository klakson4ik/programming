<?php

namespace App\Models\Page;

class NewsDetailBasePage extends StaticModel
{
	protected const PAGE = 'news-detail';
	protected static $template = 'content';
	protected static $img;

	public static function get()
	{
		$data =  [
			'template' => static::$template,
			'common' => self::getTrash(),
			'main' => self::getMain(),
			'text' => self::getText(),
			'otherProduct' => HomePage::getProduct('Линейка Bellarti<sup>®</sup>'),
			'ymap' => self::getYmap(),
			'blog' => self::getBlog(),
			'OtherArticles' => self::getOtherArticles(),
		];

		self::addBlockInfo($data);
		return $data;
	}

	public static function getTrash()
	{
		return [
			'trash' => self::getImage('trash.png'),
			'trash-1' => self::getImage('trash-1.png'),
			'trash-2' => self::getImage('trash-2.png'),
			'trash-3' => self::getImage('trash-3.png'),

		];
	}

	public static function getMain()
	{
		return [
			'block' => getBlockName('main'),
			'title' => 'Что такое биоревитализация',
			'img' => self::getImage(static::$img)
		];
	}

	public static function getText()
	{
		return [
			'block' => getBlockName('text'),
		];
	}

	public static function getYmap(string $title = 'Клиники-партнеры')
	{
		return [
			'block' => getBlockName('ymap'),
			'title' => $title,
			'selects' => [
				'city' => [
					'selected' => 'Выбрать город',
					'arrow' => self::getIcon('arrow-1')
				],
			],
			'ymapKey' => env('YMAP_KEY', false)
		];
	}

	public static function getBlog()
	{
		return [
			'block' => getBlockName('blog'),
			'title' => 'Другие статьи'
		];
	}


	public static function getOtherArticles()
	{
		return [
			'block' => 'other-articles',
			'title' => 'Другие статьи',
		];
	}
}
