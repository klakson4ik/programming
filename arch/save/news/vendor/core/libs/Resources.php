<?php

namespace vendor\core\libs;

class Resources {

  public static function createRoutes(string $route) : void 
  {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      Router::admin('/' . $route, $route);
      Router::admin('/' . $route . '/' . '\d+', $route);
    }else{
      Router::admin('/' . $route , $route . '.index');
      Router::admin('/' . $route . '/create' , $route . '.create');
      Router::admin('/' . $route . '/edit/\d+' , $route . '.edit');
    }

  }

}


