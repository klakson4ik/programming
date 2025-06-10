<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\News;
use App\Models\Page\NewsPage;

class NewsController extends Controller
{
	public function __invoke()
	{
		$data = NewsPage::get();

		$pagNewsData = News::getItems()->paginate($data['newsCount'])->toArray();
		$data['cards'] = $pagNewsData['data'];
		$data['isMore'] = ($pagNewsData['to'] < $pagNewsData['total'])
			? true
			: false;
		ImageHelpers::getImagesArray($data['cards']);

		return view('news', $data);
	}
}
