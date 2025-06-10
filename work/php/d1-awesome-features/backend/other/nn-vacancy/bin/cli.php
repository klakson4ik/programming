#!/usr/bin/env php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Console\Commands\Vacancy;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new Vacancy());
$application->run();
