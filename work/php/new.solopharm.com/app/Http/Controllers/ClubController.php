<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use App\Models\Pages\ClubPage;
use App\Models\Premise;
use App\Services\MetaService;

class ClubController extends Controller
{
    public function index()
    {
        $page = ClubPage::getPage();
        $arrangements = Arrangement::getCached();
        $premises = Premise::getCached();

        $data = [
            'asset' => 'club',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'arrangements' => $arrangements,
            'premises' => $premises
        ];

        return view('club', $data);
    }
}
