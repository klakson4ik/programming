<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
	public function getFullData()
	{
		return Menu::isActive()
			->sort(['parent_id' => 'asc', 'sort' => 'asc'])->get();
	}

	public static function getTopTree()
	{
		$menuService = new MenuService();
		$items = Menu::isActive()
			->sort(['parent_id' => 'asc', 'sort' => 'asc'])->where('show_top', true)->get();
		return $menuService->buildTree($items)->toArray();
	}

	public static function getBottomTree()
	{
		$menuService = new MenuService();

		$items = Menu::isActive()
			->sort(['parent_id' => 'asc', 'sort' => 'asc'])->where('show_bottom', true)->get();
		return $menuService->buildTree($items)->toArray();
	}

	private function buildTree($items)
	{
		$grouped = $items->groupBy('parent_id');

		foreach ($items as $item) {
			if ($grouped->has($item->id)) {
				foreach ($grouped[$item->id] as &$child) {
					$currUrl = $child->url;
					$child->url = $item->url . '/' . $currUrl;
				}
				$item->children = $grouped[$item->id];
			}
		}

		return $items->where('parent_id', null);
	}
}
