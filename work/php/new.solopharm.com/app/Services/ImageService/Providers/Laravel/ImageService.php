<?php

namespace App\Services\ImageService\Providers\Laravel;

use App\Services\ImageService\AbstractImageService;
use App\Services\ImageService\Managers\InterventionImageManager;
use App\Services\ImageService\Storages\LaravelStorage;

class ImageService extends AbstractImageService
{
	public function __construct(string $path, string $paramsString = '', array $params = [])
	{
		parent::__construct($path, $paramsString, $params);

		$this->config = config('images');
		$this->storage = LaravelStorage::getInstance();
		$this->manager = new InterventionImageManager();
	}
}
