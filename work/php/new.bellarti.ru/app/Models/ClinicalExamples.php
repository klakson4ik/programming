<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicalExamples extends BaseModel
{
	use SoftDeletes;

	protected $table = 'clinical_examples';

	protected $fillable = [
		'img_before',
		'img_after',
		'title',
		'description',
		'name',
		'town',
		'link',
		'sort',
		'active',
		'created_at',
		'updated_at',
		'deleted_at',
	];
}
