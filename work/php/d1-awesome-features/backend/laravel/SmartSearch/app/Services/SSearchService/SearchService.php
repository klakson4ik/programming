<?php

namespace App\Services\SSearchService;

use Illuminate\Support\Facades\Config;

class SearchService
{
	const CONFIG_KEY = 'search';
	const ERROR_CODES = [
		'empty' => 'Строка не должна быть пустой!',
		'limit' => 'Текст превышает установленный лимит!',
		'noCorrectWords' => 'Ни одно из введенных слов не является корректным!'
	];

	/**
	 * Использовать ли индексирование для поиска
	 * 
	 * @var 
	 */
	private bool $useIndexing = true;
	
	/**
	 * Максимальный размер строки для поиска
	 * 
	 * @var bool|int
	 */
	private bool|int $maxSearchSize = false;

	/**
	 * Минимальный ранг слова для участия в поиске
	 * 
	 * @var bool|int
	 */
	private bool|int $minWordRange = false;

	/**
	 * Максимальное число слов, по которым производится поиск
	 * 
	 * @var bool|int
	 */
	private bool|int $maxWordsCount = 5;

	/**
	 * Проверять ли найденные слова на соответствие лемме исходного слова
	 * 
	 * @var bool
	 */
	private bool $useLemmaComparison = false;

	/**
	 * Добавлять ли к результатам умного поиска результаты поиска с использованием оператора like
	 * 
	 * @var bool
	 */
	private bool $addPartialResults = false;

	/**
	 * Пространство имён, в котором хранятся модели
	 * 
	 * @var string
	 */
	private string $modelsNamespace = "App\\Models";
	
	/**
	 * Экземпляр класса для работы с индексами
	 * @var IndexingService|null
	 */
	private ?IndexingService $indexingService = null;

	/**
	 * Модели, по которым производится поиск
	 * 
	 * @var array
	 */
	private array $models = [];

	/**
	 * Экземпляр класса MorphyService
	 */
	private $morphy = null;

	/**
	 * Использовать ли словарь для корректировки написанных слов
	 * @var bool
	 */
	private bool $useCorrectionDictionaries = false;

	/**
	 * Использовать один цельный словарь для поиска слов
	 * @var bool
	 */
	private bool $useFullDictionary = false;

	/**
	 * Название файла со словарем без разбиения по буквам
	 * @var string
	 */
	private string $fullDictionaryName = 'words.json';

	/**
	 * Цельный словарь
	 * @var 
	 */
	private ?array $dictionary = null;

	/**
	 * Список словарей, выгруженных из json
	 * @var array
	 */
	private ?array $dictionaries = null;

	/**
	 * Путь к папке, в которой лежат словари
	 * @var string
	 */
	private string $dictionariesPath = '../resources/dictionaries/';
	
	/**
	 * Максимальное расстояние Левенштейна для двух слов
	 * @var int
	 */
	private int $differentsCount = 1;

	/**
	 * Профили для определения рангов
	 * @var 
	 */
	private ?array $profiles = null;

	/**
	 * Расстояния левенштейна
	 * @var array
	 */
	private array $levenshteinCosts = [
		'insert' => 1,
		'replace' => 1,
		'delete' => 1
	];

	public function __construct()
	{
		$config = Config::get(self::CONFIG_KEY);

		$this->useIndexing = $config['useIndexing'] ?? $this->useIndexing;
		$this->maxSearchSize = $config['maxSearchSize'] ?? $this->maxSearchSize;
		$this->minWordRange = $config['minWordRange'] ?? $this->minWordRange;
		$this->maxWordsCount = $config['maxWordsCount'] ?? $this->maxWordsCount;
		$this->modelsNamespace = $config['modelsNamespace'] ?? $this->modelsNamespace;
		$this->useLemmaComparison = $config['useLemmaComparison'] ?? $this->useLemmaComparison;
		$this->addPartialResults = $config['addPartialResults'] ?? $this->addPartialResults;
		$this->useCorrectionDictionaries = $config['useCorrectionDictionaries'] ?? $this->useCorrectionDictionaries;
		$this->differentsCount = $config['differentsCount'] ?? $this->differentsCount;
		$this->useFullDictionary = $config['useFullDictionary'] ?? $this->useFullDictionary;
		$this->profiles = $config['profiles'] ?? $this->profiles;
		if($this->useCorrectionDictionaries === true) {
			$this->dictionariesPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ($config['dictionariesPath'] ?? $this->dictionariesPath);
			$this->fullDictionaryName = $config['fullDictionaryName'] ?? $this->fullDictionaryName;

			if($this->useFullDictionary === true) {
				$dictionaryPath = $this->dictionariesPath . '/' . $this->fullDictionaryName;
				$this->dictionary = json_decode(file_get_contents($dictionaryPath), true);
			}
		}

		if(isset($config['levenshteinCosts'])) {
			$this->levenshteinCosts = array_merge(
				$this->levenshteinCosts,
				$config['levenshteinCosts']
			);
		}

		if(isset($config['models'])) {
			foreach($config['models'] as $modelName => $modelData) {
				$this->models[] = array_merge(['name' => $modelName], $modelData);
			}
		}

		if($this->useIndexing === true) {
			$this->indexingService = new IndexingService();
		}

		$this->morphy = new MorphyService();
	}

