<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;
use App\Web\User\Models\Category\CategoryModel;

class CategoryEditModel extends AppModel
{
  public static function getEditData(int $id) : array
  {
    $id = trim($id);
    $data['category'] = CategoryDBModel::getEditDataDB($id);
    if(empty($data['category']))
      return [];
    if($data['category']['parent_id'] != 0)
      $data['parent'] = CategoryDBModel::getEditDataDB($data['category']['parent_id']);
    else
      $data['parent']['name'] = "root";
    $tpl = '/var/www/App/Web/Admin/Views/Pages/Category/Edit/categoryEditNestedTreeView.php';
		$categoryModel = new CategoryModel($tpl);
    $data['tree'] = $categoryModel->getData();
    return $data;
  }

}
