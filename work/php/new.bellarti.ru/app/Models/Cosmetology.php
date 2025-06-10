<?php

namespace App\Models;

class Cosmetology extends BaseModel
{
	protected $table = 'cosmetology_events';

	public function city()
    {
        return $this->belongsTo(City::class);
    }
}
