<?php

namespace App\Models\Page;

class ContactsPage extends StaticModel
{
	protected const PAGE = 'contacts';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'topInfo' => self::getTopInfo(),
			'production' => self::getProduction(),
			'mainOffice' => self::getMainOffice(),
			'partners' => self::getPartners(),
			'representatives' => self::getRepresentatives(),
			'ymap' => self::getYmap(),
			'pagination' => self::getPagination(),

			'main_title' => 'Контакты',
			'seo_title' => 'Контакты Bellarti',
			'seo_description' => 'Контактная информация Bellarti: адреса, телефоны и электронная почта для связи с представителями компании',
			'seo_keywords' => 'Bellarti',
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getTrash()
	{
		return [
			'trash-1' => self::getImage('trash-1.png'),
			'trash-2' => self::getImage('trash-2.png'),
		];
	}

	public static function getTopInfo()
	{
		return [
			'block' => getBlockName('top-info'),
			'title' => 'Контакты',
			'bg' => self::getImage('top-bg.png'),
		];
	}

	private static function getProduction()
	{
		return [
			'block' => getBlockName('production'),
			'title' => 'Производство и&nbsp;офис',
			'production' => 'Производство',
			'geo1' => 'г. Санкт-Петербург, Индустриальный пр., дом 71, корпус 2, литера А',
			'office' => 'Офис',
			'geo2' =>  'г. Санкт-Петербург, Львовская улица, дом 27 «БЦ Office L27»',
			'text' => 'По всем вопросам пишите нам на&nbsp;электронную почту',
			'email' => 'info@bellarti.ru',
			'img' => self::getImage('lineika-bellarti.png'),
		];
	}

	private static function getMainOffice()
	{
		return [
			'block' => getBlockName('main-office'),
			'title' => 'Центральный офис',
			'items' => [
				[
					'name' => 'Илья Платонов',
					'post' => 'Директор по&nbsp;продвижению',
					'number' => '+7 (911) 712-28-38',
					'email' => 'ilya.platonov@grotexmed.com'
				],

				[
					'name' => 'Виктория Гурьянова',
					'post' => 'Заместитель директора по&nbsp;продвижению',
					'number' => '+7 (919) 997-14-11',
					'email' => 'viktoriya.guryanova@grotexmed.com'
				],

				[
					'name' => 'Эльмира Казьмина',
					'post' => 'Национальный менеджер',
					'number' => '+7 (921) 340-29-95',
					'email' => 'elmira.kazmina@grotexmed.com'
				],

				[
					'name' => 'Анастасия Щуко',
					'post' => 'Специалист по&nbsp;продукту',
					'number' => '+7 (812) 385-47-87',
					'addNumber' => 'доб. 429',
					'email' => 'anastasiya.bykovich@grotexmed.com'
				],

				[
					'name' => 'Сообщить о нежелательном явлении',
					'post' => '«Горячая линия»',
					'number' => '+7 (800) 700-04-73,',
					'addNumber' => 'клавиша 1',
					'email' => 'safety@grotexmed.com'
				],
			],
		];
	}

	private static function getPartners()
	{
		return [
			'block' => getBlockName('partners'),
			'title' => 'Партнеры',
		];
	}

	private static function getRepresentatives()
	{
		return [
			'block' => getBlockName('representatives'),
			'title' => 'Региональные представители',
			'region' => 'Регион',
			'selects' => [
				'info' => [
					'selected' => 'Выбрать регион',
					'arrow' => self::getIcon('arrow-1')
				],
			],
		];
	}

	public static function getYmap(string $title = 'Где купить')
	{
		return [
			'block' => getBlockName('ymap'),
			'title' => $title,
			'selects' => [
				'city' => [
					'selected' => 'Выбрать город',
					'arrow' => self::getIcon('arrow-1')
				],
			],
			'ymapKey' => env('YMAP_KEY', false)
		];
	}

	private static function getPagination()
	{
		return [
			[
				'caption' => 'Производство и офис',
				'anchor' => getBlockName('production')
			],
			[
				'caption' => 'Центральный офис',
				'anchor' => getBlockName('main-office')
			],
			[
				'caption' => 'Региональные представители',
				'anchor' => getBlockName('representatives')
			],
			[
				'caption' => 'Где купить',
				'anchor' => getBlockName('ymap')
			],
			[
				'caption' => 'Партнеры',
				'anchor' => getBlockName('partners')
			],
		];
	}
}
