<?php 


namespace vendor\core\libs\Console;
use vendor\core\libs\AutoLoadClasses;

class ConsoleController
{
	private const ROOT_DIR = './vendor/core/libs/Console/';

	public static function init($param){
		require_once 'config/init.php';
		require_once 'vendor/core/libs/AutoLoadClasses.php';
		AutoLoadClasses::load();

		self::setAction($param);
	}

	private static function setAction($param){
		if(count($param) < 3){
			echo 'php console php - there must be arguments' . PHP_EOL;
			exit;
		}
		$nameDir = ucfirst($param[2]);
		$dir = self :: ROOT_DIR . $nameDir;
		if(!file_exists($dir))
		{
			echo $dir . ' the directory does not exist' .PHP_EOL;
		}else
		{		
			$controller = $nameDir . 'Controller';
			$class = 'vendor\\core\\libs\Console\\' . $nameDir . '\\' . $controller;
			$class::choiceAction($param);
		}
	}
	
}