	/**
	 * Производит поиск по тексту с учетом установленных в конфиге параметров
	 * 
	 * @param string $text текст для поиска
	 * @return array|array{code: string, error: bool, message: mixed} массив с найденными элементами или массив с информацией в случае ошибки
	 */
	public function search(string $text = ''): array
	{
		if($text == '') {
			return [
				'error' => true,
				'code' => 'empty',
				'message' => self::ERROR_CODES['empty']
			];
		} else if (($this->maxSearchSize !== false) && (strlen($text) > $this->maxSearchSize)) {
			return [
				'error' => true,
				'code' => 'limit',
				'message' => self::ERROR_CODES['limit']
			];
		}

		$words = $this->breakString($text);
		$words = $this->morphy->sortByLanguages($words);
		$words = $this->getRangedArr($words);
		if(count($words) === 0) {
			return [
				'error' => true,
				'code' => 'noCorrectWords',
				'message' => self::ERROR_CODES['noCorrectWords']
			];
		}
		$wordsBaseInfo = $this->prepareWordsInfo($words);

		$finalResult = [];
		if($this->useIndexing === true) {
			$searchIndex = $this->searchInIndex($wordsBaseInfo);
			
			if($searchIndex !== false) {
				$finalResult = $searchIndex['models'];
				$excludeIds = $searchIndex['excludeIds'];
				$wordsIndexInfo = [
					'defaults' => $wordsBaseInfo['defaults'],
					'lemmas' => array_diff($wordsBaseInfo['lemmas'], $searchIndex['wordsInfo']['lemmas']),
					'roots' => array_diff($wordsBaseInfo['roots'], $searchIndex['wordsInfo']['roots'])
				];
			}
		}

		if(
			!isset($wordsIndexInfo)
			||
			(isset($wordsIndexInfo) && count($wordsIndexInfo['lemmas']) != 0)
		) {
			$searchResult = $this->searchInModels($wordsIndexInfo ?? $wordsBaseInfo, $excludeIds ?? []);

			if($searchResult !== false) {
				foreach($searchResult as $key => $value) {
					if(isset($finalResult[$key])) {
						$finalResult[$key] = array_merge($finalResult[$key], $searchResult[$key]);
					} else {
						$finalResult[$key] = $searchResult[$key];
					}
				}
			}
		}

		return $finalResult;
	}

	/**
	 * Возвращает массив слов с указанием рангов
	 * 
	 * @param array $words массив слов, по которым возвращается 
	 * @return array ранжированный массив слов
	 */
	private function getRangedArr(array $words): array
	{
		$rangedArr = [];

		foreach($words as $langWords) {
			foreach(array_unique($langWords) as $word) {
				$lang = $this->morphy->getWordLanguage($word);
				$currentProfile = $this->profiles[$lang] ?? false;
				$range = $this->morphy->getRange($word, $currentProfile);

				if($range === false) {
					$word = $this->morphy->replaceLangLayout($word);
					$lang = $this->morphy->getWordLanguage($word);
					$currentProfile = $this->profile[$lang] ?? false;
					$range = $this->morphy->getRange($word, $currentProfile);
				}

				if($range !== false) {
					if(
						($this->minWordRange !== false) && ($range >= $this->minWordRange)
						||
						($this->minWordRange === false)
					) {
						$rangedArr[] = [
							'word' => $word,
							'range' => $range
						];
					}
				}
			}
		}

		usort($rangedArr, function($first, $second) {
			return (
				($first['range'] < $second['range'])
				||
				(
					($first['range'] == $second['range'])
					&&
					($first['word'] > $second['word'])
				)
			);
		});

		return $rangedArr;
	}

