<?php

namespace App\Http\Controllers;

use App\Models\Pages\RndPage;
use App\Services\MetaService;

class RndController extends Controller
{
    public function index()
    {

        $RndPage = RndPage::getPage();

        return view('rnd-view', [
            'asset' => 'production',
            'meta' => MetaService::getData($RndPage),
            'pageData' => $RndPage
        ]);
    }
}
