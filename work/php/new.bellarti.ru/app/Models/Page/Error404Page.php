<?php

namespace App\Models\Page;

class Error404Page extends StaticModel
{
	protected const PAGE = 'error';

	public static function get()
	{
		$data =  [
			'error' => self::getError(),

			'seo_title' => '404',
			'seo_description' => '404',
			'seo_keywords' => 'Bellarti',
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getError()
	{
		return [
			'title' => '404',
			'subtitle' => 'Страница не&nbsp;найдена',
			'desc' => 'Такой страницы не&nbsp;существует, или&nbsp;она была удалена.
					   Попробуйте начать все с&nbsp;начала и&nbsp;поищите что-нибудь другое.',
			'data' => [
				'img' => self::getResizedImage('drop.png', [false, '310', false]),
				'title' => 'вернуться на&nbsp;главную',
				'url' => '/'
			]
		];
	}
}
