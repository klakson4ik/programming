<?php

/**
 * Возвращает массив декодируя строку JSON, убирая лишние символы
 *
 * @param string $str
 * @return array
 */
function jsonDecode(string $str): string
{
	return json_decode(stripcslashes(html_entity_decode(trim($str))), true);
}


/**
 * usfirst polyfill для многобайтовых строк
 *
 * @param string $str
 * @param string $encoding
 * @return string
 */
function mb_ucfirst(string $str, string $encoding = "UTF-8"): string
{
	$firstLetter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
	$word = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);

	return $firstLetter.$word;
}

/**
 * Обрезает текст до нужной длинны, при необходимости добавлет троеточие в конце строки
 *
 * @param string $text
 * @param int $limit
 * @param bool $addDots - добавить троеточие
 * @return string
 */
function cropText(string $text, int $limit, bool $addDots = true): string
{
	$cropped_text = mb_substr($text, 0, $limit);

	if (mb_strlen($cropped_text) < mb_strlen($text)) {
		if (!in_array(mb_substr($text, $limit, 1), [' ', '?', '!', '.', ','])) {
			$limit = mb_strripos($cropped_text, ' ');
			$cropped_text = mb_substr($cropped_text, 0, $limit);
		}

		$cropped_text = trim($cropped_text, ' !?.,');

		if ($addDots) {
			$cropped_text .= '...';
		}
	}

	return $cropped_text;
}

/**
 * Возвращает плосски вид переданного массива, проходит по нему рекурсивно
 *
 * @param array $array
 * @return array
 */
function flatArray(array $array): array
{
	$recursiveIterator = new RecursiveArrayIterator($array,RecursiveArrayIterator::CHILD_ARRAYS_ONLY);
	$iterator = new RecursiveIteratorIterator($recursiveIterator);

	return iterator_to_array($iterator, false);
}

/**
 * Возвращщает элемент ассиативного массива, проводя поиск по значению переданного ключа
 *
 * @param array $array - Массив, в котором проводится поиск
 * @param mixed $needle - Значение, по которому проводится поиск
 * @param string|int $column - Колонка, в которой проверяется значение
 * @return mixed
 */
function findInArrayByColumn(array $array, mixed $needle, string|int $column): mixed
{
	$key = array_search($needle, array_column($array, $column));
	$values = array_values($array);

	return $values[$key] ?? null;
}

/**
 * Возвращает значение ссылки для html тега a, от переданного номера телефона.
 * Так же обрезает телефон по кол-ву символов, по умолчанию - 10
 *
 * @param string $phone
 * @param int $limit
 * @return string
 */
function getPhoneHref(string $phone, int $limit = 10): string
{
	$phone = preg_replace('/\D/', '', $phone);

	if ($phone[0] === '8' || $phone[0] === '7') {
		$phone = substr($phone, 1);
	}

	if (strlen($phone) > $limit) {
		$phone = substr($phone, 0, $limit);
	}

	return 'tel:+7' . $phone;
}

/**
 * Рекурсивно удаляет директорию и ее содержимое
 *
 * @param string $dir
 * @return void
 */
function removeDivRecursive(string $dir): void
{
	if (!$dir || !file_exists($dir)) {
		return;
	}

	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object === "." || $object === "..") {
				continue;
			}

			if (is_dir($dir. '/' .$object) && !is_link($dir. '/' .$object)) {
				removeDivRecursive($dir. '/' .$object);
				continue;
			}

			unlink($dir. '/' .$object);
		}
		rmdir($dir);
	}
}
