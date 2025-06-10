<?php

namespace App\Services\SDictionaryService;

use App\Services\SSearchService\MorphyService;
use Illuminate\Support\Facades\Config;

class DictionaryService
{
	private array $excludeWords = [];
	private array $dictionary = [];
	private MorphyService $morphyService;
	private array $config = [];
	private string $file = '';

	public function __construct()
	{
		$this->config = Config::get('search');
		$this->file = $this->config['dictionariesPath'] . '/' . $this->config['fullDictionaryName'];
		$this->morphyService = new MorphyService();
		$excludeRU = [];
		$excludeEN = [];
		if (file_exists(__DIR__ . '/data/exclude-ru.php')) {
			$excludeRU  = require_once(__DIR__ . '/data/exclude-ru.php');
		}
		if (file_exists(__DIR__ . '/data/exclude-en.php')) {
			$excludeEN = require_once(__DIR__ . '/data/exclude-en.php');
		}

		$this->excludeWords = array_merge($excludeRU, $excludeEN);
		if (file_exists(__DIR__ . '/data/exclude-customm.php')) {
			$excludeCustom = require_once(__DIR__ . '/data/exclude-custom.php');
			if (count($excludeCustom) > 0)
				$this->excludeWords = array_merge($this->excludeWords, $excludeCustom);
		}
	}

	public function create()
	{
		foreach ($this->config['models'] as $modelName => $fields) {
			$items = $this->getModelItems($modelName);
			foreach ($items as $item) {
				foreach ($fields['searchFields'] as $field) {
					$words = preg_split('/[.!?,;:()\[\]"\' ]/', $item[$field]);
					foreach ($words as $word) {
						$this->addLemmas($word);
					}
				}
			}
		}
	}

	public function saveToJSON() {
		$arr = [];
		foreach ($this->dictionary as $line) {
			$arr[$line] = "1";
		}
		file_put_contents($this->file, json_encode($arr));
	}

	private function getModelItems($modelName)
	{
		$modelClass = $this->config['modelsNamespace'] . '\\' . $modelName;
		$model = new $modelClass;
		return $model::query()->get()->toArray();
	}

	private function addLemmas($word)
	{
		if (preg_match('/\//', $word)) return;
		if (preg_match('/<[a-z0-6]+>/', $word)) {
			$word = strip_tags($word);
		}
		$wordUpper = mb_strtoupper($word);
		$lemma = $this->morphyService->getLemma($wordUpper);
		if ($lemma) {
			if (is_array($lemma[0])) {
				foreach ($lemma[0] as $each) $this->addLemma($each);
			} else {
				$this->addLemma($lemma[0]);
			}
		}
	}

	private function addLemma($lemma)
	{
		if (mb_strlen($lemma) < 2) return;
		if (in_array($lemma, $this->dictionary)) return;
		if (!in_array($lemma, $this->excludeWords)) $this->dictionary[] = $lemma;
	}

	private function createStringFromArray()
	{
		$result = '';
		foreach ($this->dictionary as $line) {
			$result .= $line . PHP_EOL;
		}
		return $result;
	}
}
