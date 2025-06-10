<?php

return [
	'fileMaxSize' => 10000, // Максимальный кол-во записей в одном файле
	'domain' => env('APP_URL'),
	'path' => base_path('public/'),
	'timezone' => 'Europe/Moscow', // ~
	'postfix' => '/',	// Постфикс для всех ссылок
	'staticRoutes' => [
		'main',
		'about',
		'brider',
		'partnership',
		'buy',
		'blogs',
		'contacts',
		'policy',
		'catalog-main',
	],
	'modelsSettings' => [
		'separateFiles' => false, //При true будут создаваться отдельные файлы для моделей,
	],
	'models' => [ // Список моделей, участвующих в выборке
		'Blog' => [
			'url' => function($elem) {
				return route(
					'blog',
					[$elem['slug']],
					false
				) . '/';
			},
			'whereCondition' => ['active' => true],
			'lastmod' => 'updated_at',	// Можно установить как код, так и значение. Если существует указанный код, то будет взято значение из базы данных, иначе строка установится как значение
			'changefreq' => false,
			'priority' => false,
		],
		'Pages\\FeedsPage' => [
			'url' => function($elem) {
				return route(
					'catalog-type',
					 [$elem['slug']],
					  false
				) . '/';
			},
			'lastmod' => 'updated_at',
		],
		'FeedsType' => [
			'url' => function($element) {
				$parents = \App\Models\Pages\FeedsPage::active()->get();
				$routes = [];
				foreach($parents as $parent) {
					$routes[] = route(
						'catalog-type-filtered',
						[$parent['slug'], $element['slug']],
						false
					) . '/';
				}
				return $routes;
			},
			'lastmod' => 'updated_at'
		],
		'Feeds' => [
			'url' => function($elem) {
				$type = $elem->type()->first()->slug;
				$pet = $elem->pet()->first()->slug;
				return route(
					'catalog-detail',
					[$pet, $type, $elem['slug']],
					false
				);
			},
			'lastmod' => 'updated_at'
		]
	],
];