	/**
	 * Подготавливает и возвращает информацию о словах, исправляет опечатки, получает леммы и псевдокорни
	 * @param array $wordsInfoArr ранжированный массив слов
	 * @return array{defaults: array, lemmas: array, roots: array} массив слов, лемм и корней
	 */
	private function prepareWordsInfo(array $wordsInfoArr): array
	{
		$lemmas = [];
		$roots = [];
		$defaults = [];

		if($this->maxWordsCount !== false) {
			$wordsInfoArr = array_slice($wordsInfoArr, 0, $this->maxWordsCount);
		}
		
		foreach($wordsInfoArr as $elem) {
			$word = $elem['word'];
			if($this->useCorrectionDictionaries === true) {
				$defaults[] = $word;

				$correctedWord = $this->getCorrectedWord($word);
				if(($correctedWord !== false) && ($correctedWord !== $word)) {
					$defaults[] = $correctedWord;
				}
			}

			$wordLemmas = $this->morphy->getLemma($word);
			$wordRoots = $this->morphy->getPseudoRoot($word);

			if(isset($correctedWord) && $correctedWord !== false && $correctedWord !== $word) {
				$wordLemmas = array_merge($wordLemmas, $this->morphy->getLemma($correctedWord));
				$wordRoots = array_merge($wordRoots, $this->morphy->getLemma($correctedWord));
			}

			foreach($wordLemmas as $key => $lemma) {
				if(!in_array($lemma, $lemmas)) {
					$currentRoot = (isset($wordRoots[$key]) && $wordRoots[$key] != '') ? $wordRoots[$key] : $wordRoots[0];

					$lemmas[] = $lemma;
					$roots[] = $currentRoot;
				}
			}
		}

		if($this->maxWordsCount !== false) {
			$lemmas = array_slice($lemmas, 0, $this->maxWordsCount);
			$roots = array_slice($roots, 0, $this->maxWordsCount);
		}

		return [
			'defaults' => $defaults,
			'lemmas' => $lemmas,
			'roots' => $roots
		];
	}

	/**
	 * Разбивает строку на слова
	 * @param string $string строка, которую необходимо разбить
	 * @param bool $filter активация фильтрации html-тегов и сущностей
	 * @return array|false массив слов или false в случае неудачи
	 */
	private function breakString(string $string = '', bool $filter = true): array|bool
	{
		$string = mb_strtoupper($string);
		$string = str_replace('Ё', 'Е', $string);

		if($filter === true) {
			$entityPattern = '/&([A-ZА-Я-]);/';
			$string = strip_tags($string);
			$string = preg_replace($entityPattern, ' ', $string);
		}

		$pattern = '/[.!?,;:()\[\]"\' ]+/';
		$result = preg_split($pattern, $string);
		$result = array_filter(
			$result,
			function($value) {
				return $value !== '';
			}
		);
		return $result;
	}

