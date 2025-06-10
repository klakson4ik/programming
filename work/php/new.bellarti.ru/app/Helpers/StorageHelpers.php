<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StorageHelpers
{
	/**
	 * Возвращает html-код svg из хранилища
	 *
	 * @param string $filename название файла
	 * @return string|null html-код svg или null, если не найдена
	 */
	public static function putSvgFromStorage($filename = 'svg'): string|null
	{
		$path = self::getPathFromStorage($filename);
		return file_get_contents($path);
	}

	/**
	 * Возвращает полный путь к файлу из хранилища
	 *
	 * @param string $filename название файла
	 * @return string|false path файла или false, если файл не найден
	 */
	public static function getPathFromStorage(string $filename = ''): string|false
	{
		return Storage::disk('public')->path($filename);
	}

	/**
	 * Возвращает url к файлу из хранилища
	 *
	 * @param string $filename название файла
	 * @return string|false url к файлу или false, если файл не найден
	 */
	public static function getUrlFromStorage(string $filename): string|false
	{
		return Storage::url($filename);
	}

	public static function saveFileFromRequest($file, $path = '') {
		return Storage::putFile('public' . $path, new File($file));
	}
}
