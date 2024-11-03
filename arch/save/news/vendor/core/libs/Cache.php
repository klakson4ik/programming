<?php

namespace vendor\core\libs;


class Cache
{
   public static function setCache(string $key, $data, int $seconds = 3600) : bool
   {
      if($seconds)
         {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content)))
               return true;
         }
      return false;
   }

   public static function getCache(string $key)
   {
      $file = CACHE . '/' . md5($key) . '.txt';
      if(file_exists($file))
      {
         $content = unserialize(file_get_contents($file));
         if(time() <= $content['end_time'])
            return $content['data'];
         unlink($file);
      }
      return false;

   }

   public static function deleteCache(string $key) : void
   {
      $file = CACHE . '/' . md5($key) . '.txt';
      if(file_exists($key))
         unlink($file);
   }
}


 ?>
