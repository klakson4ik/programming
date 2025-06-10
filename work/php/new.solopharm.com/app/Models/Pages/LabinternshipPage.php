<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabinternshipPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'labinternship_page';

	protected $casts = [
		'block_1_data' => 'json',
		'img' => ToWebpCast::class,
	];

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, LabinternshipPage::class);
	}
}
