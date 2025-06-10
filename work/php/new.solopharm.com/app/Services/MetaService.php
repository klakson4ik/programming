<?php

namespace App\Services;

class MetaService
{

	public static function getData($data): array
	{
		return [
			'title' => $data->seo_title,
			'description' => $data->seo_description,
			'keywords' => $data->seo_keywords
		];
	}
}
