<?php

namespace App\Models\Pages;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class RndPage extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'block_1_data' => 'json',
        'block_2_data' => 'json',
        'block_3_data' => 'json',
        'block_2_imgs' => 'json',
    ];

	protected static $upload = ['block_1_img', 'block_3_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, RndPage::class);
	}
}
