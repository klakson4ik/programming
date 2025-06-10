<?php

namespace App\Http\Controllers;

use App\Models\Pages\SolidplantPage;
use App\Models\SolidplantSystem;
use App\Services\MetaService;

class SolidPlantController extends Controller
{
    public function index()
    {

        $SolidPage = SolidplantPage::getPage();

        $SolidSys = SolidplantSystem::getCached();

        $params = array(
            'asset' => 'production',
            'meta' => MetaService::getData($SolidPage),
            'pageData' => $SolidPage,
            'sysData' => $SolidSys
        );

        return view('solid-plant-view', $params);
    }
}
