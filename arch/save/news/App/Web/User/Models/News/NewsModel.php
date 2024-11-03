<?php

namespace App\Web\User\Models\News;

use App\Web\User\Models\AppModel;

class NewsModel extends AppModel
{
	public static function getData($id) : array
	{
		$dataDB = NewsDBModel::getDataDB($id);
    $_SESSION['news'] = $dataDB;
		return $dataDB;
	}

	public static function getDataRelated() : array
	{
		$dataDB = NewsDBModel::getDataRelatedDB();
//    $data =[];
//    foreach($dataDB["articles"] as $key=>$article){
//      $data[$article['id']] = $article;
//      foreach($dataDB["images"] as $image){
//        if($article['id'] == $image["articles_id"]){
//          $data[$article['id']]["images"][] = $image;  
//        }
//      }
//    }
//    $rand = array_rand($data, 6);
//    $array = [];
//    foreach($rand as $keyr=>$value){
//      $array[$value] = $data[$value]; 
//    }
		return $dataDB;
	}
}
