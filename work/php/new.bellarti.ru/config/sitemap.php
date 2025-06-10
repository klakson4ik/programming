<?php
return [
	'file-max-size' => 10000, // Максимальный кол-во записей в одном файле, ~ нет деления на несколько файлов
	'model-settings' => [ // общие настройки для моделей
		'check-active' => true, // ~ Проверять ли на активность
		'field-url' => 'code', // ~ Название поля c Url в БД
	],
	'models' => [ // Список моделей, участвующих в выборке
		'News' => [],
		'Blog' => [
			'start-url' => 'blogs',
			'file-name' => 'blogs'
		],
		'Event' => [
			'start-url' => 'events',
			'file-name' => 'events'
		],
		'Offer' => [
			'start-url' => 'product',
			'method' => 'offer'
		],
		'Cosmetology' => [
			'start-url' => 'cosmetology',
			'method' => 'cosmetology',
		]
	],
	'structure' => [ // генерация файла стуктуры сайта. Удалить , если не нужно генерить
		'method' => 'database',
		'include' => [ // Добавить url
			'feedback'
		],
	],
];
