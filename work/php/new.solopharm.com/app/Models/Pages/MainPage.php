<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

    protected $casts = [
        'block_2_text' => 'json',
		'block_1_img' => ToWebpCast::class
    ];

	protected function getResizeImageColumns(): array
	{
		return ['block_1_img'];
	}

	protected static $upload = ['block_1_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, MainPage::class);
	}
	
}
