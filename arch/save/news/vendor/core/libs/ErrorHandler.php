<?php

namespace vendor\core\libs;

class ErrorHandler
{
   public function __construct()
   {
      if(DEBUG)
         error_reporting(-1);
      else
         error_reporting(0);
      set_exception_handler([$this, 'exceptionHandler']);
   }

   public function exceptionHandler($e)
   {
      $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
      $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
   }

   private function logErrors($message = '', $file = '', $line = '')
   {
      error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} |
      файл: {$file} | Строка: {$line} \n==================\n", 3, ROOT . '/tmp/errors.log');
   }

   private function displayError($errno, $errstr, $errfile, $errline, $response = 404)
   {
      http_response_code($response);
      if($response == 404 && !DEBUG)
         {
            require WWW . '/errors/404.php';
            die;
         }
      if(DEBUG)
         require WWW . '/errors/dev.php';
      else
         require WWW . '/errors/prod.php';
   }
}

 ?>
