<?php

namespace vendor\core\libs\Console;

class Filer
{
	public static function createFile($fileName, $text){
		if(!file_exists($fileName)){ // Если файл не существует, то создаем
			$fIn = fopen($fileName, 'w');
			fwrite($fIn, $text);
			fclose($fIn);
			echo $fileName .  ' exist' . PHP_EOL;
			return true;
		}else{
			echo $fileName . ' the file already exists' . PHP_EOL;
			return false;	  
		}
	}

	public static function createDir($dir){
		if(file_exists($dir)){
			echo $dir . ' the directory already exists';
			return true;
		}
		else{
			mkdir($dir);
			return true;
		}
	}

	public static function fileAppend($fileName, $text){
		if(file_exists($fileName)){
			file_put_contents($fileName, $text, FILE_APPEND);
			echo $fileName . ' appended' . PHP_EOL;
			return true;
		}else{
			echo $fileName . ' the file does not exist' . PHP_EOL;
			return false;		  
		}
	}
}
