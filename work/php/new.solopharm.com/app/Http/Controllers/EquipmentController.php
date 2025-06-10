<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentPreparation;
use App\Models\Pages\EquipmentPage;
use App\Services\MetaService;

class EquipmentController extends Controller
{
    public function index()
    {
        $Equipment = Equipment::getCached();

        $EquipmentP = EquipmentPreparation::getCached();

        $EquipmentPage = EquipmentPage::getPage();

        return view('equipment-view', [
            'asset' => 'production',
            'meta' => MetaService::getData($EquipmentPage),
            'eq' =>  $Equipment,
            'eqP' =>  $EquipmentP,
            'pageData' => $EquipmentPage
        ]);
    }
}
