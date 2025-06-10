<?php

namespace App\Http\Controllers;

use App\Models\GallerySite;
use App\Models\Pages\GalleryPage;
use App\Services\BreadcrumbService;
use App\Services\MetaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $page = GalleryPage::getPage();
        $sites = GallerySite::getItems()->where('show_in_sites', 1)->get();

        $data = [
            'asset' => 'gallery',
            'meta' => MetaService::getData($page),
            'page' => $page,
            'sites' => $sites
        ];

        return view('gallery', $data);
    }

    public function show(Request $request)
    {
        $gallery = GallerySite::getItems()->where('link', $request->route('gallery'))->with('galleries')->first();
        if ($gallery) {
            $meta = [
                'title' => strip_tags($gallery->title) . ' | ' . __('pages.gallery.meta.title'),
                'description' => strip_tags($gallery->title) . ' ' . __('pages.gallery.meta.desc'),
                'keywords' =>  __('pages.gallery.meta.keywords'),
            ];

            $data = [
                'asset' => 'gallery',
                'meta' => $meta,
                'gallery' => $gallery,
                'breadcrumbsAdd' => BreadcrumbService::addBreadcrumbs(
                    [[
                        'name' => $gallery->title,
                        'url' => 'about/gallery/' . $gallery->link
                    ]]
                )
            ];
        } else {
            return abort(404);
        }

        return view('gallery-detail', $data);
    }
}
