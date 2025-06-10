<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Pages\FormPage;
use App\Services\MetaService;

class ReleaseController extends Controller
{
    public function index()
    {
        $page = FormPage::getPage();
        $forms = Form::getCached();

        $data = [
            'asset' => 'release',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'forms' => $forms,
        ];

        return view('release', $data);
    }
}
