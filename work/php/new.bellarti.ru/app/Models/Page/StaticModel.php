<?php

namespace App\Models\Page;

use App\Helpers\ImageHelpers;
use App\Models\Video;

class StaticModel
{
	private const ROOT_PATH = '/images';
	protected const PAGE = '';

	protected static function addBlockInfo(array &$data)
	{
		$data['block'] = getBlockName(static::PAGE);
		$data['asset'] = static::PAGE;
	}

	private static function getPath()
	{
		return self::ROOT_PATH . '/' . static::PAGE . '/';
	}

	protected static function getImage($name)
	{
		return ImageHelpers::getImage(self::getPath() . $name);
	}

	protected static function getCommonImage($name)
	{
		return ImageHelpers::getImage(self::ROOT_PATH . '/common/' . $name);
	}


	protected static function getResizedImage(string $name, array|false $sizes = false)
	{
		return ImageHelpers::getResizedImg(self::getPath() . $name, $sizes, false);
	}

	protected static function getCommonIcon(string $name)
	{
		return ImageHelpers::getCommonIcon($name);
	}

	protected static function getIcon(string $name)
	{
		return ImageHelpers::getIcon(static::PAGE . '/' . $name . '.svg');
	}

	protected static function getVideoByCode(string $code)
	{
		if (!$video = Video::getItemByCode($code)) {
			return false;
		} else {
			if ($video['preview']) {
				$video['preview'] = ImageHelpers::getImage('/storage/' . $video['preview']);
			}
			return $video;
		}
	}
}
