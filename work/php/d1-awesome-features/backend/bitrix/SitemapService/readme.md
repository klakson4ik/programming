# Sitemap.

## Описание
Генерация sitemap с возможностью кастомизации

## Инструкция
Скопировать каталог Sitemap в local/lib/Services, CLI/Sitemap в local/lib/CLI и заполнить конфиг .config.php

## Конфиг

```php
// * обязательное
// ~ по умолчанию, можно не указывать
return [
	'file-max-size' => 10000, // Максимальный кол-во записей в одном файле, ~ нет деления на несколько файлов
	'domain' => 'https://' . SITE_SERVER_NAME, // ~
	'path' => $_SERVER['DOCUMENT_ROOT'] . '/', // ~
	'timezone' => 'Europe/Moscow' // ~
	'iblocks' => [ // Список инфоблоков участующих в генерации
		'node' => [], // * ключ - символьный код инфоблока
		'catalog_collection' => [],
		'brand' => [],
		'explore_segments' => [
			'changefreq' => 'weekly' // ~
			'lastmod' => date('c', time()) // ~
			'priority' => '0.5', // ~
			'file-name' => 'test' // Название файла, ~ ключ
		],
		'storelocator' => [
			'method' => 'storelocator', // Название метода, если нужно кастомизировать стандартное состовление url 
		],
		'catalog' => [
			'method' => 'catalog'
		]
	],
	'structure' => [ // генерация файла стуктуры сайта. Удалить , если не нужно генерить
		'exclude' => // Исключение директорий
		[
			'catalog-test', 'dev', 'compare', 'subscribe', 'node', 'explore-segments', 'hub', 'catalog/products/detail', 'catalog/collections/detail', 'storelocator/detail', 'brands'
		],
		'include' => [ // Добавить url
			'compare/detail', 'node/test/view'
		],
		'changefreq' => 'weekly' // ~
		'lastmod' => date('c', time()) // ~
		'priority' => '0.7', // ~
		'file-name' => 'test' // Название файла, ~ structure
	],
];

Пример: 
return [
	'iblocks' => [ 
		'node' => [], 
		'catalog_collection' => [],
		'brand' => [],
		'explore_segments' => [],
		'storelocator' => [
			'method' => 'storelocator', 
		],
	],
	'structure' => [ 
		'exclude' => 
		[
			'catalog-test', 'dev', 'compare', 'subscribe', 'node', 'explore-segments', 'hub', 'catalog/products/detail', 'catalog/collections/detail', 'storelocator/detail', 'brands'
		],
	],
];
```

Кастомный метод: добавить в  файл LocAction.php новый метод с соотвествующим названием в конфиге пример:
```php
/**
 *  @param array $fields массив полей из инфоблока
 * 	@param array $props  свойств из инфоблока
 *  @return string url
 **/

public static function storelocator(array $fields, array $props): string
	{
		$arParams = array("replace_space" => "-", "replace_other" => "-");
		$region = CUtil::translit($props['region']['VALUE'], "ru", $arParams);
		$city = CUtil::translit($props['city']['VALUE'], "ru", $arParams);
		return '/' . $fields['IBLOCK_CODE'] . '/' . $region . '/' . $city . '/' . $fields['CODE'] . '/';
	}
```