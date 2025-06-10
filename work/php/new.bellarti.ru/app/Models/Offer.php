<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends BaseModel
{
	protected $fillable = [
		'product_id',
		'url',
		'name',
		'images',
		'description',
		'structure',
		'Indications',
		'Course',
		'File'
	];

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
}
