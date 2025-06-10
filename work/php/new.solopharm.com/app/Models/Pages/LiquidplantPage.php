<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class LiquidplantPage extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'liquidplant_page';

	protected $casts = [
		'block_1_data' => 'json',
		'block_2_data' => 'json',
		'block_1_img' => ToWebpCast::class,
		'block_2_img' => ToWebpCast::class,
	];

	protected function getResizeImageColumns(): array
	{
		return ['block_1_img', 'block_2_img'];
	}

	protected static $upload = ['block_1_img', 'block_2_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, LiquidplantPage::class);
	}
}
