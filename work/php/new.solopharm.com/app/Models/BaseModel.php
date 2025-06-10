<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class BaseModel extends Model
{
	use HasFactory;

	protected $hidden = ["created_at", "updated_at", "deleted_at"];

	public function scopeIsActive($query)
	{
		return $query->where('active', true);
	}

	public function scopeLang($query, $lang = false)
	{
		return $query->where('lang', $lang ?: app()->getLocale());
	}

	public function scopeGetPage($query)
	{
		$key = $query->from .  '-' . app()->getLocale();
		if (Cache::has($key)) {
			return Cache::get($key);
		} else {
			$data = $query->where('lang', app()->getLocale())->first();
			Cache::put($key, $data);
			return $data;
		}
	}

	public function scopeGetItems($query, $sort = 'asc', $active = true)
	{
		return $query->where('active', $active)
			->where('lang', app()->getLocale())
			->orderBy('sort', $sort);
	}

	public function scopeGetCached($query, $sort = 'asc', $active = true)
	{
		$key = $query->from .  '-' . app()->getLocale();
		if (Cache::has($key)) {
			return Cache::get($key);
		} else {
			$data = $query->where('active', $active)
				->where('lang', app()->getLocale())
				->orderBy('sort', $sort)
				->get();
			Cache::put($key, $data);
			return $data;
		}
	}

	public function scopeSort($query, $sort)
	{
		foreach ($sort as $column => $direction) {
			$query->orderBy($column, $direction);
		}

		return $query;
	}

	/**
	 * Получение актуальной даты
	 * 
	 * @param $dateField - название поля даты в базе данных 
	 */
	public function scopeIsActualDate($query, $dateField = 'date')
	{
		return $query->whereRaw("DATEDIFF(NOW(), ".$dateField.") >= 0");
	}
}
