<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'products';
	protected $fillable = ['sort'];
	protected static $upload = ['img', 'instruction'];

	protected $casts = [
		'img' => ToWebpCast::class
	];

	public function getCatalogUrlAttribute(): string
	{
		return sprintf('%s/products/%s/', locale(), $this->url_slug);
	}

	public function direction(): BelongsToMany
	{
		return $this->belongsToMany(Direction::class);
	}

	public function trades(): HasMany
	{
		return $this->hasMany(Trade::class);
	}

	protected function getResizeImageColumns(): array
	{
		return ['img'];
	}

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Product::class);
	}
}
