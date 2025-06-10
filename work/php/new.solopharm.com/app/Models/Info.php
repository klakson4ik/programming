<?php

namespace App\Models;

use App\Helpers\StorageHelper;

class Info extends BaseModel
{
    protected $table = 'infos';

	protected $casts = [
		'menu' => 'json',
        'sociate' => 'json'
	];

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Info::class);
	}
}
