<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelpers;
use App\Models\Blog;
use App\Models\Page\BlogPage;

class BlogController extends Controller
{
	public function __invoke()
	{
		$data = BlogPage::get();
		$pagNewsData = Blog::getItems()->paginate($data['newsCount'])->toArray();
		$data['cards'] = $pagNewsData['data'];
		$data['isMore'] = ($pagNewsData['to'] < $pagNewsData['total'])
			? true
			: false;
		ImageHelpers::getImagesArray($data['cards']);
		return view('news', $data);
	}
}
