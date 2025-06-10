<?php

namespace App\Http\Controllers;

use App\Models\LegalSite;
use App\Models\Pages\LegalPage;
use App\Services\MetaService;

class LegalController extends Controller
{
    public function index()
    {
        $page = LegalPage::getPage();

        $sites = LegalSite::getItems()->with('legals')->get();

        $data = [
            'asset' => 'legal',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'sites' => $sites
        ];

        return view('legal', $data);
    }
}
