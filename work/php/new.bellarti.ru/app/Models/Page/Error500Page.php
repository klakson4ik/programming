<?php

namespace App\Models\Page;

class Error500Page extends StaticModel
{
	protected const PAGE = 'error';

	public static function get()
	{
		$data =  [
			'error' => self::getError(),
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getError()
	{
		return [
			'title' => '500',
			'subtitle' => 'Скоро всё будет',
		];
	}
}
