<?php

namespace App\Helpers;

use App\Services\ImageService;

class SiteHelpers
{
	public static function cropText($text, $limit)
	{
		$cropped_text = mb_substr($text, 0, $limit);
		if (mb_strlen($cropped_text) < mb_strlen($text)) {
			if (!in_array(mb_substr($text, $limit, 1), array(' ', '?', '!', '.', ','))) {
				$limit = mb_strripos($cropped_text, ' ');
				$cropped_text = mb_substr($cropped_text, 0, $limit);
			}
			$cropped_text = trim($cropped_text, ' !?.,');
			$cropped_text .= '...';
		}
		return $cropped_text;
	}

	public static function getPhoneHref($phone)
	{
		return preg_replace('#[^0-9\+]+#', '', $phone);
	}

	/**
	 * Возвращает меты из массива
	 *
	 * @param array $data Массив, из которого необходимо извлечь меты
	 * @return array массив с метами
	 */
	public static function extractMetas($data)
	{
		return [
			'title' => $data['seo_title'],
			'description' => $data['seo_description'],
			'keywords' => $data['seo_keywords']
		];
	}

	/**
	 * Глубинное сравнение элементов двух массивов
	 *
	 * @param array $array1 первый массив
	 * @param array $array2 второй массив
	 * @return array массив, содержащий элементы, которые есть в первом массиве, но нету во втором
	 */
	public static function arrayDiffRecursive(array $array1, array $array2): array
	{
		$result = [];
		foreach ($array1 as $value) {
			if (!in_array($value, $array2)) {
				$result[] = $value;
			}
		}
		return $result;
	}

	public static function numWord(int $value, array $words, bool $show = true): string
	{
		$num = $value % 100;
		if ($num > 19) {
			$num = $num % 10;
		}

		$out = ($show) ? $value . ' ' : '';
		$word = match ($num) {
			1 => $words[0],
			2, 3, 4 => $words[1],
			default => $words[2],
		};

		return $out . '<span>'. $word . '</span>';
	}
}
