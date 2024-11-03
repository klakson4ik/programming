<?php

namespace vendor\core\libs;

class AutoLoadClasses
{
	public static function load() : void
	{
		spl_autoload_register(function($class) {
			$file =  ROOT . '/' . str_replace('\\', '/', $class) . '.php';
			if(file_exists($file))
				require_once $file;
		});
	}
}
