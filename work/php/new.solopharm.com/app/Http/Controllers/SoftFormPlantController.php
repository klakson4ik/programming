<?php

namespace App\Http\Controllers;

use App\Models\Pages\SoftFormPlantPage;
use App\Services\MetaService;

class SoftFormPlantController extends Controller
{
    public function index()
    {

        $page = SoftFormPlantPage::getPage();

        $params = array(
            'asset' => 'soft-form-plant',
            'meta' => MetaService::getData($page),
            'page' => $page,
        );

        return view('soft-form-plant-view', $params);
    }
}
