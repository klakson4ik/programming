<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseModel extends Model
{
	use HasFactory;

	protected $hidden = ["created_at", "updated_at", "deleted_at"];


	/** Область запроса для выбора только активных элементов.*/
	public function scopeIsActive($query)
	{
		return $query->where('active', true);
	}

	/**Область запроса для получения элементов с опциональной сортировкой и статусом активности.*/
	public function scopeGetItems($query, $sort = 'asc', $active = true)
	{
		return $query->where('active', $active)
			->orderBy('sort', $sort);
	}

	/** Область запроса для получения элементов в виде массива.*/
	public function scopeGetItemsArray($query, $sort = 'asc', $active = true, array|false $columns = false)
	{
		$query = $this::getItems($sort, $active);
		$query = $columns ? $query->get($columns) : $query->get();
		return $query->toArray();
	}

	/**Область запроса для сортировки по нескольким столбцам.*/
	public function scopeSort($query, $sort)
	{
		foreach ($sort as $column => $direction) {
			$query->orderBy($column, $direction);
		}

		return $query;
	}

	/** Область запроса для получения элемента по коду.*/
	public function scopeGetItemByCode($query, $code)
	{
		try {
			return $query->where('code', $code)->firstOrFail()->toArray();
		} catch (\Exception $ex) {
			return false;
		}
	}
}
