<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'club_page';

	protected $casts = [
		'img' => ToWebpCast::class,
		'block_2_img' => ToWebpCast::class,
	];

	protected function getResizeImageColumns(): array
	{
		return ['img', 'block_2_img'];
	}

	protected static $upload = ['img', 'block_2_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, ClubPage::class);
	}
}
