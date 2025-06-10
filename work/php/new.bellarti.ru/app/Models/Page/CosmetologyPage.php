<?php

namespace App\Models\Page;

use App\Services\Calendar\CalendarFHD;

class CosmetologyPage extends StaticModel
{
	protected const PAGE = 'cosmetology';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'main' => self::getMain(),
			'eco' => self::getEco(),
			'detail' => self::getDetail(),
			'product' => HomePage::getProduct(),
			'protocol' => self::getProtocol(),
			'publications' => ProductPage::getPublications(),
			'example' => self::getExample(),
			'expert' => self::getExpert(),
			'education' => self::getEducation(),
			'pagination' => self::getPagination(),

			
			'main_title' => 'Информация для косметологов от Bellarti',
			'seo_title' => 'Информация для косметологов от экспертов Bellarti',
			'seo_description' => 'Узнайте о качественной экосистеме Bellarti: линейка препаратов, сочетанные протоколы, клинические примеры, публикации, обучение и экспертные рекомендации для косметологов.',
			'seo_keywords' => 'Bellarti',
		];
		self::addBlockInfo($data);
		return $data;
	}

	public static function getTrash()
	{
		return [
			'trash-1' => self::getImage('trash-1.png'),
			'trash-2' => self::getImage('trash-2.png')
		];
	}

	public static function getMain()
	{
		return [
			'block' => getBlockName('main'),
			'title' => 'Косметологам',
			'img' => self::getResizedImage('cosmetology.png', ['1366', '768', false]),
			'btn' => [
				'caption' => 'Стань частью истории',
				'link' => '#b-education'
			]
		];
	}

	public static function getEco()
	{
		return [
			'block' => getBlockName('eco'),
			'title' => 'Bellarti&nbsp;<sup>®</sup> — экосистема<br>косметологических препаратов',
			'desc' => 'Бренд Bellarti&nbsp;<sup>®</sup> предлагает широкий портфель препаратов разной направленности, который закрывает абсолютно любую потребность как врача, так и&nbsp;пациента.',
			'subtitle' => 'Все препараты линейки сочетаются между собой:',
			'img' => self::getImage('cosmetology-bellarti.png'),
			'subtitle' => 'Гиалуроновая кислота:',
			'items' => [
				[
					'icon' => self::getIcon('dayer'),
					'caption' => 'это значительно снижает вероятность нежелательных явлений при&nbsp;сочетанных методиках'
				],
				[
					'icon' => self::getIcon('calendar'),
					'caption' => 'не требует временного промежутка между проведением процедур'
				],
				[
					'icon' => self::getIcon('bacil'),
					'caption' => 'значительно расширяет показания к&nbsp;процедурам'
				],
				[
					'icon' => self::getIcon('face'),
					'caption' => 'обеспечивает более яркий эффект за&nbsp;короткий срок'
				],
			]
		];
	}

	public static function getDetail()
	{
		return [
			'block' => getBlockName('detail'),
			'title' => 'Bellarti<sup>®</sup>. Качество в деталях',
			'items' => [
				[
					'title' => '01. Премиальная гиалуроновая кислота',
					'text' => 'Bellarti&nbsp;<sup>®</sup> производится исключительно из&nbsp;премиальной синтезированной высокомолекулярной стерильной гиалуроновой кислоты HTL (Франция), которая не содержит бактериальных частиц, эндотоксинов и&nbsp;белков'
				],
				[
					'title' => '02. Удобная эргономика шприца',
					'text' => 'Удобство использования шприца, плавность хода поршня и&nbsp;эргономика позволяют проводить процедуру с максимальным комфортом и&nbsp;точностью дозирования препарата'
				],
				[
					'title' => '03. Технология AFT (Aseptic Filling Technology) и&nbsp;стерилизация паром',
					'text' => 'Уникальная технология AFT (aseptic filling technology) и&nbsp;стерилизация паром позволяют получать устойчивую к механическому и&nbsp;ферментативному разрушению молекулу гиалуроновой кислоты весом не менее 2.7 МДа'
				],
				[
					'title' => '04. Ультратонкие иглы',
					'text' => 'Ультратонкие иглы с лазерной заточкой и&nbsp;пониженным сопротивлением помогают минимизировать болевые ощущения и&nbsp;отёчность в&nbsp;местах инъекции после процедуры'
				],
				[
					'title' => '05. Комфортное для дермы рН (6,8-7,6)',
					'text' => 'Процедура комфортна, минимизируется отечность и&nbsp;раздражающее действие на ткани'
				],
				[
					'title' => '06. Прозрачность производства и состава ',
					'text' => 'Производство соответствует стандартам GMP. Мы гарантируем соответствие состава в инструкции и&nbsp;в&nbsp;шприце, что формирует высокий профиль безопасности'
				],
			]
		];
	}

	public static function getProtocol()
	{
		return [
			'block' => getBlockName('protocol'),
			'title' => 'Сочетанные протоколы',
			'bg' => self::getImage('protocol-bg.png'),
			'items' => [
				[
					'title' => 'Мелкоморщинистый морфотип',
					'text' => 'Производство соответствует стандартам GMP. Мы гарантируем соответствие состава в инструкции и в шприце, что формирует высокий профиль безопасности'
				],
				[
					'title' => 'Деформационно-отечный морфотип',
					'text' => 'Производство соответствует стандартам GMP. Мы гарантируем соответствие состава в инструкции и в шприце, что формирует высокий профиль безопасности'
				],
				[
					'title' => 'Усталый морфотип',
					'text' => 'Производство соответствует стандартам GMP. Мы гарантируем соответствие состава в инструкции и в шприце, что формирует высокий профиль безопасности'
				],
				[
					'title' => 'Мускульный морфотип',
					'text' => 'Производство соответствует стандартам GMP. Мы гарантируем соответствие состава в инструкции и в шприце, что формирует высокий профиль безопасности'
				],
			]
		];
	}

	public static function getExample()
	{
		return [
			'block' => getBlockName('example'),
			'title' => 'Клинические примеры',
			'cardData' => [
				'more' => [
					'caption' => 'Читать описание процедуры',
					'icon' => self::getCommonIcon('arrow-45')
				]
			]
		];
	}

	public static function getExpert()
	{
		return [
			'block' => getBlockName('expert'),
			'title' => 'Эксперты Bellarti<sup>®</sup>'
		];
	}

	public static function getEducation()
	{
		return [
			'block' => getBlockName('education'),
			'title' => 'Обучение',
			'selects' => [
				'city' => [
					'selected' => 'Выбрать город',
					'arrow' => self::getIcon('arrow-1')
				],
				'date' => [
					'selected' => CalendarFHD::getCurrentMonthAndYear(),
					'arrow' => self::getIcon('arrow-2'),
					'items' => CalendarFHD::getCloseMonthAndYear()
				]
			],
		];
	}

	private static function getPagination()
	{
		return [
			[
				'caption' => 'Экосистема Bellarti',
				'anchor' => getBlockName('eco')
			],
			[
				'caption' => 'Сочетанные протоколы',
				'anchor' => getBlockName('protocol')
			],
			[
				'caption' => 'Публикации',
				'anchor' => getBlockName('publications')
			],
			[
				'caption' => 'Клинические примеры',
				'anchor' => getBlockName('example')
			],
			[
				'caption' => 'Экперты Bellarti',
				'anchor' => getBlockName('expert')
			],
			[
				'caption' => 'Календарь обучения',
				'anchor' => getBlockName('education')
			],
		];
	}
}
