<?php

namespace App\Web\User\Controllers;

use App\Web\User\Models\CreatePost\CreatePostModel;

class CreatePostController extends AppController
{
	public static function index()
	{
		$data = CreatePostModel::getData();
		$title = "";
		$description = "";
		$keywords = "";
		$this->setMeta($title, $description, $keywords);
		$this->setData($data);
	}
}
