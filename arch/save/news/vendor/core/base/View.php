<?php
namespace vendor\core\base;

class View
{
   private $route;
   private $controller;
   private $action;
   private $view;
   private $layout;
   private $data = [];
   private $meta = [];

   public function __construct($route = '', $layout = '', $view = '', $meta = '' , $data = '')
   {
      $this->route = $route;
      $this->controller = $route['controller'];
      $this->action = $route['action'];
      $this->view = $view;
      $this->meta = $meta;
      $this->data = $data;
      if($layout === false)
         $this->layout = false;
      else
         $this->layout = $layout ?: LAYOUT;
   }

   public function render()
	{		
			if($this->route['prefix'] == "user")
			  $viewFile = USER . PAGES . "/" . $this->controller . "/" . lcfirst($this->controller) . "View.php";
      else
			  $viewFile = ADMIN . PAGES . "/" . $this->controller . "/" . ucfirst($this->action) . "/" . lcfirst($this->controller) . ucfirst($this->view) . "View.php";
      if(is_file($viewFile))
      {
         ob_start();
         require_once $viewFile;
         $content = ob_get_clean();
      }
      else
         throw new \Exception("{$viewFile} вид не найден", 404);
      if(false !== $this->layout)
		  {
			  if($this->route['prefix'] == "user")
          $layoutFile = USER . LAYOUTS . "/{$this->layout}/{$this->layout}.php";
        else
          $layoutFile = ADMIN . LAYOUTS . "/{$this->layout}/{$this->layout}.php";

         if(is_file($layoutFile))
            require_once $layoutFile;
         else
            throw new \Exception("{$layoutFile} шаблон не найден", 404);
      }

   }

   public function getMeta()
   {
      $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL;
      $output .= '<meta name="description" content="' . $this->meta['description'] . '">' . PHP_EOL;
      $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
      return $output;
   }

   public function getData()
   {
      return $this->data;
   }
}
