<?php

namespace vendor\core\base;

class Controller
{
   public $route;
   private $controller;
   private $view;
   private $prefix;
	private $nest;
   private $layout;
   private $data = [];
   private $meta = ['title' => '', 'description' => '', 'keywords' => ''];

   public function __construct($route)
   {
      $this->route = $route;
      $this->controller = $route['controller'];
      $this->view = $route['action'];
		$this->route['prefix'] = isset($route['prefix']) ? $route['prefix'] : 'user';
		$this->nest = isset($route['nest']) ? $route['nest'] : '';
   }

   public function setData($data)
   {
      $this->data = $data;
   }

   public function setMeta($title = '', $description = '', $keywords = '')
   {
      $this->meta['title'] = $title;
      $this->meta['description'] = $description;
      $this->meta['keywords'] = $keywords;
   }

   public function getView()
   {
      $viewObject = new View($this->route, $this->layout, $this->view, $this->meta, $this->data);
      $viewObject->render();
   }

   public function isAjax(){
      return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] ==='XMLHttpRequest';
   }

   public function loadView($view, $vars = []){
//      extract($vars);
//       debug($vars);
      ob_start();
      require  $view;
      return ob_get_clean();
   }
}
