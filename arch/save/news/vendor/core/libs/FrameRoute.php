<?php

namespace vendor\core\libs;

use vendor\core\libs\Helpers\Timer;

class FrameRoute
{
      public static function start() : void
      {
			require_once '/var/www/config/init.php';
			 
			require LIBS . '/AutoLoadClasses.php';

			AutoLoadClasses::load();

            PHPSettings::set();

            require HELPERS . '/Functions.php';
			require ROUTES . '/user.php';
			require ROUTES . '/admin.php';
      session_start();
            new ErrorHandler();
			Router::dispatch($uri);

			if(TIMER == true)
				echo Timer::finish() . ' сек.';
      }
}

