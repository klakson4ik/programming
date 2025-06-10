<?php

namespace App\Models\Pages;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ValuePage extends BaseModel
{
    use HasFactory;

	protected static $upload = ['block_2_btn_link'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, ValuePage::class);
	}
}
