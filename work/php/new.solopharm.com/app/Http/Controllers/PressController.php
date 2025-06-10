<?php

namespace App\Http\Controllers;

use App\Models\Press;
use App\Models\Pages\NewsPage;
use Illuminate\Http\Request;
use App\Services\BreadcrumbService;
use App\Services\SocialShareService;

class PressController extends Controller
{
    public function index()
    {
        $press = Press::where('active', true)->
            where('lang', app()->getLocale())->
            isActualDate()->
            orderBy('date', 'desc')->
            orderBy('sort', 'asc')->
            paginate(10);

        $pressPage = NewsPage::getPage();

        $months = array(1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августя', 'Сентября', 'Октября', 'Ноября', 'Декабря');

        $meta = [
            'title' => $pressPage->seo_title,
            'description' => $pressPage->seo_description,
            'keywords' => $pressPage->seo_keywords,
        ];

        return view('press-view', [
            'asset' => 'press',
            'meta' => $meta,
            'press' => $press,
            'months' => $months,
            'pressPage' => $pressPage,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [
                    [
                        'name' => __('pages.press_title'),
                        'url' => ""
                    ],
                ]
            )
        ]);
    }

    public function detail(Request $request)
    {
        $press = Press::getItems()->where('url_slug', $request->route('title'))->get();

        $months = array(1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августя', 'Сентября', 'Октября', 'Ноября', 'Декабря');

        if (count($press) == 0) {
            header("Location: /404");
        } else {
            $meta = [
                'title' => strip_tags($press[0]->title) . ' | ' . __('pages.press.meta.title'),
                'description' => strip_tags($press[0]->title) . '. ' . __('pages.press.meta.desc'),
                'keywords' =>  __('pages.press.meta.keywords'),
                'img' => $press[0]->img,
                'type' => 'article'
            ];

            $shares = app()->getLocale() != 'ru' 
            ? ['wa', 'telegram', 'ln'] 
            : ['vk', 'ok', 'telegram', 'wa'];

            return view('news-detail-view', [
                'asset' => 'press',
                'meta' => $meta,
                'item' => $press[0],
                'months' => $months,
                'socialShare' => SocialShareService::getData($meta, $shares),
                'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                    [
                        [
                            'name' => __('pages.press_title'),
                            'url' => "about/presses"
                        ],
                        [
                            'name' => $press[0]->title,
                            'url' => ""
                        ],
                    ]
                )
            ]);
        }
    }
}
