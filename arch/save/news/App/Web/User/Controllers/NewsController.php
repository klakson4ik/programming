<?php

namespace App\Web\User\Controllers;

use App\Web\User\Models\News\NewsModel;

class NewsController extends AppController
{
	public function index()
	{
    $data = [];
		$article = NewsModel::getData($_GET["id"]);
    $related = NewsModel::getDataRelated();
		$title = $article["article"]["title"];
		$description = $article["article"]["description"];
		$keywords = $article["article"]["keywords"];
		$this->setMeta($title, $description, $keywords);
    $data['article'] = $article;
    $data['related'] = $related;
		$this->setData($data);
	}
}
