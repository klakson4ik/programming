<?php

namespace vendor\core\libs;

use vendor\core\libs\Helpers\Timer;

class PHPSettings
{
  public static function set() : void
  {
		if(TIMER == true)
			Timer::start();

		if(PHPINI == true)
			 die(phpinfo());

		if(DEBUG == true){			
			ini_set('error_reporting', E_ALL);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
		}
	}
	
}
