<?php

namespace App\CLI;

use App\Support\Factories\Brand\BrandFactory;
use App\Support\Factories\Product\ProductFactory;
use App\Support\Factories\Product\ProductGroupBlockFactory;
use App\Support\Factories\Product\ProductSectionFactory;
use TAO\CLI;

class Faker extends CLI
{
	public function faker_seed()
	{
		$sections = ProductSectionFactory::new()
			->count(3)
			->withDrop()
			->create();

		$groups = ProductGroupBlockFactory::new()
			->count(3)
			->withDrop()
			->create();

		$brands = BrandFactory::new()
			->count(4)
			->withDrop()
			->create();

		ProductFactory::new()
			->count(10)
			->withDrop()
			->additional([
				'sections' => $sections['ids'],
				'groups' => $groups,
				'brands' => $brands['ids'],
			])
			->create();
	}
}
