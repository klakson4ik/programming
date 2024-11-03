<?php

namespace vendor\core\libs\Console\Element;

class ElementController
{
		public static function choiceAction($param){
		if(!isset($param[3]))
			die('it is necessary to set the name of the new controller as the third parameter' . PHP_EOL);
		$firstW = ucfirst($param[1]);
		$secondW = ucfirst($param[2]);
		if($firstW == 'Res')
			$firstW = 'Resource';
		$className = $firstW . $secondW;
		$class = 'vendor\\core\\libs\\Console\\Element\\' .  $className;
		if(class_exists($class)){
			$method = lcfirst($firstW);
			isset($param[4]) ? $class::$method($param[3], $param[4]) :	$class::$method($param[3]); 
		}	  
		else
			die('class ' . $className . ' doesn\'t exist' . PHP_EOL);		  
	}
}

