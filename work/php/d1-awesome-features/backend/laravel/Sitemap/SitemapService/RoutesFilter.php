<?php

namespace App\Services\SitemapService;

use Illuminate\Support\Facades\Route;

class RoutesFilter
{
	private static array $exclude = ['admin', 'laravel', 'moonshine', 'upload', 'laravel-filemanager', 'storage', 'api', '404'];

	public static function get(array $excludes): array
	{
		$excludes = array_merge(self::$exclude, $excludes);
		$result = [];
		$routeCollection = Route::getRoutes();
		foreach ($routeCollection as $value) {
			$isExclude = false;
			foreach ($excludes as $exclude) {
				if (preg_match('/[^\d\w\.-\/]/', $value->uri())) {
					$isExclude = true;
					break;
				}
				if (preg_match('/\b(?<!-)' . str_replace('/', '\/', $exclude) . '(?!-)\b/', $value->uri())) {
					$isExclude = true;
					break;
				}
			}
			if (!$isExclude) {
				$result[] = $value->uri();
			}
		}

		unset($result[array_search('/', $result)]);

		return array_unique($result);
	}
}
