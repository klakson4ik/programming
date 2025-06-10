<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technology extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'technologies';

	protected $casts = [
		'img' => ToWebpCast::class
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	protected static $upload = ['img', 'svg'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Technology::class);
	}
}
