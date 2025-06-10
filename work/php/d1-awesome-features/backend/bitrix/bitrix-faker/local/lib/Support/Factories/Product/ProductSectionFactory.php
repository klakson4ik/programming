<?php

namespace App\Support\Factories\Product;

use App\Support\Factories\Abstract\IBlockSectionFactory;
use Illuminate\Support\Stringable;

class ProductSectionFactory extends IBlockSectionFactory
{
	protected static string|int $IBlockId = 1;

	public function fields(): array
	{
		$name = new Stringable($this->faker->word());
		$slug = $name->slug('-');

		return [
			'NAME' => $name,
			'CODE' => $slug,
		];
	}
}
