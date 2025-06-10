<?php

namespace App\Http\Controllers;

use App\Models\Pages\TenderPage;
use App\Services\MetaService;

class TenderController extends Controller
{
    public function index()
    {
        $page = TenderPage::getPage();

        $data = [
            'asset' => 'tender',
            'page' => $page,
            'meta' => MetaService::getData($page),
        ];

        return view('tender', $data);
    }
}
