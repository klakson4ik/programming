<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\EnvEnvironmentStorage;

class FrontendServiceProvider extends ServiceProvider
{

    public $menuItems;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!defined('APP_PATH')) {
            define('APP_PATH', realpath(__DIR__ . '/../..') . '/');
            define('FRONTEND_PATH', APP_PATH . 'frontend');
        }

        $env = new \Techart\Frontend\Environment(new EnvEnvironmentStorage());
        $pathResolver = new \Techart\Frontend\PathResolver(FRONTEND_PATH, ['bladeCachePath' => APP_PATH . 'cache/blade']);
        $frontend = new \Techart\Frontend\Frontend($env, $pathResolver);
        $assets = $frontend->assets();
        $templates = $frontend->templates();

        View::share('env', $env);
        View::share('pathResolver', $pathResolver);
        View::share('frontend', $frontend);
        View::share('assets', $assets);
        View::share('templates', $templates);
    }
}
