<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Press;
use App\Models\Product;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('query');
        $isEmpty = true;
        if ($search) {
            $product = Product::whereFullText(['title', 'indications', 'scope', 'pharm', 'scope_pharm', 'compound', 'MNN'], $search)->getItems()->get();
            $press = News::whereFullText(['title', 'text'], $search)->getItems()->get();
            $news = Press::whereFullText(['title', 'text'], $search)->getItems()->get();
            if (!$product->isEmpty() || !$press->isEmpty() || !$press->isEmpty()) {
                $isEmpty = false;
            }
        }

        $meta = [
            'title' => __('pages.search') .  __('pages.meta.title'),
        ];

        $data = [
            'asset' => 'search',
            'meta' => $meta,
            'result' => $search ?  [
                $product, $press, $news
            ] : false,
            'isEmpty' => $isEmpty,
            'count' => $search ? ($product->count() + $press->count() + $news->count()) : 0,
            'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                [[
                    'name' => __('pages.search'),
                    'url' => 'search/'
                ]]
            )
        ];

        return view('search', $data);
    }
}
