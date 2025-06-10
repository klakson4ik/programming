<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Country;
use App\Models\Pages\CerfificatePage;
use App\Models\Pages\ContractualPage;
use App\Models\Pages\MarketPage;
use App\Services\BreadcrumbService;
use App\Services\MetaService;

class PartnersController extends Controller
{
    public function markets()
    {
        $pageData = MarketPage::getPage();
        $countries = Country::getCached();

        return view('markets', [
            'asset' => 'partners',
            'meta' => MetaService::getData($pageData),
            'header' => $pageData->title,
            'data' => [
                'content' => $pageData->block_1_text,
                'statistics' => $pageData->block_1_data,
            ],
            'partnersData' => [
                'title' => $pageData->block_2_title,
                'content' => $pageData->block_2_desc,
                'image' => '/storage/' . $pageData->block_2_img,
                'email' => [
                    'text' => $pageData->block_2_btn,
                    'address' => 'mailto:' . $pageData->block_2_action,
                ],
            ],
            'countries' => $countries
        ]);
    }

    public function certificates()
    {
        $pageData = CerfificatePage::getPage();
        $certificates = Certificate::getItems()
            ->paginate(10);

        $meta = [
            'title' => $pageData->seo_title,
            'description' => $pageData->seo_description,
            'keywords' => $pageData->seo_keywords,
        ];

        return view('certificates', [
            'asset' => 'partners',
            'meta' => $meta,
            'header' => $pageData->title,
            'data' => [
                'content' => $pageData->desc,
                'statistics' => $pageData->data,
            ],
            'certificates' => $certificates->items(),
        ]);
    }

    public function contractual()
    {
        $pageData = ContractualPage::getPage();

        $meta = [
            'title' => $pageData->seo_title,
            'description' => $pageData->seo_description,
            'keywords' => $pageData->seo_keywords,
        ];

        return view('contractual', [
            'asset' => 'partners',
            'meta' => $meta,
            'header' => $pageData->title,
            'desc' => $pageData->desc,
            'img' => '/storage/' . $pageData->img,
            'block1' => [
                'mod' => ['image', 'large-stat'],
                'header' => $pageData->block_1_title,
                'image' => '/storage/' . $pageData->block_1_img,
                'statistics' => [
                    'items' => $pageData->block_1_data,
                    'mod' => ['tree-row', 'line-top'],
                ],
            ],
            'block2' => [
                'mod' => 'horizontal',
                'header' => $pageData->block_2_title,
                'data' => [
                    'content' => $pageData->block_2_desc,
                    'image' => '/storage/' . $pageData->block_2_img
                ],
                'statistics' => [
                    'items' => $pageData->block_2_data,
                    'mod' => 'horizontal',
                ],
            ],
            'block3' => [
                'mod' => 'horizontal',
                'header' => $pageData->block_3_title,
                'data' => [
                    'content' => $pageData->block_3_desc,
                    'image' => '/storage/' . $pageData->block_3_img
                ],
                'statistics' => [
                    'items' => $pageData->block_3_data,
                    'mod' => 'horizontal',
                ],
            ],
            'block4' => [
                'mod' => 'horizontal',
                'header' => $pageData->block_4_title,
                'data' => [
                    'content' => $pageData->block_4_desc,
                    'image' => '/storage/' . $pageData->block_4_img
                ],
                'links' => [
                    [
                        'text' => $pageData->btn_2,
                        'url' => '/storage/' . $pageData->action_2,
                    ]
                ]
            ],
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [[
                    'name' => __('pages.breadcrumbs.contractual'),
                    'url' => '/'
                ]]
            )
        ]);


    }
}
