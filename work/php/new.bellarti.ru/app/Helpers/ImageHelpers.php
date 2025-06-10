<?php

namespace App\Helpers;

use App\Services\ImageService;

class ImageHelpers
{
	public static function getCommonIcon($name): string|null
	{
		return getCommonIcon($name);
	}

	public static function getIcon($name): string|null
	{
		return getIcon($name);
	}

	public static function getResizedImg($img, array|false $sizesRaw = ['1920', false, false], bool $isStorage = true)
	{
		$templates = ['1366', '768', '540'];
		$sizes = [];
		if ($sizesRaw) {
			foreach ($sizesRaw as $size) {
				if ($size)
					$sizes[current($templates)] = $size . 'x0';
				next($templates);
			}
		} else {
			foreach ($templates as $template) {
				$sizes[$template] = $template . 'x0';
			}
		}
		$service = new ImageService();
		$file =  $isStorage
			? StorageHelpers::getUrlFromStorage($img)
			: $img;
		return  $service->getResizedArray($file, $sizes);
	}

	public static function getImagesArrayByKey(array &$data, string|array $fieldName = 'img')
	{
		foreach ($data as &$item) {
			if (is_array($fieldName)) {
				foreach ($fieldName as $name) {
					$item[$name] = self::getImage('/storage/' . $item[$name]);
				}
			} else {
				$item[$fieldName] = self::getImage('/storage/' . $item[$fieldName]);
			}
		}
	}

	public static function getImagesWithoutSVGArray(array &$data, string $fieldName = 'img')
	{
		foreach ($data as &$item) {
			$item[$fieldName] = pathinfo($item[$fieldName], PATHINFO_EXTENSION) === 'svg'
				?  '/storage/' . $item[$fieldName]
				: self::getImage('/storage/' . $item[$fieldName]);
		}
	}

	public static function getImagesArray(array &$data, string $fieldName = 'img')
	{
		foreach ($data as &$item) {
			if ($item[$fieldName])
				$item[$fieldName] = self::getImage('/storage/' . $item[$fieldName]);
		}
	}

	public static function getImage(string $image)
	{
		$imageServie = new ImageService();
		return $imageServie->getWebp($image);
	}

	public static function getPublicImage(string $file)
	{
		$image = '/images/' . $file;
		return self::getImage($image);
	}

	// Получение webp
	public static function getCommonImage(string $name)
	{
		return self::getPublicImage('common/' . $name);
	}

	public static function resizeImagesFromArrayByKey(array &$data, array|false $sizes = false, string $fieldName = 'img'): void
	{
		foreach ($data as &$el) {
			if ($el[$fieldName]) {
				$el[$fieldName] = self::getResizedImg($el[$fieldName], $sizes);
			}
		}
	}
}
