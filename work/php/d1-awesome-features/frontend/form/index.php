<?php

$fields = [
	'file' => [
		'field' => 'input-file',
		'name' => 'doc',
		'label' => 'Выберите',
		'required' => true,
		// 'multiple' => true, 
		// 'disabled' => true,
		'accept' => ['.png', '.jpg', '.webp'],
		// 'mods' => ['preview'],  preview - список файлов с педпросмотром, режим для изображений
		// 'props' => [
		// 	'max-file-size' => 0.5, // Максимальный размер файла в Mb
		// ]
	],
	'gender' => [
		'field' => 'checkbox-group',
		'name' => 'gender',
		'label' => 'Пол',
		// 'disabled' => true,
		'required' => true,
		'checkbox_mods' => ['check-mark'], // ['check-mark', 'fill', 'label-left'] по умолчанию cтандартный
		'items' => [
			[
				'value' => 'M',
				'label' => 'Мужской',
				// 'checked' => true
			],
			[
				'value' => 'W',
				'label' => 'Женский'
				// 'checked' => true
			],
			[
				'value' => 'S',
				'label' => 'средний'
				// 'checked' => true
			]
		]
	],
	'gender' => [
		'field' => 'radio-group',
		'name' => 'gender',
		'label' => 'Пол',
		'required' => true,
		// 'disabled' => true,
		'radio_mods' => ['fill'],
		'items' => [
			[
				'value' => 'M',
				'label' => 'Мужской',
				// 'checked' => true
			],
			[
				'value' => 'W',
				'label' => 'Женский'
			],
			[
				'value' => 'S',
				'label' => 'средний'
			]
		]
	],
	'gender' => [
		'field' => 'checkbox',
		'name' => 'gender',
		'label' => 'Пол',
		// 'checked' => true,
		'required' => true,
		// 'disabled' => true,
		'mods' => ['check-mark', 'label-left'] // ['check-mark', 'fill', 'label-left'] по умолчанию cтандартный
	],
	'test' => [
		'field' => 'select',
		'name' => 'geo',
		// 'label' => 'ФИО',
		'placeholder' => 'Начните вводить',
		// 'id' => 'geo',
		'required' => true,
		'event' => 'test', // название события в данном примере - on-select-test, которые выбрасывается в js
		// 'disabled' => true

		'items' => [
			[
				'caption' => 'text1',
				'value' => 1,
			],
			[
				'caption' => 'text2',
				'value' => 2,
				// 'selected' => true
				// 'disabled' => true
			],
			[
				'caption' => 'text3',
				'value' => 3
			],
		],
		// 'props' => [
		// 	'other-click-close' => false, // Отключить закрытие всех select, кроме текущего
		// 	'outside-click-close' => false, // Отключить закрытие всех select при  нажатии на область вне select
		// ]
	],
	'name' => [
		'field' => 'input',
		'name' => 'fio',
		'label' => 'ФИО',
		'placeholder' => 'Начните вводить',
		// 'id' => 'fio',
		'required' => true,
		// 'disabled' => true,
		'pattern' => '^\w{2,}'
	],
	'email' => [
		'field' => 'input',
		'name' => 'email',
		'type' => 'email',
		'label' => 'Email',
		'placeholder' => 'Начните вводить',
		// 'id' => 'email',
		'required' => true,
		// 'disabled' => true,
		'pattern' => '^[A-Za-z0-9_.-]+@[A-Za-z0-9_.-]+\.[A-Za-z0-9_.-]+'
	],
	'phone' => [
		'field' => 'input',
		'name' => 'phone',
		'type' => 'tel',
		'label' => 'Phone',
		'placeholder' => 'Начните вводить',
		'id' => 'phone',
		'required' => true,
		// 'disabled' => true,
		'props' => [
			// 'mask-sign' => '#', // Знак маски
			// 'mask-plus' => false, // Отключить плюс вначале
			// 'mask-disable' => true // Отключить маску
			// 'mask-allow-codes' => '1,20', // Ограничить коды стран
			// 'mask-disallow-codes' => '1' // Запретить коды стран
			// 'mask-ru' => true, // Включить , если используется только Российские номера, экономия ресурсов
			// 'mask-save' => 'raw-with-plus' // ['full', 'full-without-plus', 'raw'] Сохранение результата: full - значение как написано, full-without-plus - значение как написано, без плюса, raw - одни цифры, по умолчанию одни цифры  с плюсом  
			// 'mask-no-validate' => true // Не проводить валидацию поля
		]
	],
	'gcaptcha' => [ // Google Captcha
		'field' => 'gcaptcha',
		'publicKey' => '' // publicKey капчи
	],
	'ycaptcha' => [ // Yandex Captcha
		'field' => 'ycaptcha',
		'publicKey' => '' // publicKey капчи
	],
];
