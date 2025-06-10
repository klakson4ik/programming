<?php

namespace App\Models;

class Partners extends BaseModel
{
	protected $table = 'partners';

	protected $fillable = [
		'img',
		'url',
		'title',
		'alt',
		'active',
		'sort'
	];
}
