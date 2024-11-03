<?php

namespace vendor\core\libs;

use vendor\core\base\Controller;

   class Router
   {
      protected static $routes = [];
      public static $route = [];

		private const HOME_CONTROLLER = 'Home';
		private const USER_CONTROLLER = 'App\\Web\\User\\Controllers\\';
		private const ADMIN_CONTROLLER = 'App\\Web\\Admin\\Controllers\\';
    private static $nestPosition = 3;

      public static function user(string $regexp, string $route = "") : void
  		{	
				  self::$routes[$regexp] = $route;
      }

      public static function admin($regexp, string $route = "") : void
      {
				  self::$routes['/admin' . $regexp] = $route;
          #die(debug($regexp));
      }

      private static function matchRoute(string $url) : bool
      {
			  $uri = self::urlCutParam($url);
         foreach (self::$routes as $pattern => $value)
         {
            if(preg_match("#^{$pattern}$#i", $uri, $matches))
            {
					$array = explode('/', substr($matches[0], 1), 4);
					if(empty($array[0])){
						self::$route = ['prefix' => 'user',
										 	 'controller' => self::HOME_CONTROLLER,
								 		    'action' => 'index'];
					}
          elseif($array[0] == 'admin'){
						self::$route = ['prefix' => 'admin',
										 	 'controller' => ucfirst($array[1])
            ];
            self::changeAdminAction($array); 
					}else{
						self::$route = ['prefix' => 'user',
										 	 'controller' => ucfirst($array[0]),
								  		  'action' => "index"];
								  		   # 'action' => lcfirst($array[1])];
					}
					if(isset($array[self::$nestPosition])){
						self::$route['nest'] = $array[self::$nestPosition];	  
					}
            	return true;
				}
			}
         return false;
      }

      public static function dispatch(string $url) : void
      {
			if(self::matchRoute($url)){
				if(self::$route['prefix'] == 'admin')
					$controller = self::ADMIN_CONTROLLER  . self::$route['controller'] . 'Controller';
				else
					$controller = self::USER_CONTROLLER  . self::$route['controller'] . 'Controller';
			}
         else
            throw new \Exception("Введенный адрес {$url} не совпадает с шаблоном", 404);
         if(class_exists($controller))
            $action = self::$route['action'];
         else
            throw new \Exception("Контроллер {$controller} не найден", 404);
         if(method_exists($controller, $action))
         {
            $controllerObject = new $controller(self::$route);
            $controllerObject->$action();
            $controllerObject->getView();
         }
         else
            throw new \Exception("Метод  {$controller::$action} не найден", 404);
      }

      private static function urlCutParam(string $url) : string
      {
			  $uri = explode('?' , $url);
			  return (substr($uri[0], -1) == '/') ? substr($uri[0], 0, -1) : $uri[0];
		  }		  
   

      private static function getResourceRoute() : string
      {
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['_method']) && $_POST['_method'] == "PATCH")
          return 'update';
        elseif(isset($_POST['_method']) && $_POST['_method'] == "DELETE")
          return 'destroy';
        else
          return 'store';
      }else
        return 'index';
    }

      private static function changeAdminAction(array $array) : void 
      { 
      if(isset($array[2]) && isset($array[3]) && $array[2] == "edit" && preg_match("#^\d+$#", $array[3])){
        self::$route['action'] = 'edit';
        self::$route['id'] = $array[3];
        self::$nestPosition = 4;
      }
      if(isset($array[2])){
        if(preg_match("#^\d+$#", $array[2])){
          self::$route['action'] = self::getResourceRoute();
          self::$route['id'] = $array[2];
        }else{
          self::$route['action'] = $array[2];    
        }
      }else{
        self::$route['action'] = self::getResourceRoute();
      }
      }
    }

 ?>
