<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class BreadcrumbService
{
    private $breadcrumbs = [];

    public function compose(View $view)
    {
        $tree = new MenuService();
        $this->generateBreadcrumbs($tree->getData());

        return $view->with('breadcrumbs', $this->breadcrumbs);
    }

    private function generateBreadcrumbs($tree)
    {
        $urlArray = explode('/', Request::path());
        $elements = $tree->whereIn('url', $urlArray)->all();
        if ($elements) {
            $parentId = 0;
            $urlStr = '';
            foreach ($elements as $el) {
                if ($parentId == $el->parent_id) {
                    $urlStr .= '/' . $el->url;
                    $this->breadcrumbs[] = [
                        'name' => $el->name,
                        'url' => $urlStr
                    ];
                    $parentId = $el->id;
                }
            }
        }
    }

    public static function addBreadcrumbs($array){
        $urlStr = '';
        $result = [];
        foreach($array as $el){
            $urlStr .= '/' . $el['url'];
            $result[] = [
                'name' => $el['name'],
                'url' => $urlStr
            ];
        }
        return $result;
    }
}
