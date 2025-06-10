<?php

return [
	'useIndexing' => true,						// Использовать индексирование контента
	'maxSearchSize' => 1000,					// Максимальный размер строки для индексирования(Опциональный параметр)
	'minWordRange' => 1,						// Минимальный ранг для участия слова в поиске(Опциональный параметр)
	'maxWordsCount' => 5,						// Максимальное количество слов, участвующих в поиске(Опциональный параметр, сортировка по рангу)
	'modelsNamespace' => 'App\\Models',			// Пространство имён в котором находятся модели
	'useLemmaComparison' => true,				// Использовать сравнение найденных слов с леммой (то есть если по запросу "тереть" найдены слова "турист" и "текст" (Поиск производится по псевдокорню - общей части всех форм введенного слова), то они будут отброшены, поскольку не относятся к изначальному слову)
	'addPartialResults' => true,				// Позволяет добавить к полнотекстовому поиску результаты частичного поиска
	'useCorrectionDictionaries' => true,		// Использовать словари для корректировки написания слов
	'dictionariesPath' => '../resources/dictionaries/',
	'differentsCount' => 1,						// Максимальное число преобразований слова для приведения к корректному виду
	'useFullDictionary' => false,				// Использовать полный словарь или разбить на несколько по буквам
	'fullDictionaryName' => 'words.json',
	'profiles' => [
		'ru' => [
			'ПРЕДЛ' => 0,
			'СОЮЗ' => 0,
			'МЕЖД' => 0,
			'ВВОДН' => 0,
			'ЧАСТ' => 0,
			'МС' => 0,
			'С' => 5,
			'Г' => 5,
			'П' => 3,
			'Н' => 3,
		],
		'en' => [
			'PREP' => 0,
			'CONJ' => 0,
			'INT' => 0,
			'PRCL' => 0,
			'PN' => 0,
			'NOUN' => 5,
			'VERB' => 5,
			'ADJECTIVE' => 3,
			'ADVERB' => 3,
		]
	],
	'levenshteinCosts' => [
		'insert' => 2,
		'replace' => 1,
		'delete' => 2
	],
	'models' => [								// Модели, по которым происходит поиск
		'Feeds' => [
			'fields' => [
				'*'
			],
			'searchFields' => [
				'name',
				'description',
				'structure',
				'indicators'
			],
			'fulltextSearchFields' => [
				'testing',
				'color',
				'slug'
			]
		],
		'Blog' => [
			'fields' => [
				'name',
				'slug',
				'text',
				'bg_color',
				'blog_date'
			],
			'searchFields' => [
				'name',
				'text'
			]
		],
	],

];