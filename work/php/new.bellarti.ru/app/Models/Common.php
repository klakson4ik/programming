<?php

namespace App\Models;

class Common extends BaseModel
{
	protected $table = 'commons';

	public function scopeGetByCodes($query, array|string $codes)
	{
		if(gettype($codes) === 'string') return $query->where('code', $codes)->first();

		$query->whereIn('code', $codes);
		return $query->get()->keyBy('code');
	}
}
