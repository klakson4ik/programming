<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $casts = [
		'img' => ToWebpCast::class
	];

	protected $table = 'sites';

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Site::class);
	}
}