	/**
	 * Поиск слов в моделях, указанных в конфиге
	 * 
	 * @param array $wordsInfo массив с перечнем введенных слов, их лемм и корней
	 * @param array $excludeIds массив индексов исключаемых записей моделей
	 * @return array|bool массив с результатами поиска или false в случае ошибки
	 */
	private function searchInModels(array $wordsInfo = [], array $excludeIds = []): array|bool
	{
		if(count($wordsInfo) == 0) {
			return false;
		}
		$result = [];
		$indexingArr = [];

		foreach($this->models as $modelInfo) {
			$modelName = $modelInfo['name'];
			$modelClass = $this->modelsNamespace . '\\' . $modelName;
			$model = new $modelClass;

			# Получение всех форм слов для лемм и объединение их в один массив
			$wordsForms = [];
			foreach($wordsInfo['lemmas'] as $lemma) {
				$forms = $this->morphy->getWordForms($lemma);
				$wordsForms = array_merge($wordsForms, $forms);
			}

			# Генерация регулярных выражений для текста и для sql-запроса
			$searchString = '\\b(';
			$ftSearchString = '';
			$textPatternSearch = '/\b(';
			$wordsArr = $wordsInfo['roots'];

			if($this->addPartialResults === true) {
				$merged = array_merge($wordsArr, $wordsInfo['defaults']);
				$wordsArr = array_values(array_unique($merged));
			}

			foreach($wordsArr as $key => $root) {
				$searchString .= $root;
				$ftSearchString .= $root . '*';
				$textPatternSearch .= $root;

				if($key < (count($wordsArr) - 1)) {
					$searchString .= '|';
					$ftSearchString .= ' ';
					$textPatternSearch .= '|';
				}
			}
			$searchString .= ')';
			$textPatternSearch .= ').*\b/uUi';

			# Генерация регулярного выражения для частичного поиска в тексте
			if($this->addPartialResults === true) {
				$partPattern = '/\b(';

				foreach($wordsInfo['defaults'] as $key => $part) {
					$partPattern .= $part;

					if($key < (count($wordsInfo['defaults']) - 1)) {
						$partPattern .= '|';
					}
				}

				foreach($wordsInfo['roots'] as $key => $part) {
					$partPattern .= $part;

					if($key < (count($wordsInfo['defaults']) - 1)) {
						$partPattern .= '|';
					}
				}
				$partPattern .= ').*\b/uUi';
			}

			$query = $model::query();

			if(isset($modelInfo['searchFields'])) {
				$query->where(function($q) use($modelInfo, $searchString) {
					foreach($modelInfo['searchFields'] as $field) {
						$q->where($field, 'RLIKE', $searchString, 'OR');
					}
				});
			}

			if(isset($modelInfo['fulltextSearchFields'])) {
				$query->whereFullText(
					$modelInfo['fulltextSearchFields'],
					$ftSearchString,
					['mode' => 'boolean']
				);
			}

			if(count($excludeIds) > 0) {
				$query->whereNotIn('id', $excludeIds[$modelName], 'AND');
			}

			if(isset($modelInfo['fields']) && !in_array('id', $modelInfo['fields'])) {
				$modelInfo['fields'][] = 'id';
			}
			$founds = $query->select($modelInfo['fields'] ?? ['*'])->get()->toArray();

			$founds = $this->prepareModelData($wordsInfo, $modelInfo, $founds);

			# При использовании индексирования генерируем тут массив с id найденных элементов
			if($this->useIndexing === true) {
				foreach($wordsInfo['lemmas'] as $key => $lemma) {
					$root = $wordsInfo['roots'][$key];
					$ids = [];

					foreach($founds as $data) {
						$id = $data['id'];
						$parts = [];

						if($this->addPartialResults === true) {
							$parts = $data['foundWords']['parts'] ?? [];
							$parts = array_filter(
								$parts,
								function($key) use($root) {
									return str_starts_with($key, $root);
								},
								ARRAY_FILTER_USE_KEY
							);
						}

						if(
							(
								isset($data['foundWords']['roots'][$wordsInfo['roots'][$key]])
								||
								count($parts) > 0
							)
							&&
							!in_array($id, $ids)
						) {
							$ids[] = $id;
						}
					}

					$indexingArr[$lemma][$modelInfo['name']] = $ids;
				}
			}

			if($this->addPartialResults === true) {
				$result[$modelName] = array_filter(
					$founds,
					function($value) {
						return (
							isset($value['foundWords']['roots'])
							&&
							count($value['foundWords']['roots']) > 0
						)
						||
						(
							isset($value['foundWords']['parts'])
							&&
							count($value['foundWords']['parts']) > 0
						);
					}
				);
			} else {
				$result[$modelName] = array_filter(
					$founds,
					function($value) {
						return
							isset($value['foundWords']['roots'])
							&&
							count($value['foundWords']['roots']) > 0;
					}
				);
			}
		}

		if($this->useIndexing && count($indexingArr) > 0) {
			$this->indexingService->setIndex($indexingArr);
		}

		return $result;
	}

