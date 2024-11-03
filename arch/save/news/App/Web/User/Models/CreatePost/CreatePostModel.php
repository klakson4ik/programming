<?php

namespace App\Web\User\Models\CreatePost;

use App\Web\User\Models\AppModel;

class CreatePostModel extends AppModel
{
	public static function getData() : array
	{
		$dataDB = CreatePostDBModel::getDataDB();
		return $dataDB;
	}
}
