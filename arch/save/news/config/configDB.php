<?php

if(PROD == true)
  define('DB_HOST', 'localhost');
else
  define('DB_HOST', '192.168.0.110');
define('DB_LOGIN', 'maks');
define('DB_PASSWORD', 'Ntktdbpjh55');
define('DB_NAME', 'news_db');
define('CHARSET', 'utf8');

const DB_DSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . CHARSET;

const DB_OPT = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


