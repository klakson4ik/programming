<?php

namespace App\Web\User\Controllers;

use App\Web\User\Models\Category\CategoryModel;
use vendor\core\libs\Cache;

class CategoryController extends AppController 
{
	public static function index()
  {
    if(!Cache::getCache("category")){
      $tpl = '/var/www/App/Web/User/Views/Pages/Category/categoryNestedTreeView.php';
		  $categoryModel = new CategoryModel($tpl);
		  $data = $categoryModel->getData();
      Cache::setCache("category", $data, 3600*24);
      return $data;  
    }else
      return Cache::getCache("category");
  }
}
