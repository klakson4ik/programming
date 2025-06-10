<?php

namespace App\Models\Page;

class NewsPage extends NewsBasePage
{
	protected static $img = 'news-bg.png';
	protected static $active = 'news';
	protected static $more = 'Больше статей';

	protected static $main_title = 'Новости Bellarti о последних разработках и событиях';
	protected static $seo_title = 'Новости Bellarti';
	protected static $seo_description = 'Следите за последними новостями и событиями компании Bellarti. Рассказываем о новых препаратах, достижениях и событиях компании';

	public static function get()
	{
		return parent::get();
	}
}
