<?php

namespace App\Http\Controllers;

use App\Models\News;

use App\Services\BreadcrumbService;
use App\Models\Pages\NewsPage;
use App\Services\MetaService;
use App\Services\SocialShareService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('active', true)->
            where('lang', app()->getLocale())->
            isActualDate()->
            orderBy('date', 'desc')->
            orderBy('sort', 'desc')->
            paginate(24);

        $pressPage = NewsPage::getPage();

        return view('news-view', [
            'asset' => 'press',
            'meta' => MetaService::getData($pressPage),
            'news' => $news,
            'pressPage' => $pressPage,

        ]);
    }

    public function detail(Request $request)
    {
        //Редирект с урлов старого сайта Solopharm
        if (preg_match('/^[a-z0-9]{24}$/', $request->route('title'))) {
            return redirect(app()->getLocale() . '/about/news', 301);
        }
        // end

        $news = News::getItems()->where('url_slug', $request->route('title'))->get();

        $months = array(1 => 'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

        if (count($news) == 0) {
            header("Location: /404");
        } else {
            $meta = [
                'title' => strip_tags($news[0]->title) . ' | ' . __('pages.news.meta.title'),
                'description' => strip_tags($news[0]->title) . '. ' . __('pages.news.meta.desc'),
                'keywords' =>  __('pages.news.meta.keywords'),
                'img' => $news[0]->img,
                'type' => 'article'
            ];

            $shares = app()->getLocale() != 'ru' 
            ? ['wa', 'telegram', 'ln'] 
            : ['vk', 'ok', 'telegram', 'wa'];

            return view('news-detail-view', [
                'asset' => 'press',
                'meta' => $meta,
                'item' => $news[0],
                'months' => $months,
                'socialShare' => SocialShareService::getData($meta, $shares),
                'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                    [
                        [
                            'name' => $news[0]->title,
                            'url' => ""
                        ],
                    ]
                )
            ]);
        }
    }
}
