<?php

namespace App\Models\Page;

class AboutPage extends StaticModel
{
	protected const PAGE = 'about';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'facts' => self::getFacts(),
			'topSlider' => self::getTopSlider(),
			'popularDestinations' => self::getPopularDestinations(),
			'bigVideo' => self::getBigVideo(),
			'todayData' => self::getTodayData(),
			'qualityControl' => self::getQualityControl(),
			'researchDevelop' => self::getResearchDevelop(),
			'sterilization' => self::getSterilization(),
			'substances' => self::getSubstances(),
			'pagination' => self::getPagination(),

			'main_title' => 'Bellarti — инновации для красоты и здоровья кожи',
			'seo_title' => 'О компании Bellarti',
			'seo_description' => 'Узнайте больше о компании Bellarti — разработчике инновационных инъекционных препаратов для омоложения и глубокого увлажнения кожи',
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


	public static function getTopSlider()
	{
		return [
			'block' => getBlockName('main')
		];
	}

	private static function getFacts()
	{
		$block = getBlockName('facts');
		$link = "https://solopharm.com";

		return [
			'block' => $block,
			'desc' => '
		<h2 class="' . $block . '__title c-purple-dark">Препараты Bellarti</h2>

        <p class="' . $block . '__subtitle c-font-subtitle">производятся фармацевтической компанией Solopharm</p>
        <p class="' . $block . '__descrtiption">Solopharm заботится о&nbsp;людях.
			Компания создает современные, качественные и&nbsp;доступные препараты для&nbsp;сохранения здоровья и&nbsp;качества жизни людей.
			<br><br>
			С 2013 года SOLOPHARM производит препараты в&nbsp;соответствии с&nbsp;международными стандартами GMP&nbsp;и&nbsp;ISO.</p>

        <a href="' . $link . '" class="' . $block . '__link c-black" target="_blank">' . self::getCommonIcon('arrow-45')  . '<span> больше информации на сайте&nbsp;</span>
		<span class="c-purple-dark">solopharm.com</span></a>',
			'video' => self::getVideoByCode('video-na-glavnoy'),
		];
	}

	private static function getPopularDestinations()
	{
		return [
			'block' => getBlockName('popular-destinations'),
			'title' => 'Solopharm производит препараты в наиболее востребованных областях медицины:',
			'background' => self::getImage('background.png'),
			'items' => [
				[
					'text' => 'косметология',
					'icon' => self::getIcon('face'),
				],
				[
					'text' => 'офтальмология',
					'icon' => self::getIcon('eye'),
				],
				[
					'text' => 'ревматология',
					'icon' => self::getIcon('leg'),
				],
				[
					'text' => 'БАД',
					'icon' => self::getIcon('drug'),
				],
				[
					'text' => 'пульмонология',
					'icon' => self::getIcon('lungs'),
				],
				[
					'text' => 'неврология',
					'icon' => self::getIcon('brain'),
				],
				[
					'text' => 'терапия',
					'icon' => self::getIcon('medicine'),
				],
				[
					'text' => 'и другие',
					'icon' => self::getIcon('docs'),
				],
			]
		];
	}

	private static function getBigVideo()
	{
		return [
			'block' => getBlockName('big-video'),
			'video' => self::getVideoByCode('video-na-glavnoy'),
		];
	}

	private static function getTodayData()
	{
		return [
			'block' => getBlockName('more-info'),
			'title' => 'Solopharm сегодня',
			'items' => [
				[
					'number' => '>250',
					'text' => 'регистрационных удостоверений',
				],
				[
					'number' => '>230',
					'text' => 'препаратов в разработке и регистрации',
				],
				[
					'number' => '4',
					'text' => 'производственные площадки',
				],
				[
					'number' => '14',
					'text' => 'стран экспорта',
				],
			],
			'image' => self::getImage('techno.png'),
			'info' => [
				[
					'icon' => self::getIcon('drugs'),
					'text' => 'производство преднаполненных шприцев Bellarti происходит в&nbsp;условиях чистоты класса&nbsp;А',
				],
				[
					'icon' => self::getIcon('tablet'),
					'text' => 'класс чистоты А обеспечивает условия полной стерильности, что позволяет производить чистые и&nbsp;безопасные препараты',
				],
				[
					'icon' => self::getIcon('setting'),
					'text' => 'все производство автоматизировано и&nbsp;не&nbsp;требует присутствия человека',
				],
			]
		];
	}


