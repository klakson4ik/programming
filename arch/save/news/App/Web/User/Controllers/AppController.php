<?php

namespace App\Web\User\Controllers;

use vendor\core\base\Controller;
use App\Web\User\Models\AppModel;
use App\Web\User\Middleware\Visitors;

class AppController extends Controller
{
   public function __construct($route)
   {
      parent::__construct($route);
      new AppModel();
//      Visitors::init();
   }
}
