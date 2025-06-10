<?php

namespace App\Support\Factories\Product;

use App\Support\Factories\Abstract\HighloadBlockFactory;
use Bitrix\Main\ORM\Data\DataManager;

class ProductGroupBlockFactory extends HighloadBlockFactory
{
	protected static string|int $HLBlockID = 1;

	public function fields(): array
	{
		return [
			'UF_NAME' => $this->faker->word(),
			'UF_XML_ID' => $this->faker->randomDigitNotNull()
		];
	}
}
