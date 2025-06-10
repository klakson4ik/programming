<?php

namespace App\Models\Page;

class NewsDetailPage extends NewsDetailBasePage
{
	protected static $img = 'news-bg.png';


	public static function get()
	{
		return parent::get();
	}
}
