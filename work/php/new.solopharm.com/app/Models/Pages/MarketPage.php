<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'market_page';

	protected $casts = [
		'block_1_data' => 'json',
		'block_2_img' => ToWebpCast::class
	];

	protected function getResizeImageColumns(): array
	{
		return ['block_2_img'];
	}

	protected static $upload = ['block_2_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, MarketPage::class);
	}
}
