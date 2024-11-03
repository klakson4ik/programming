<?php

namespace App\Web\User\Controllers;

use App\Web\User\Models\Home\HomeModel;
use App\Web\User\Widgets\Pagination\Pagination;

class HomeController extends AppController
{
	public function index()
	{
		$title = "Gonomax - read, watch and have a good rest";
		$description = "Come on. You will find a lot of interesting and relevant news on all sorts of topics, it will not be boring. Share your favorite publications with your friends.";
		$keywords = "news, sports, bussines, art, medicine, daily, realtime, adventure, future, politics, films, live, entertainments,
events ";
		$this->setMeta($title, $description, $keywords);
    $pagination = new Pagination();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $data = $pagination->getPagination($page, 60);
    //die(debug($data))
		$this->setData($data);
	}
}
