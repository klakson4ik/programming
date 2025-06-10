<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseModel
{

	protected $casts = [
		'file' => 'json',
		'technologies' => 'json',
	];

	protected $fillable = [
		'url',
		'name',
		'title',
		'images',
		'description',
		'structure',
		'indications',
		'course',
		'file',
		'video',
		'sort',
		'active',
		'videos',
		'technologies',
		'priority_offer_id',
	];

	
	public function offers(): HasMany
	{
		return $this->hasMany(Offer::class);
	}

	public function videos(): BelongsToMany
	{
		return $this->belongsToMany(Video::class, 'product_video', 'product_id', 'video_id');
	}

	public function publications(): BelongsToMany
	{
		return $this->belongsToMany(Publications::class, 'product_publications', 'product_id', 'publication_id');
	}

	public function priorityOffer(): BelongsTo
	{
		return $this->belongsTo(Offer::class, 'priority_offer_id');
	}
}
