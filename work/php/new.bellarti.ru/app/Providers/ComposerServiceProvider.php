<?php

namespace App\Providers;

use App\Services\BreadcrumbService;
use App\Services\FooterService;
use Illuminate\Support\ServiceProvider;
use App\Services\HeaderService;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('common.header', HeaderService::class);
        view()->composer('common.footer', FooterService::class);
		view()->composer('common.breadcrumbs', BreadcrumbService::class);
    }
}
