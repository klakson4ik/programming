<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiotechEquipment extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'biotech_equipments';

	protected $casts = [
		'data' => 'json',
		'img' => ToWebpCast::class
	];

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, BiotechEquipment::class);
	}
}
