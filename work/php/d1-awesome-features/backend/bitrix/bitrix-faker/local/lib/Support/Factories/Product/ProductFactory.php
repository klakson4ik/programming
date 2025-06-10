<?php

namespace App\Support\Factories\Product;

use App\Support\Factories\Abstract\IBlockFactory;
use CFile;
use Illuminate\Support\Stringable;

class ProductFactory extends IBlockFactory
{
	protected static string|int $IBlockId = 1;

	public static array $IMAGES = [
		'/upload/faker/space3_01.JPG',
		'/upload/faker/space3_02.JPG',
		'/upload/faker/space3_03.JPG',
		'/upload/faker/space3_04.JPG',
		'/upload/faker/space3_05.JPG',
		'/upload/faker/space3_06.JPG',
		'/upload/faker/space3_07.JPG',
		'/upload/faker/space3_08.JPG',
		'/upload/faker/space3_09.JPG',
		'/upload/faker/space3_10.JPG',
	];

	public function fields(): array
	{
		$name = new Stringable($this->faker->word());
		$slug = $name->slug('-');
//		$imagePath = $this->faker->imageUrl(640, 480, 'animals', true);
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $this->faker->randomElement(self::$IMAGES);

		$image = CFile::MakeFileArray($imagePath);

		return [
			'NAME' => $name,
			'PREVIEW_TEXT' => $this->faker->realText(),
			'PREVIEW_PICTURE' => $image,
			'CODE' => $slug,
			'IBLOCK_SECTION_ID' => $this->faker->randomElement($this->additional['sections']),
			'PROPERTY_VALUES' => [
				'size' => $this->faker->randomDigitNotNull(),
				'color' => $this->faker->hexColor(),
				'brand' => $this->faker->randomElement($this->additional['brands']),
				'group' => [
					'VALUE' => $this->faker->randomElement($this->additional['groups']),
				],
			]
		];
	}
}