	/**
	 * Поиск слов среди уже проиндексированных
	 * 
	 * @param array $wordsInfo массив с перечнем введенных слов, их лемм и корней
	 * @return bool|array{excludeIds: array, models: array, wordsInfo: array} массив с результатами поиска, id найденных элементов и список найденных слов или false в случае ошибки
	 */
	private function searchInIndex(array $wordsInfo = []): array|bool
	{
		$indexes = $this->indexingService->getIndexed($wordsInfo['lemmas']);
		if(count($indexes) == 0) {
			return false;
		}
		$models = [];
		$excludeIds = [];

		foreach($this->models as $modelInfo) {
			$modelName = $modelInfo['name'];
			$modelClass = $this->modelsNamespace . '\\' . $modelName;
			$model = new $modelClass;

			$ids = [];
			foreach($indexes as $index) {
				if(isset($index['founds'][$modelName])) {
					$ids = array_merge($ids, $index['founds'][$modelName]);
				}
			}
			$modelIds = array_values(array_unique($ids));

			if(isset($modelInfo['fields']) && !in_array('id', $modelInfo['fields'])) {
				$modelInfo['fields'][] = 'id';
			}

			$modelResult = $model
				->whereIn('id', $modelIds)
				->select($modelInfo['fields'] ?? ['*'])
				->get()->toArray();
			$indexedWords = array_column($indexes, 'word');

			foreach($wordsInfo['lemmas'] as $key => $lemma) {
				if(!in_array($lemma, $indexedWords)) {
					unset($wordsInfo['lemmas'][$key]);
					unset($wordsInfo['roots'][$key]);
				}
			}

			$data = $this->prepareModelData($wordsInfo, $modelInfo, $modelResult);
			$models[$modelInfo['name']] = $data;
			$excludeIds[$modelInfo['name']] = array_column($data, 'id');
		}

		return [
			'excludeIds' => $excludeIds,
			'models' => $models,
			'wordsInfo' => $wordsInfo
		];
	}

	/**
	 * Приводит данные модели к единому виду, фильтрует данные в соответствии с указанными параметрами
	 * 
	 * @param array $wordsInfo массив с перечнем введенных слов, их лемм и корней
	 * @param array $modelInfo массив с информацией о модели
	 * @param array $foundResult массив с найденными в БД данными
	 * @return array отфильтрованный и отсортированный массив данных
	 */
	private function prepareModelData(array $wordsInfo, array $modelInfo, array $foundResult): array
	{
		# Получение всех форм слов для лемм и объединение их в один массив
		$wordsForms = [];
		foreach($wordsInfo['lemmas'] as $lemma) {
			$forms = $this->morphy->getWordForms($lemma);
			$wordsForms = array_merge($wordsForms, $forms);
		}

		$textPatternSearch = '/\b(';
		$wordsArr = $wordsInfo['roots'];
		
		if($this->addPartialResults === true) {
			$merged = array_merge($wordsArr, $wordsInfo['defaults']);
			$wordsArr = array_values(array_unique($merged));
		}

		foreach($wordsArr as $key => $word) {
			$textPatternSearch .= $word;

			if($key < (count($wordsArr) - 1)) {
				$textPatternSearch .= '|';
			}
		}

		$textPatternSearch .= ').*\b/uUi';

		# Генерация регулярного выражения для частичного поиска в тексте
		if($this->addPartialResults === true) {
			$partPattern = '/\b(';
			$wordsArrFull = array_unique(array_merge($wordsInfo['defaults'], $wordsInfo['roots']));

			foreach($wordsArrFull as $key => $part) {
				$partPattern .= $part;

				if($key < (count($wordsArrFull) - 1)) {
					$partPattern .= '|';
				}
			}

			$partPattern .= ').*\b/uUi';
		}

		# Обход найденных элементов, поиск и распределение слов по корням
		$fieldsArr = array_merge(
			$modelInfo['searchFields'] ?? [],
			$modelInfo['fulltextSearchFields'] ?? []
		);
		foreach($foundResult as &$found) {
			$found['foundWords'] = [];
			foreach($fieldsArr as $field) {
				preg_match_all($textPatternSearch, $found[$field], $matches);
				if($this->addPartialResults === true) {
					preg_match_all($partPattern, $found[$field], $partsMatches);
					if(!$matches[0] && !$partsMatches[0]) {
						continue;
					}
				} else {
					if(!$matches[0]) {
						continue;
					}
				}

				$foundWords = array_map(function($arr) {
					return array_map(function($value) {
						return mb_strtoupper($value);
					}, $arr);
				}, $matches);

				foreach($foundWords[1] as $key => $root) {
					$found['foundWords']['roots'][$root][] = $foundWords[0][$key];
				}

				if($this->addPartialResults) {
					$foundParts = array_map(function($arr) {
						return array_map(function($value) {
							return mb_strtoupper($value);
						}, $arr);
					}, $partsMatches);

					foreach($foundParts[1] as $key => $part) {
						$found['foundWords']['parts'][$part][] = $foundParts[0][$key];
					}
				}
			}
		}
		unset($found);

		# Если включена доп проверка по лемме, то обходим массив найденных слов и проверяем
		if($this->useLemmaComparison === true) {
			foreach($foundResult as &$data) {
				foreach($data['foundWords']['roots'] as $root => &$word) {
					$word = array_filter(
						$word,
						function($value) use($wordsForms) {
							return in_array($value, $wordsForms);
						}
					);
				}
				unset($word);
				$data['foundWords']['roots'] = array_filter(
					$data['foundWords']['roots'],
					function ($value) {
						return count($value) > 0;
					}
				);
			}
			unset($data);
		}

		return $foundResult;
	}

