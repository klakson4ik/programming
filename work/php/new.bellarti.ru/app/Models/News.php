<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class News extends BaseModel
{
	use SoftDeletes;

	protected $table = 'news';

	protected $casts = [
		'json_img' => 'json',
	];


	protected $fillable = [
		'json_img'
	];
}
