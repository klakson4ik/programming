<?php

namespace App\Http\Controllers;

use App\Models\Labdirection;
use App\Models\Pages\LabinternshipPage;
use App\Services\BreadcrumbService;
use App\Services\MetaService;

class LabInternshipController extends Controller
{
    public function index()
    {
        $page = LabinternshipPage::getPage();
        $laboratories = Labdirection::getCached();

        $data = [
            'asset' => 'internship-laboratory',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'laboratories' => $laboratories,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [
                    [
                        'name' => $page->block_1_title,
                        'url' => 'career/internship/laboratory/'
                    ],
                ]
            )
        ];

        return view('internship-laboratory', $data);
    }
}
