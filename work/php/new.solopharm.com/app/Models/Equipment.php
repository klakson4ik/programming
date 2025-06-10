<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'equipments';

	protected $casts = [
		'img' => ToWebpCast::class
	];

	protected static $upload = ['img'];
	
	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Equipment::class);
	}
}
