<?php

namespace App\Http\Controllers;

use App\Services\BreadcrumbService;

class PolicyController extends Controller
{
    public function index()
    {
        $title = app()->getLocale()== 'ru' ? 'Политика обработки персональных данных' : 'Personal data processing policy';
        $meta = [
            'title' => $title
        ];

        $data = array(
            'asset' => 'policy',
            'meta' => $meta,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [
                    [
                        'name' => $title,
                        'url' => 'policy'
                    ],
                ]
            )
        );

        return view('policy', $data);
    }
}
