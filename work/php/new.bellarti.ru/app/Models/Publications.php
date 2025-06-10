<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Publications extends BaseModel
{
	protected $table = 'publications';

	protected $fillable = [
		'image',
		'name',
		'speciality',
		'title',
		'name_link',
		'link',
		'active',
		'sort'
	];

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_publications', 'publication_id', 'product_id');
	}
}
