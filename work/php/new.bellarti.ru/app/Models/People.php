<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;

class People extends BaseModel
{
	protected $table = 'people';

	public function districts() : HasMany
	{
		return $this->hasMany(Districts::class, 'person_id');
	}
}