	/**
	 * Получить скорректированное слово по словарю
	 * @param string $word слово, которое необходимо скорректировать
	 * @return string|bool скорректированное слово или false, в случае ошибки
	 */
	private function getCorrectedWord(string $word): string|bool
	{
		if(
			$this->useFullDictionary === true
			&&
			$this->dictionary !== null
		) {
			foreach($this->dictionary as $dictWord => $activity) {
				if($activity === '0') {
					continue;
				}

				extract($this->levenshteinCosts);

				$diffSize = match($this->morphy->getWordLanguage($word)){
					'ru' => $this->levenshteinCustom($dictWord, $word, $insert, $replace, $delete),
					'en' => levenshtein($dictWord, $word, $insert, $replace, $delete),
					default => false
				};

				if($diffSize <= $this->differentsCount) {
					return $dictWord;
				}
			}
		} else {
			$letter = mb_strtolower(mb_substr($word, 0, 1));
			$dictionaryPath = $this->dictionariesPath . $letter . '.json';

			if(!isset($this->dictionaries[$letter])) {
				if(file_exists($dictionaryPath)) {
					$dict = json_decode(file_get_contents($dictionaryPath), true);
					$this->dictionaries[$letter] = $dict;
				} else {
					return false;
				}
			}

			if(isset($this->dictionaries[$letter][$word])) {
				return $word;
			} else {
				foreach($this->dictionaries[$letter] as $dictWord => $activity) {
					if($activity === '0') {
						continue;
					}

					extract($this->levenshteinCosts);

					$diffSize = match($this->morphy->getWordLanguage($word)){
						'ru' => $this->levenshteinCustom($dictWord, $word, $insert, $replace, $delete),
						'en' => levenshtein($dictWord, $word, $insert, $replace, $delete),
						default => false
					};

					if($diffSize <= $this->differentsCount) {
						return $dictWord;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Поиск расстояния Левенштейна для кириллицы
	 * 
	 * @param string $string1 одна из строк, для которых вычисляется расстояние Левенштайна
	 * @param string $string2 одна из строк, для которых вычисляется расстояние Левенштайна
	 * @param int $insertionCost стоимость вставки
	 * @param int $replacementCost стоимость замены
	 * @param int $deletionCost стоимость удаления
	 */
	private function levenshteinCustom(
		string $string1,
		string $string2,
		int $insertionCost = 1,
		int $replacementCost = 1,
		int $deletionCost = 1
	): int {
		if($string1 == $string2) {
			return 0;
		}

		list($stringLn1, $stringLn2) = [mb_strlen($string1), mb_strlen($string2)];

		if($stringLn1 == 0 || $stringLn2 == 0) {
			return $stringLn1 ?: $stringLn2;
		}

		$mainRow = range(0, $stringLn1);

		for($i = 0; $i < $stringLn2; $i++) {
			$tempRow = [$i + 1];
			for($j = 0; $j < $stringLn1; $j++) {
				$letter1 = mb_substr($string1, $j, 1);
				$letter2 = mb_substr($string2, $i, 1);
				$cost = ($letter1 == $letter2) ? 0 : 1;

				$tempRow[$j + 1] = min(
					($mainRow[$j + 1] + 1) * $deletionCost,
					($tempRow[$j] + 1) * $insertionCost,
					($mainRow[$j] + $cost) * $replacementCost 
				);
			}
			$mainRow = $tempRow;
		}

		return end($mainRow);
	}
}
