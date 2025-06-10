<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MenuService;
use App\Services\LocaleService;
use App\Services\InfoService;
use App\Services\BreadcrumbService;

class ComposerServiceProvider extends ServiceProvider
{
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
        if(app()->getLocale() == 'ru') {
            view()->composer('layouts.main-page', function($view) {
                $view->with([
                    'popupData' => [
                        'markIcon' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/popup/mark.svg'),
                        'crossIcon' => file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/images/popup/cross.svg'),
                        'link' => '/about/news/issledovanie-po-leceniiu-raka-molocnoi-zelezy'
                    ],
                ]);
            });
        }
        view()->composer('layouts.includes.header', MenuService::class);
        view()->composer('layouts.includes.header', LocaleService::class);
        view()->composer('layouts.includes.breadcrumbs', BreadcrumbService::class);
        view()->composer(['layouts.includes.footer', 'layouts.includes.header'], InfoService::class);
    }
}
