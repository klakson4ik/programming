<?php

namespace App\Web\Admin\Models\Category;

use App\Web\Admin\Models\AppModel;

class CategoryDestroyModel extends AppModel
{
  public static function destroyData(int $id) : void
  {
    CategoryDBModel::destroyDataDB($id);
  }

}
