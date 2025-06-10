<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

class ImageEditor
{

	public static function resizeInAdmin($width, $height, $name = 'img')
	{
		if (!$_FILES[$name]['tmp_name']) return false;
		self::saveImage($_FILES[$name]['tmp_name'], $width, $height);
	}

	public static function resizeInAdminMultiple($width, $height, $name = 'img')
	{
		$imgs = $_FILES[$name]['tmp_name'];
		foreach ($imgs as $imgName) {
			if (!$imgName) return false;
			self::saveImage($imgName, $width, $height, $imgName);
		}
	}

	private static function saveImage($imgName, $width, $height, $path = null)
	{
		$img = Image::make($imgName);
		$img->resize($width, $height, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});
		if(!$path) {
			$path = $img->dirname . '/' . $img->filename;
		} 
		$img->save($path, 90, 'webp');
	}
}
