<?php

namespace App\Http\Controllers;

use App\Models\Pages\SitesPage;
use App\Models\Site;
use App\Services\MetaService;

class SitesController extends Controller
{
    public function index()
    {
        $page = SitesPage::getPage();

        $sites = Site::getCached();

        $data = [
            'asset' => 'sites',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'sites' => $sites
        ];

        return view('sites', $data);
    }
}
