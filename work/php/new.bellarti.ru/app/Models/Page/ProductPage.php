<?php

namespace App\Models\Page;

class ProductPage extends StaticModel
{
	protected const PAGE = 'detail-product';

	public static function get()
	{
		$data =  [
			'common' => self::getTrash(),
			'main' => self::getMain(),
			'techniques' => self::getTechniques(),
			'publications' => self::getPublications(),
			'videoInstructions' => self::getVideo(),
			'otherProduct' => HomePage::getProduct('Другие препараты линейки Bellarti<sup>®</sup>'),
			'pagination' => self::getPagination(),
		];
		self::addBlockInfo($data);
		return $data;
	}

	/** Вывод летающих капель */
	public static function getTrash()
	{
		return [
			'trash-1' => self::getImage('trash-1.png'),
		];
	}

	/** Вывод детального продукта*/
	private static function getMain()
	{
		return [
			'block' => getBlockName('detail'),
			'docs' => self::getIcon('docs'),
		];
	}

	/** Вывод блока "Техника введения" на детальной*/
	public static function getTechniques()
	{
		return [
			'block' => getBlockName('techniques'),
			'title' => 'Техника введения',
			'bg' => self::getImage('introduction-technique.png'),
		];
	}

	/** Вывод блока "Публикации" на детальной*/
	public static function getPublications()
	{
		return [
			'block' => getBlockName('publications'),
			'title' => 'Публикации',
			'cardData' => ['arrow' => self::getCommonIcon('arrow-publications')],
		];
	}

	/** Вывод блока "Видео" на детальной*/
	public static function getVideo()
	{
		return [
			'block' => getBlockName('videoInstructions'),
			'button' => 'Больше видео',
			'title' => 'Видео инструкции',
			'uniqueVideosFlag' => true,
		];
	}

	private static function getPagination()
	{

		return [
			[
				'caption' => 'Bellarti<sup>®</sup> Hydrate',
				'anchor' => getBlockName('detail'),
			],
			[
				'caption' => 'Техники введения',
				'anchor' => getBlockName('techniques'),
			],
			[
				'caption' => 'Видео инструкции',
				'anchor' => getBlockName('videoInstructions'),
			],
			[
				'caption' => 'Публикации',
				'anchor' => getBlockName('publications'),
			],
			[
				'caption' => 'Другие препараты',
				'anchor' => getBlockName('product'),
			],
		];
	}
}
