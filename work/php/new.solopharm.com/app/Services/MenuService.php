<?php

namespace App\Services;

use Illuminate\View\View;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuService
{

	public function compose(View $view)
	{
		return $view->with('menuItems', $this->getTree());
	}

	private function buildTree($items)
	{
		$grouped = $items->groupBy('parent_id');

		foreach ($items as $item) {
			if ($grouped->has($item->id)) {
				foreach ($grouped[$item->id] as &$child) {
					$currUrl = $child->url;
					if($item->not_show_childs === 1) {
						$child->url = $item->parent_url . '/' . $currUrl;
					} else {
						$child->url = $item->url . '/' . $currUrl;
					}
					$child->parent_url = $item->parent_url ?? $item->url;
				}
				$item->children = $grouped[$item->id];
			}
		}

		return $items->where('parent_id', null);
	}

	private function getRootParentLink($items, $item) {		
		if($item->parent_id !== 0) {
			$parent = $items->where('id', $item->parent_id)->first();
			return $this->getRootParentLink($items, $parent);
		}
		return $item->url;
	}

	public function getData()
	{
		return Menu::isActive()
			->lang()
			->sort(['parent_id' => 'asc', 'sort' => 'asc'])
			->get();
	}

	public function getTree()
	{
		$key = 'menu-' . app()->getLocale();
		if (Cache::has($key)) {
			return Cache::get($key);
		} else {
			$menu = $this->buildTree($this->getData());
			Cache::put($key, $menu);
			return $menu;
		}
	}

	public function getLinks($lang)
	{
		$menu = [];
		$items = Menu::isActive()->lang($lang)->get()->keyBy('id');

		foreach ($items as $item) {
			$menu[] = [
				'name' => $item->url,
				'url' => $item->parent_id == 0 ? $item->url : ($this->getLink($items, $items[$item->parent_id]) . '/' . $item->url)
			];
		}
		return $menu;
	}

	public function getLink($items, $item)
	{
		return $item->parent_id == 0 ? $item->url : ($this->getLink($items, $items[$item->parent_id]) . '/' . $item->url);
	}
}
