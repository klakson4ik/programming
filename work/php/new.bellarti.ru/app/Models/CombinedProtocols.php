<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CombinedProtocols extends BaseModel
{
	use SoftDeletes;

	protected $casts = [
		'technologies' => 'json',
	];

	protected $table = 'combined_protocols';

	protected $fillable = [
		'title',
		'description',
		'sort',
		'active',
	];
}
