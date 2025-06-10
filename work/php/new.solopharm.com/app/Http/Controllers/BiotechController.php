<?php

namespace App\Http\Controllers;

use App\Models\BiotechEquipment;
use App\Models\Pages\BiotechPage;
use App\Services\MetaService;

class BiotechController extends Controller
{
    public function index()
    {
        $BioEquipment = BiotechEquipment::getCached();
        $BioPage = BiotechPage::getPage();

        return view('biotech-view', [
            'asset' => 'production',
            'meta' => MetaService::getData($BioPage),
            'eq' => $BioEquipment,
            'pageData' => $BioPage
        ]);
    }
}
