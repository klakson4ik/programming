<?php

namespace App\Services\SSearchService;

use \App\Models\Indexing;

class IndexingService
{
	/**
	 * Модель таблицы, производящей индексирование
	 * @var 
	 */
	private $model = null;

	public function __construct()
	{
		$this->model = new Indexing();
	}

	/**
	 * Заносит данные в индексную таблицу
	 * 
	 * @param array $data массив с данными
	 * @return void
	 */
	public function setIndex(array $data)
	{
		$insertArr = [];

		foreach($data as $word => $models) {
			$insertArr[] = [
				'word' => $word,
				'founds' => json_encode($models)
			];
		}

		$this->model->insertOrIgnore($insertArr);
	}

	/**
	 * Возвращает проиндексированные данные
	 * 
	 * @param array|string $keys ключ(и), данные по которому(ым) необходимо найти
	 * @return array массив с проиндексированными данными
	 */
	public function getIndexed(array|string $keys)
	{
		return $this->model->whereIn('word', $keys)->get()->toArray();
	}

	/**
	 * Обновляет данные в индексной таблице
	 * @param array $data массив с новыми данными
	 * @return void
	 */
	public function updateIndexes(array $data)
	{
		foreach($data as $word => $models) {
			$this->model->where('word', $word)->update(['founds' => json_encode($models)]);
		}
	}

	/**
	 * Убирает из индексной таблицы данные с переданными словами
	 * 
	 * @param array|string $words слово(а), которое(ые) необходимо удалить
	 * @return void
	 */
	public function clearIndex(array|string $words)
	{
		$this->model->whereIn('word', $words)->delete();
	}

	/**
	 * Полностью очищает индексную таблицу
	 * 
	 * @return void
	 */
	public function clearIndexes()
	{
		$this->model->truncate();
	}
}