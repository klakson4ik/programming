<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;

class CategoryUpdateModel extends AppModel
{
  public static function updateData(int $id, array $data) : void
  {
    $data['parent_id'] = trim($data['parent_id']);
    $data['name'] = trim($data['name']);
    CategoryDBModel::updateDataDB($id, $data);
  }

}
