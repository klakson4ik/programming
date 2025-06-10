<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SitesPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'sites_page';

	protected $casts = [
		'block_1_data' => 'json',
		'block_2_data' => 'json',
		'img' => ToWebpCast::class,
		'block_1_img' => ToWebpCast::class,
		'block_2_img' => ToWebpCast::class,
		'control_quality_img' => ToWebpCast::class,
		'control_quality_data' => 'json'
	];

	protected function getResizeImageColumns(): array
	{
		return ['img', 'block_1_img', 'block_2_img', 'control_quality_img'];
	}

	protected static $upload = ['block_1_img', 'block_2_img', 'img', 'control_quality_img', 'control_quality_title_svg'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, SitesPage::class);
	}
}
