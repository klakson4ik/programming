# Sitemap.

## Описание
Генерация sitemap с возможностью кастомизации

## Инструкция
Скопировать каталог SitemapService в app/Services, Commands/Sitemap.php в app/Console/Commands и создать конфиг /config/sitemap.php

## Запуск
php artisan make:sitemap

## Конфиг

```php
// * обязательное
// ~ по умолчанию, можно не указывать
return [
	'file-max-size' => 10000, // Максимальный кол-во записей в одном файле, ~ нет деления на несколько файлов
	'domain' => Env::get('APP_URL'), // ~
	'path' => APP_PATH . '/public', // ~
	'timezone' => 'Europe/Moscow' // ~
	'model-settings' => [ // общие настройки для моделей
		'check-active' => false, // ~ Проверять ли на активность 
		'field-active' => 'active', // ~ Название поля активности в БД
		'field-url' => 'url' // ~ Название поля c Url в БД
	],
	'models' => [ // Список моделей, участвующих в выборке
		'News' => [ // Название модели
			'start-url' => 'about/news', // Начало Url
			'check-active' => false, // ~ Проверять ли на активность конкретной модели
			'field-active' => 'active', // ~ Название поля активности в БД конкретной модели
			'field-url' => 'url' // ~ Название поля c Url в БД конкретной модели
			'changefreq' => 'weekly' // ~
			'lastmod' => date('c', time()) // ~
			'priority' => '0.5', // ~
			'file-name' => 'test' // Название файла, ~ ключ
		],
		'Press' => [
			'start-url' => 'about/press',
			'method' => 'press' // кастомный метод в LocAction.php
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
	'model-settings' => [
		'check-active' => true,
		'field-active' => 'active',
		'field-url' => 'url_slug'
	],
	'models' => [
		'News' => [
			'start-url' => 'about/news',
		],
		'Press' => [
			'start-url' => 'about/press',
		]
	],
	'structure' => [],
];

```

Кастомный метод: добавить в  файл LocAction.php новый метод с соотвествующим названием в конфиге пример:
```php
/**
 *  @param array $element массив полей из модели
 *  @return string url
 **/

public static function press(mixed $element): string
	{
		return '/press/test' . $element->url_slug;
	}
```