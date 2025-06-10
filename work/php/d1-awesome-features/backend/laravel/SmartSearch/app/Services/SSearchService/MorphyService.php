<?php

namespace App\Services\SSearchService;

use cijic\phpMorphy\Morphy;

class MorphyService
{
	private string $ruLetters = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
	private string $enLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private array $ruLettersReplace = [
		'Й' => 'Q',
		'Ц' => 'W',
		'У' => 'E',
		'К' => 'R',
		'Е' => 'T',
		'Н' => 'Y',
		'Г' => 'U',
		'Ш' => 'I',
		'Щ' => 'O',
		'З' => 'P',
		'Х' => '',
		'Ъ' => '',
		'Ф' => 'A',
		'Ы' => 'S',
		'В' => 'D',
		'А' => 'F',
		'П' => 'G',
		'Р' => 'H',
		'О' => 'J',
		'Л' => 'K',
		'Д' => 'L',
		'Ж' => '',
		'Э' => '',
		'Я' => 'Z',
		'Ч' => 'X',
		'С' => 'C',
		'М' => 'V',
		'И' => 'B',
		'Т' => 'N',
		'Ь' => 'M',
		'Б' => '',
		'Ю' => '',
	];
	private array $enLettersReplace = [
		'Q' => 'Й',
		'W' => 'Ц',
		'E' => 'У',
		'R' => 'К',
		'T' => 'Е',
		'Y' => 'Н',
		'U' => 'Г',
		'I' => 'Ш',
		'O' => 'Щ',
		'P' => 'З',
		'A' => 'Ф',
		'S' => 'Ы',
		'D' => 'В',
		'F' => 'А',
		'G' => 'П',
		'H' => 'Р',
		'J' => 'О',
		'K' => 'Л',
		'L' => 'Д',
		'Z' => 'Я',
		'X' => 'Ч',
		'C' => 'С',
		'V' => 'М',
		'B' => 'И',
		'N' => 'Т',
		'M' => 'Ь'
	];
	private array $defaultRuProfile = [
		'ПРЕДЛ' => 0,
		'СОЮЗ' => 0,
		'МЕЖД' => 0,
		'ВВОДН' => 0,
		'ЧАСТ' => 0,
		'МС' => 0,

		'С' => 5,			// Существительное
		'Г' => 5,			// Глагол
		'П' => 3,			// Прилагательное
		'Н' => 3,			// Наречие
	];

	private array $defaultEnProfile = [
		'PREP' => 0,
		'CONJ' => 0,
		'INT' => 0,
		'PRCL' => 0,
		'PN' => 0,

		'NOUN' => 5,		// Существительное
		'VERB' => 5,		// Глагол
		'ADJECTIVE' => 3,	// Прилагательное
		'ADVERB' => 3,		// Наречие
	];

	/**
	 * Экземпляр класса morphy для русских слов
	 * @var 
	 */
	private ?Morphy $ruMorphy = null;
	
	/**
	 * Экземпляр класса morphy для английских слов
	 * @var 
	 */
	private ?Morphy $enMorphy = null;

	public function __construct()
	{
		$this->ruMorphy = new Morphy('ru');
		$this->enMorphy = new Morphy('en');
	}

	/**
	 * Возвращает язык слова по первой его букве
	 * 
	 * @param string $word
	 * @return bool|string
	 */
	public function getWordLanguage(string $word): string|bool
	{
		$letter = mb_substr($word, 0, 1);

		if(mb_strpos($this->ruLetters, $letter) !== false) {
			return 'ru';
		} else if(mb_strpos($this->enLetters, $letter) !== false) {
			return 'en';
		} else {
			return false;
		}
	}

	/**
	 * Переводит текст на другую раскладку
	 * 
	 * @param mixed $word слово на неверной раскладке
	 * @return bool|string переведенное слово
	 */
	public function replaceLangLayout(string $word): string|bool
	{
		return match($this->getWordLanguage($word)) {
			'ru' => strtr($word, $this->ruLettersReplace),
			'en' => strtr($word, $this->enLettersReplace),
			default => false
		};
	}

	/**
	 * Возвращает массив с разделением слов по языкам
	 * 
	 * @param array $words массив слов, который необходимо разбить по языкам
	 * @return array{en: array, other: array, ru: array} результирующий массив с распределенными словами
	 */
	public function sortByLanguages(array $words = []): array
	{
		$languages = [
			'ru' => [],
			'en' => [],
			'other' => []
		];

		foreach($words as $word) {
			$wordUpper = mb_strtoupper($word);

			switch($this->getWordLanguage($wordUpper)) {
				case 'ru':
					$languages['ru'][] = $wordUpper;
					break;
				case 'en':
					$languages['en'][] = $wordUpper;
					break;
				default:
					$languages['other'][] = $wordUpper;
			}
		}
		return $languages;
	}

	/**
	 * Возвращает леммы слова
	 * 
	 * @param string $word слово, для которого необходимо получить леммы
	 * @return array|bool массив лемм или false в случае ошибки
	 */
	public function getLemma(string $word): array|bool
	{
		return match($this->getWordLanguage($word)) {
			'ru' => $this->ruMorphy->lemmatize($word),
			'en' => $this->enMorphy->lemmatize($word),
			default => false
		};
	}

	/**
	 * Возвращает корень слова
	 * 
	 * @param string $word слово, для которого необходимо получить корень
	 * @return array|bool массив корней или false в случае ошибки
	 */
	public function getPseudoRoot(string $word): array|bool
	{
		return match($this->getWordLanguage($word)) {
			'ru' => $this->ruMorphy->getPseudoRoot($word),
			'en' => $this->enMorphy->getPseudoRoot($word),
			default => false
		};
	}

	/**
	 * Возвращает все формы слова
	 * 
	 * @param string $word слово, формы которого необходимо получить
	 * @return array|bool массив форм слова или false в случае ошибки
	 */
	public function getWordForms(string $word): array|bool
	{
		return match($this->getWordLanguage($word)) {
			'ru' => $this->ruMorphy->getAllForms($word),
			'en' => $this->enMorphy->getAllForms($word),
			default => false
		};
	}

	/**
	 * Возвращает ранг(значимость) слова
	 * 
	 * @param string $word слово, для которого вычисляется ранг
	 * @param array|bool $profile профиль со значимостями
	 * @return int|bool ранг слова или false, в случае ошибки
	 */
	public function getRange(string $word, array|bool $profile = false): int|bool
	{
		$defaultRange = 1;

		switch($this->getWordLanguage($word)) {
			case 'ru':
				if($profile === false) {
					$profile = $this->defaultRuProfile;
				}

				$partsOfSpeech = $this->ruMorphy->getPartOfSpeech($word);
				break;
			case 'en':
				if($profile === false) {
					$profile = $this->defaultEnProfile;
				}

				$partsOfSpeech = $this->enMorphy->getPartOfSpeech($word);
				break;
			default:
				return false;
		}

		$range = [];

		if($partsOfSpeech === false) return false;
	
		foreach($partsOfSpeech as $part) {
			if(isset($profile[$part])) {
				$range[] = $profile[$part];
			} else {
				$range[] = $defaultRange;
			}
		}

		return max($range);
	}
}