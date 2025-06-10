<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class SupplementPage extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'supplement_page';

	protected $casts = [
		'block_1_data' => 'json',
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
		StorageHelper::deleteAfterUpdate(self::$upload, SupplementPage::class);
	}
}
