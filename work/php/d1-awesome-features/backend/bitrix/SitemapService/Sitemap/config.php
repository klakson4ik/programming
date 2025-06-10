<?php

return [
	'file-max-size' => 10000,
	'iblocks' => [
		'node' => [],
		'catalog_collection' => [],
		'brand' => [],
		'explore_segments' => [],
		'storelocator' => [
			'method' => 'storelocator',
		],
		'catalog_category' => [
			'method' => 'catalogCategory'
		],
		'catalog' => [
			'method' => 'catalog'
		]
	],
	'structure' => [
		'exclude' =>
		[
			'catalog-test', 'dev', 'compare', 'subscribe', 'node', 'explore-segments', 'hub', 'catalog/products/detail', 'catalog/collections/detail', 'storelocator/detail', 'brands'
		],
	],
];
