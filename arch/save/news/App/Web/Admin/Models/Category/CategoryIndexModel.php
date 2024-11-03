<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;
use App\Web\User\Models\Category\CategoryModel;
use vendor\core\libs\Cache;

class CategoryIndexModel extends AppModel
{
	public static function getData()
	{
      $tpl = '/var/www/App/Web/Admin/Views/Pages/Category/Index/categoryIndexNestedTreeView.php';
		  $categoryModel = new CategoryModel($tpl);
      $data = $categoryModel->getData();
      if(isset($_SESSION['category_update']))
        self::updateCategoryCache();
      return $data;  
	}

	private static function updateCategoryCache() : void
	{
      $tpl = '/var/www/App/Web/User/Views/Pages/Category/Index/categoryIndexNestedTreeView.php';
		  $categoryModel = new CategoryModel($tpl);
		  $data = $categoryModel->getData();
      Cache::setCache("category", $data, 3600*24*7);
      unset($_SESSION['category_update']);
	}
}
