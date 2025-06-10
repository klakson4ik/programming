<?php

namespace App\Models\Page;

class PatientPage extends StaticModel
{
	protected const PAGE = 'patient';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'main' => self::getMain(),
			'bio' => self::getBio(),
			'injection' => HomePage::getInjection(),
			'magic' => self::getMagic(),
			'eco' => self::getEco(),
			'product' => HomePage::getProduct(),
			'cosmetic' => self::getCosmetic(),
			'example' => CosmetologyPage::getExample(),
			'faq' => self::getFaq(),
			'blog' => self::getBlog(),
			'ymap' => self::getYmap(),
			'pagination' => self::getPagination(),

			'main_title' => 'Информация для пациентов от Bellarti',
			'seo_title' => 'Информация для пациентов от экспертов Bellarti',
			'seo_description' => 'Узнайте, как биоревитализанты Bellarti помогают сохранить молодость кожи. Клинические примеры, косметические средства и ответы на частые вопросы для пациентов.',
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
			'trash-3' => self::getImage('trash-3.png'),
			'trash-4' => self::getImage('trash-4.png')
		];
	}

	public static function getMain()
	{
		return [
			'block' => getBlockName('main'),
			'img' => self::getResizedImage('patient.png', ['1366', '768', false]),
		];
	}

	public static function getBio()
	{
		return [
			'block' => getBlockName('bio'),
			'title' => 'Биоревитализация',
			'desc' => 'Это современная инъекционная процедура, направленная на&nbsp;введение препарата на&nbsp;основе гиалуроновой кислоты.',
			'subtitle' => 'Процедура способна',
			'items' => [
				[
					'icon' => self::getIcon('young'),
					'caption' => 'оказать быстрое омолаживающее действие'
				],
				[
					'icon' => self::getIcon('pigment'),
					'caption' => 'избавить кожу от&nbsp;пигментных пятен и&nbsp;следов постакне'
				],
				[
					'icon' => self::getIcon('older'),
					'caption' => 'справиться со&nbsp;всеми возрастными изменениями кожи'
				],
				[
					'icon' => self::getIcon('flower'),
					'caption' => 'придать свежесть лицу'
				],
				[
					'icon' => self::getIcon('round'),
					'caption' => 'убрать темные круги под&nbsp;глазами'
				],
			]
		];
	}

	public static function getMagic()
	{
		return [
			'block' => getBlockName('magic'),
			'bg' => self::getImage('magic-bg.png'),
			'desc' => 'Все препараты Bellarti имеют рН&nbsp;6,8-7,6. Этот показатель близок к&nbsp;естественному показателю рН кожи, что делает процедуру биоревитализации максимально безболезненной для&nbsp;пациента.'
		];
	}

	public static function getEco()
	{
		return [
			'block' => getBlockName('eco'),
			'bg' => [
				'src' => self::getImage('eco-bg.png'),
				'mods' => [
					'768' => self::getImage('eco-bg-tablet.png'),
				]
			],
			'title' => 'Экосистема Bellarti<sup>®</sup>'
		];
	}

	public static function getCosmetic()
	{
		return [
			'block' => getBlockName('cosmetic'),
			'img' => self::getResizedImage('cosmetic-oxi.png', [false, false, 510]),
			'title' => 'Косметические средства',
			'desc' => 'Bellarti&nbsp;<sup>®</sup> — больше, чем бренд биоревитализантов. Ассортимент бренда предлагает косметические средства, направленные на&nbsp;заботу о&nbsp;восстановлении кожи.',
			'ref' =>
			[
				'caption' => '<span class="c-bold">Bellarti<sup>®</sup> </span><span class="c-extra-light">Oxy</span>' . getCommonIcon('arrow-more'),
				'link' => '/product/bellarti-oxy'
			]
		];
	}

	public static function getFaq()
	{
		return [
			'block' => getBlockName('faq'),
			'title' => 'FAQ',
			'icon' => getCommonIcon('arrow-45')
		];
	}

	public static function getBlog()
	{
		return [
			'block' => getBlockName('blog'),
			'title' => 'Блог'
		];
	}

	public static function getYmap(string $title = 'Клиники-партнеры')
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
				'caption' => 'Биоревитализанты',
				'anchor' => getBlockName('bio')
			],
			[
				'caption' => 'Косметические средства',
				'anchor' => getBlockName('cosmetic')
			],
			[
				'caption' => 'Клинические примеры',
				'anchor' => getBlockName('example')
			],
			[
				'caption' => 'FAQ',
				'anchor' => getBlockName('faq')
			],
			[
				'caption' => 'Блог',
				'anchor' => getBlockName('blog')
			],
		];
	}
}
