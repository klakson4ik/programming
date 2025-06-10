<?php

namespace App\Models;

class Event extends BaseModel
{
	protected $table = 'education_events';

	public function city()
    {
        return $this->belongsTo(City::class);
    }
}
