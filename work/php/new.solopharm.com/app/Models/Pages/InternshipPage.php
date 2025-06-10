<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternshipPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'internship_page';

	protected $casts = [
        'form_directions' => 'json',
        'block_1_img' => ToWebpCast::class,
        'block_2_img' => ToWebpCast::class,
        'block_3_img' => ToWebpCast::class,
	];

	protected function getResizeImageColumns(): array
	{
		return ['block_1_img', 'block_2_img', 'block_3_img'];
	}

	protected static $upload = ['block_1_img', 'block_2_img', 'block_3_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, InternshipPage::class);
	}
}
