<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends BaseModel
{
	use SoftDeletes;

	protected $table = 'blog';

	protected $casts = [
		'json_img' => 'json',
	];

	protected $fillable = [
		'img',
		'sort',
		'active',
	];
}
