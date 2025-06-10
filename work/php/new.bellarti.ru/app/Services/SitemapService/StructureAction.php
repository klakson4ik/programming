<?php

namespace App\Services\SitemapService;

use App\Models\Menu;

class StructureAction
{
	public static function database(): array
	{
		$data = Menu::getItemsArray(columns: ['code']);
		return array_filter(array_map(fn($val) => $val['code'], $data), fn($item) => !str_contains($item, '#'));
	}
}
