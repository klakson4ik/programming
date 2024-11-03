<?php

namespace vendor\core\libs\AutoComplete;
use vendor\core\libs\Console\Filer;

class Curl
{
  public function getData()
  {

      $json = file_get_contents('vendor/core/libs/AutoComplete/trends.json');
      var_dump($json);
      //require 'vendor/core/libs/Console/Filer.php';
      //$file = fopen('vendor/core/libs/Curl/curl.html', 'w');
      //$ch = curl_init('https://trends.google.com/trends/trendingsearches/daily?geo=US');
      //curl_setopt( $ch, CURLOPT_HEADER, true ); 
      //curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true ); 
      //curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false ); 
      //curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false ); 
      //curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
      //curl_setopt( $ch, CURLOPT_FILE, $file);


      //curl_exec($ch);

      //$pattern = '#Ted Cruz#';
      //preg_match($pattern, $data, $matches);
      //var_dump($matches);
       
      //$data = file_get_contents('https://google.com');
  //    die(var_dump($data));
      //fwrite($file, $data);
      //curl_close($ch);
    
      //fclose($file);

      //Filer::createFile('curt.html', $data);
     // return $data;
  }
}
