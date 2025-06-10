<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clinic extends BaseModel
{
	protected $table = 'clinics';

	public function city(): BelongsTo
	{
		return $this->belongsTo(City::class, 'city_id');
	}
}
