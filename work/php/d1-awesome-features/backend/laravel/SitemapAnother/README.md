# Модуль генерации sitemap

## Описание модуля
Модуль представляет собой исправленную и модифицированную версию готового sitemap для laravel - [Документация](../Sitemap/readme.md)\
Основные изменения:
- Добавлена возможность разделения сайтмап на несколько файлов.
- Добавлена возможность динамически генерировать url моделей через функции.
- Добавлена возможность указывать условие where, по которому будет произведена выборка элементов модели.
- В качестве параметра `lastmod` можно передать как дату, так и название колонки в базе данных, из которой будет это значение браться.

### Файл конфигурации
Файл содержит настройки, по которым будет генерироваться сайтмап. Можно указать следующие параметры:
- `int fileMaxSize` - максимальное количество записей в одном файле.
- `string domain` - домен сайта.
- `string path` - путь к папке, где хранятся сайтмапы.
- `string timezone` - timezone по умолчанию.
- `string postfix` - постфикс, который применяется ко всем ссылкам в сайтмапе.
- `array staticRoutes` - перечень статичных страниц для сайтмапа, которые указаны в ```routes/web.php```.
- `array modelsSettings` - базовые настройки, применимые ко всем моделям, которые их не переопределяют. Поддерживает следующие ключи:
    - `bool separateFiles` - если установлен `true`, то сайтмап будет разбиваться на несколько файлов
    - `string|bool lastmod` - поле или значение для `lastmod` сайтмапа.
    - `string|bool changefreq` - указывает значение атрибута `changefreq` по умолчанию для сайтмапа.
    - `string|bool priority` - указывает значение атрибута `priority` по умолчанию для сайтмапа.
- `array models` - перечень моделей сайтмапа и их параметров генерации. Каждая модель имеет вид `ModelName => [*PARAMETERS*]` и может принимать следующие параметры:
    - `string|object url` - ссылка на элемент модели. Можно использовать как строку, так и функцию.
    - `array whereCondition` - условие(я) для выборки  элементов модели.
    - `string lastmod` - дата последней модификации элемента. Можно указать как значение, так и название колонки в базе данных.
    - `string|bool changefreq` - частота изменения страницы. Можно указать false, тогда параметр не будет указан в сайтмапе.
    - `string|bool priority` - важность страницы относительно других страниц(от 0.0 до 1.0). Можно указать false, тогда параметр не будет указан в сайтмапе.

### Класс SitemapService
Основной класс генерации сайтмап. Содержит следующие методы:
- `private isSeparate(): bool` - возвращает значение настройки разбиения сайтмапа на несколько файлов.
- `public make()` - генерирует сайтмап
- `private getUrlPrefix(): string` - возвращает полный url с префиксом для локали, если такой имеется
- `private getFullLink(string): array|string|null` - возвращает полную ссылку на страницу. На вход принимает относительную ссылку на страницу.
- `private setTimeZone()` - устанавливает TimeZone по умолчанию указанный в файле конфигурации.
- `private setStatics()` - записывает в массив полные ссылки на статичные страницы, указанные в файле конфигурации.
- `private setModels()` - записывает в массив полные ссылки на выбранные элементы моделей.
- `private prepareDataToWrite()` - подготавливает данные сайтмапов для записи в файлы.
- `private createSitemap()` - вызывает тот или иной метод генерации сайтмап в зависимости от файла конфигурации.
- `private getModelsSiteName(string): string` - генерирует и возвращает название файла модели. На вход получает имя модели
- `private writeSitemapBase(array, string)` - генерирует файл сайтмапа и записывает в него переданные данные. На вход первым параметром передаётся массив данных, вторым - путь к файлу сайтмапа.
- `private writeSitemap(array, string)` - генерирует файл сайтмапа и записывает в него переданные данные. Выполняется только когда есть разбиение на несколько файлов. На вход первым параметром передаётся массив данных, вторым - путь к файлу сайтмапа.

## Примеры использования
### Файл конфигурации
```php
return [
	'fileMaxSize' => 10000,
	'domain' => env('APP_URL'),
	'path' => base_path('public/'),
	'timezone' => 'Europe/Moscow',
	'postfix' => '/',
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
		'separateFiles' => false,
	],
	'models' => [
		'Blog' => [
			'url' => function($elem) {
				return route(
					'blog',
					[$elem['slug']],
					false
				) . '/';
			},
			'whereCondition' => ['active' => true],
			'lastmod' => 'updated_at',
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

```

### Генерация сайтмап через artisan
```
php artisan make:sitemap
```

### Генерация сайтмап кодом
```php
$service = new SitemapService();
$service->make();
```