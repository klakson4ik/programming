<?php

use vendor\core\libs\Router;

#die(debug($uri));

Router::user('', 'home.index');
Router::user("/news/index", "news");
Router::user("/createPost", "createPost");
