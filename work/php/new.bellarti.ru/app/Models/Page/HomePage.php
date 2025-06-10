<?php

namespace App\Models\Page;

class HomePage extends StaticModel
{
	protected const PAGE = 'home';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'main' => self::getMain(),
			'injection' => self::getInjection(),
			'magic' => self::getMagic(),
			'standard' => self::getStandard(),
			'product' => self::getProduct(),

			'main_title' => 'Инъекционные препараты Bellarti',
			'seo_title' => 'Bellarti — инъекционные препараты для биоревитализации и омоложения кожи',
			'seo_description' => 'Bellarti — филлеры и препараты для биоревитализации на основе высокомолекулярной гиалуроновой кислоты. Сертифицировано в соответствии с международным стандартом GMP',
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
			'block' => getBlockName('main')
		];
	}

	public static function getInjection()
	{
		return [
			'block' => getBlockName('injection'),
			'title' => 'Инъекционные препараты Bellarti<sup>®</sup>',
			'desc' => 'Биоревитализация препаратами Bellarti&nbsp;<sup>®</sup> на&nbsp;основе высокомолекулярной гиалуроновой кислоты с&nbsp;пролонгированным действием обеспечивает глубокое и&nbsp;длительное увлажнение кожи и&nbsp;помогает сохранить ее молодость и&nbsp;естественную красоту.<br><br>Гиалуроновая кислота –&nbsp;основной компонент молодости и&nbsp;сияния нашей кожи. Она восполняет дефицит влаги на&nbsp;всех уровнях, запускает процессы регенерации, выработки коллагена и&nbsp;эластина, придает коже гладкость и&nbsp;сияние.',
			'img' => self::getResizedImage('injection.png', [false, false, false]),
			'subtitle' => 'Гиалуроновая кислота:',
			'items' => [
				[
					'icon' => self::getIcon('drop'),
					'caption' => 'глубоко увлажняет кожу'
				],
				[
					'icon' => self::getIcon('skin'),
					'caption' => 'сохраняет молодость кожи'
				],
				[
					'icon' => self::getIcon('lay'),
					'caption' => 'выравнивает рельеф'
				],
				[
					'icon' => self::getIcon('elastic'),
					'caption' => 'придает упругость'
				],
			]
		];
	}

	public static function getMagic()
	{
		return [
			'block' => getBlockName('magic'),
			'title' => 'Магия Bellarti<sup>®</sup>',
			'bg' => self::getImage('magic-bg.png'),
			'items' => [
				[
					'icon' => self::getIcon('lily'),
					'text' => 'Минимизация болевых ощущений и&nbsp;отёчности после процедуры'
				],
				[
					'icon' => self::getIcon('injector'),
					'text' => 'Короткий период восстановления после инъекции'
				],
				[
					'icon' => self::getIcon('clock'),
					'text' => 'Пролонгированный косметический эффект'
				],
			]
		];
	}

	public static function getStandard()
	{
		return [
			'block' => getBlockName('standard'),
			'title' => 'Международный фармацевтический стандарт',
			'desc' => 'Bellarti&nbsp;<sup>®</sup>  —&nbsp;российский бренд, имеющий в&nbsp;своем ассортименте продукты разной направленности, которые можно сочетать между собой в&nbsp;рамках одной процедуры.<br><br>Инъекционная линейка препаратов Bellarti&nbsp;<sup>®</sup> разработана в&nbsp;R&D лабораториях фармацевтической компании Solopharm, имеющей европейскую сертификацию GMP. Розлив препаратов происходит в&nbsp;чистых помещениях на современном немецком оборудовании. Взаимодействие с&nbsp;экспертами в области эстетической медицины позволяет изо дня в&nbsp;день совершенствовать препараты и&nbsp;создавать новые горизонты развития линейки Bellarti&nbsp;<sup>®</sup>.',
			'video' => self::getVideoByCode('mezdunarodnyi-farmacevticeskii-standart'),
		];
	}

	public static function getProduct(string $title = 'Линейка Bellarti<sup>®</sup>', string $block = 'product')
	{
		return [
			'block' => getBlockName($block),
			'title' => $title,
			'cardData' => [
				'more' => [
					'caption' => 'Подробнее',
					'icon' => self::getCommonIcon('arrow-more')
				]
			]
		];
	}
}
