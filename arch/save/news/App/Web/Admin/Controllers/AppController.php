<?php

namespace App\Web\Admin\Controllers;

use vendor\core\base\Controller;
use App\Web\Admin\Models\AppModel;

class AppController extends Controller
{
   public function __construct($route)
   {
      parent::__construct($route);
      new AppModel();

   }
}
