<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Districts extends BaseModel
{
	protected $table = 'districts';

	public function person(): BelongsTo
	{
		return $this->belongsTo(People::class, 'person_id');
	}
}
