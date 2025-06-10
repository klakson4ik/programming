<?php

namespace App\Services\ImageService\Contracts;

interface ImageManagerContract
{
	public function makeImage(string $path): void;

	public function resizeImage(string $method, int $with, int $height): void;

	public function convertImage(string $format, int $quality = 100): void;

	public function setQuality(int $quality): void;

	public function saveImage(string $path): void;
}
