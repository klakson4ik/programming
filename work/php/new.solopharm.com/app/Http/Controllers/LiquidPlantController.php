<?php

namespace App\Http\Controllers;

use App\Models\Pages\LiquidplantPage;
use App\Services\MetaService;

//use App\Models\SolidplantSystem;

class LiquidPlantController extends Controller
{
    public function index()
    {

        $LiqPage = LiquidplantPage::getPage();

        $params = array(
            'asset' => 'production',
            'meta' => MetaService::getData($LiqPage),
            'pageData' => $LiqPage
        );

        return view('liquid-plant-view', $params);
    }
}
