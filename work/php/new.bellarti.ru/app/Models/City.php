<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends BaseModel
{
	protected $table = 'cities';

	public function clinics(): HasMany
	{
		return $this->hasMany(Clinic::class);
	}
}
