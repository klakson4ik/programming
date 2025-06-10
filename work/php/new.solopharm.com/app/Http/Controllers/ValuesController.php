<?php

namespace App\Http\Controllers;

use App\Models\Chronology;
use App\Models\Achievement;
use App\Models\Country;
use App\Models\Today;
use App\Models\Pages\ValuePage;
use App\Services\BreadcrumbService;
use App\Services\MetaService;

class ValuesController extends Controller
{
    public function index()
    {

        $valuePage = ValuePage::getPage();
        $valuePage->videoFile = true;

        $chronology = Chronology::getCached();

        $achievement1 = Achievement::getItems()->where('page', 1)->get();

        $achievement2 = Achievement::getItems()->where('page', 2)->get();

        $country = Country::getItems()->where('page', 1)->get();

        $today = Today::getCached();

        return view('values-view', [
            'asset' => 'production',
            'meta' => MetaService::getData($valuePage),
            'pageData' => $valuePage,
            'chronology' => $chronology,
            'achievement' => $achievement1,
            'progress' => $achievement2,
            'country' => $country,
            'today' => $today,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [[
                    'name' => __('pages.breadcrumbs.values'),
                    'url' => '/'
                ]]
            )
        ]);
    }
}
