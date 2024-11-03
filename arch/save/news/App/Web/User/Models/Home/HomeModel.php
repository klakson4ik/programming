<?php

namespace App\Web\User\Models\Home;

use App\Web\User\Models\AppModel;

class HomeModel extends AppModel
{
	public static function getData($page, $perpage) : array
	{
		$dataDB = HomeDBModel::getDataDB($page, $perpage);
//    $data =[];
//    foreach($dataDB["articles"] as $key=>$article){
//      $data[$article['id']] = $article;
//      foreach($dataDB["images"] as $image){
//        if($article['id'] == $image["articles_id"]){
//          $data[$article['id']]["images"][] = $image;  
//        }
//      }
//    }
		return $dataDB;
	}
}
