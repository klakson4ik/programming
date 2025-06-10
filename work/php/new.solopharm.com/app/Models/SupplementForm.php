<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplementForm extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'supplement_forms';

	protected $casts = [
		'data' => 'json',
		'img' => ToWebpCast::class
	];

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, SupplementForm::class);
	}
}
