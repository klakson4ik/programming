<?php

namespace App\Http\Controllers;

use App\Models\Pages\TechnologyPage;
use App\Models\Technology;
use App\Models\Trade;
use App\Services\MetaService;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    public function index(Request $request)
    {
        $page = TechnologyPage::getPage();
        $technologies = Technology::getCached();
        $technology = $technologies[0];
        $trades = Trade::where('technology_id', $technology->id)->with('product')->get()->unique('product_id');

        $data = [
            'asset' => 'technology',
            'page' => $page,
            'meta' => MetaService::getData($page),
            'technologies' => $technologies,
            'content' => $technology,
            'trades' => $trades
        ];

        return view('technology', $data);
    }

    public function getData(Request $request)
    {
        $page = TechnologyPage::getPage();
        $technology = Technology::find($request->route('id'));
        $trades = Trade::where('technology_id', $technology->id)->with('product')->get()->unique('product_id');

        return [
            'content' => view('partials.technology.content', ['content' => $technology])->render(),
            'trades' => view('partials.technology.trades', ['trades' => $trades, 'title' => $page->subtitle])->render(),
        ];
    }
}
