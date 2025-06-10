<?php

namespace App\Models\Page;

class BlogPage extends NewsBasePage
{
	protected static $img = 'blog-bg.png';
	protected static $active = 'blogs';
	protected static $more = 'Больше блогов';

	protected static $main_title = 'О красоте и уходе за кожей от экспертов Bellarti';
	protected static $seo_title = 'Блог Bellarti — экспертные статьи о красоте и уходе за кожей';
	protected static $seo_description = 'Читайте блог Bellarti: советы по уходу за кожей, последние тренды в косметологии и экспертные рекомендации по биоревитализации';


	public static function get()
	{
		return parent::get();
	}
}
