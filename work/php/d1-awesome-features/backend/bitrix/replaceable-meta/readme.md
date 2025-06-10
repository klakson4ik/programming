# Meta с вставками.

## Описание
Добавить мета информацию, по необходимости в любое поле, в информационный блок(для разделов или элементов):
- Заголовок элемента или секции
- Шаблон META TITLE
- Шаблон META DESCRIPTION
- Шаблон META KEYWORDS

Пример: Купить *{=this.Name}* РЕГИОН - **#REGION#** СРЕДНЯЯ ЦЕНА - **#AVERAGE_PRICE#** ИМЯ **#NAME#**
Вставки обрамляются в символ ***#***

## Пример работы

Данные для преобразования

```php
// Для секций вместо ELEMENT -> SECTION
// в массиве оставляем только нужные поля
$replaceArr = [
	'ELEMENT_META_TITLE' => [
		'REGION' => $region,
		'NAME' => $name,
		'SUM' => $sum
	],
	'ELEMENT_META_DESCRIPTION' => [...],
	'ELEMENT_META_KEYWORDS' => [...],
	'ELEMENT_PAGE_TITLE' => [...]
];

```

Meta под ключ
```php
ReplaceableMeta::set($iblockID, $productID, $replaceArr);
```

Инициализация в одном месте, вызов в другом 
```php
ReplaceableMeta::init($iblockID, $productID, $replaceArr);


ReplaceableMeta::setMeta()

//Так же можно установить каждуе мету по отдельности

ReplaceableMeta::setPageTitle();
ReplaceableMeta::setMetaTitle();
ReplaceableMeta::setMetaDescription();
ReplaceableMeta::setMetaKeywords();

```

Meta получить преобразованные данные
```php
ReplaceableMeta::get($iblockID, $productID, $replaceArr);
```

Также можно получить преобразовные данные из meta секции
```php
ReplaceableMeta::getSection($iblockID, $sectionID, $replaceArr);
```



