<?php

namespace App\Http\Controllers;

use App\Models\Pages\SupplementPage;
use App\Models\SupplementForm;
use App\Services\MetaService;

class SupPlantController extends Controller
{
    public function index()
    {

        $SupPage = SupplementPage::getPage();

        $SupdSys = SupplementForm::getCached();

        $params = array(
            'asset' => 'production',
            'meta' => MetaService::getData($SupPage),
            'pageData' => $SupPage,
            'supdSys' => $SupdSys
        );

        return view('sup-plant-view', $params);
    }
}
