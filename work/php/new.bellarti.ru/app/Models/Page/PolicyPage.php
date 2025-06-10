<?php

namespace App\Models\Page;

class PolicyPage extends StaticModel
{
	protected const PAGE = 'policy';

	public static function get()
	{
		$data =  [
			'title' => 'ПОЛИТИКА ОБРАБОТКИ ПЕРСОНАЛЬНЫХ ДАННЫХ ООО&nbsp;«ГРОТЕКС»',

			'seo_title' => 'ПОЛИТИКА ОБРАБОТКИ ПЕРСОНАЛЬНЫХ ДАННЫХ',
			'seo_description' => 'ПОЛИТИКА ОБРАБОТКИ ПЕРСОНАЛЬНЫХ ДАННЫХ',
			'seo_keywords' => 'Bellarti',

		];
		self::addBlockInfo($data);
		return $data;
	}
}
