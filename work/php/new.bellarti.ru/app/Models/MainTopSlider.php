<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainTopSlider extends Model
{
	use SoftDeletes;

	protected $table = 'main_top_slider';

	protected $fillable = [
		'img',
		'sort',
		'active',
	];
}
