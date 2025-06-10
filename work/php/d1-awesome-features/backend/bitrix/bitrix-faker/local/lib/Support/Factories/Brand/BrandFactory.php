<?php

namespace App\Support\Factories\Brand;

use App\Support\Factories\Abstract\IBlockFactory;
use Illuminate\Support\Stringable;

class BrandFactory extends IBlockFactory
{
	protected static string|int $IBlockId = 2;

	public function fields(): array
	{
		$name = new Stringable($this->faker->word());
		$slug = $name->slug('-');

		return [
			'NAME' => $name,
			'PREVIEW_TEXT' => $this->faker->realText(),
			'CODE' => $slug,
			'SORT' => $this->faker->randomDigitNotNull(),
		];
	}
}
