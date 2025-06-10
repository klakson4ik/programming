<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Video extends BaseModel
{
	protected $table = 'videos';

	protected $fillable = [
		'name',
		'preview',
		'video',
		'video_vk',
	];

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'product_video', 'video_id', 'product_id');
	}
}
