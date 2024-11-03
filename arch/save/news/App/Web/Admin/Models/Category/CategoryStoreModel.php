<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;

class CategoryStoreModel extends AppModel
{
  public static function storeData(array $data) : void
  {
    $data['parent_id'] = trim($data['parent_id']);
    $data['name'] = trim($data['name']);
    CategoryDBModel::storeDataDB($data);
  }

}
