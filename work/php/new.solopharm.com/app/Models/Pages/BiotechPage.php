<?php

namespace App\Models\Pages;

use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BiotechPage extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'biotech_page';

	protected $casts = [
		'block_1_data' => 'json',
		'block_2_data_1' => 'json',
		'block_2_data_2' => 'json',
	];

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, BiotechPage::class);
	}
}
