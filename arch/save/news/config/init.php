<?php

define('PROD', 0);
define('PHPINI', 0);
define('DEBUG', 1);
define('LAYOUT', 'default');
define('TIMER', 1);

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/App');

define('ADMIN', APP . '/Web/Admin');
define('USER', APP . '/Web/User');

define('CONTROLLERS', '/Controllers');
define('MODELS', '/Models');
define('VIEWS',  '/Views');
define('WIDGETS',  '/Widgets');
		  
define('PARTIALS', VIEWS . '/Partials');
define('PAGES', VIEWS . '/Pages');
define('LAYOUTS', VIEWS . '/Layouts');
define('MODALS', PARTIALS . '/Modals');

define('CORE', ROOT . '/vendor/core');
define('LIBS', ROOT . '/vendor/core/libs');
define('WWW', ROOT . '/public');
define('CACHE', ROOT . '/tmp/cache');
define('CONFIG', ROOT . '/config');
define('HELPERS', LIBS . '/Helpers');
define('ROUTES', ROOT . '/routes');

define('CSS_ADMIN', ROOT . '/resources/css/admin');
define('CSS_USER', ROOT . '/resources/css/user');
define('CSS_COMMON', ROOT . '/resources/css/common');
define('JS_ADMIN', ROOT . '/resources/js/admin');
define('JS_USER', ROOT . '/resources/js/user');
define('JS_COMMON', ROOT . '/resources/js/common');
define('CSS_LIBS_ADMIN', CSS_ADMIN . '/libs');
define('CSS_STYLE_ADMIN', CSS_ADMIN . '/styles');
define('JS_LIBS_ADMIN', JS_ADMIN . '/libs');
define('JS_SCRIPT_ADMIN', JS_ADMIN . '/scripts');
define('CSS_LIBS_USER', CSS_USER . '/libs');
define('CSS_STYLE_USER', CSS_USER . '/styles');
define('JS_LIBS_USER', JS_USER . '/libs');
define('JS_SCRIPT_USER', JS_USER . '/scripts');

if(isset($_SERVER['REQUEST_URI']))
   $uri = $_SERVER['REQUEST_URI'];