	private static function getQualityControl()
	{
		return [
			'block' => getBlockName('quality-control'),
			'title' => 'Контроль качества',
			'subtitle' => 'На каждом этапе производства препаратов Bellarti проводится контроль качества по 22 физико-химическим показателям',
			'items' => [
				[
					'number' => '1',
					'text' => 'Входящий<br>контроль',
				],
				[
					'number' => '2',
					'text' => 'Контроль в&nbsp;процессе<br>производства',
				],
				[
					'number' => '3',
					'text' => 'Контроль готовой<br>продукции',
				],
				[
					'number' => '4',
					'text' => 'Карантин 45<br>дней',
				],
			]
		];
	}

	private static function getResearchDevelop()
	{
		$block = getBlockName('research-develop');

		return [
			'block' => $block,
			'desc' =>
			'<h2 class="' . $block . '__content c-purple-dark">Research & Development</h2>

			<p class="' . $block . '__description">Препараты бренда Bellarti разработаны в&nbsp;собственной R&D
            лаборатории Solopharm.

			<br><br>

			В течение двух лет десятки специалистов провели тысячи тестов,
            разработали собственную технологию производства, под&nbsp;которую был
            создан уникальный реактор для&nbsp;производства препаратов на&nbsp;основе
            гиалуроновой кислоты.
        	</p>',
			'video' => self::getVideoByCode('video-na-glavnoy'),
		];
	}

	private static function getSterilization()
	{
		return [
			'block' => getBlockName('sterilization'),
			'title' => 'Технология ASТ и стерилизация паром',
			'desc' => 'Уникальная технология AFT (aseptic filling technology)
			и&nbsp;стерилизация паром позволяют получать устойчивую к&nbsp;механическому и&nbsp;ферментативному разрушению молекулу
			гиалуроновой кислоты весом не менее 2.7 МДа.',
			'img' => self::getResizedImage('smoke.png', [false, '310', false]),
		];
	}

	private static function getSubstances()
	{
		return [
			'block' => getBlockName('substances'),
			'title' => 'В Bellarti используются только наилучшие исходные субстанции',
			'items' => [
				[
					'title' => 'натрия гиалуронат компании HTL',
					'desc' => 'Компания HTL —&nbsp;одно из крупнейших в&nbsp;мире производств гиалуроновой кислоты.
					Она производит любые соединения от самых низко- до
					самых высокомолекулярных, и&nbsp;25 лет гарантирует качество
					субстанций в&nbsp;10 раз чище, чем требования Европейской
					фармакопеи (ЕР).'
				],
				[
					'title' => 'Стерильная вода компании Solopharm',
					'desc' => 'Она используется и&nbsp;в&nbsp;препаратах Bellarti,
					и&nbsp;многими другими российскими производителями лекарственных
					и&nbsp;косметологических средств за высочайшее качество:
					она даже не проводит электрический ток.'
				],
				[
					'title' => 'Все субстанции и&nbsp;компоненты',
					'desc' => 'Все выбирается по принципу максимально
					доказанного качества и&nbsp;проходит жесткий входящий контроль.'
				],
			],
			'img' => self::getResizedImage('bigDot.png', [false, '310', false]),
		];
	}

	private static function getPagination()
	{
		return [
			[
				'caption' => 'Препараты Bellarti',
				'anchor' => getBlockName('facts')
			],
			[
				'caption' => 'Solopharm сегодня',
				'anchor' => getBlockName('more-info')
			],
			[
				'caption' => 'Research & Development',
				'anchor' => getBlockName('research-develop')
			],
			[
				'caption' => 'Технология ASТ<br>и стерилизация паром',
				'anchor' => getBlockName('sterilization')
			],
			[
				'caption' => 'Контроль качества',
				'anchor' => getBlockName('quality-control')
			],
		];
	}
}
