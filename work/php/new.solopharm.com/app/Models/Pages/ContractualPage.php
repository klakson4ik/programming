<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractualPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'contractual_page';

	protected $casts = [
		'block_1_data' => 'json',
		'block_2_data' => 'json',
		'block_3_data' => 'json',
		'img' => ToWebpCast::class,
		'block_1_img' => ToWebpCast::class,
		'block_2_img' => ToWebpCast::class,
		'block_3_img' => ToWebpCast::class,
		'block_4_img' => ToWebpCast::class,
	];

	protected function getResizeImageColumns(): array
	{
		return ['img', 'block_1_img', 'block_2_img', 'block_3_img', 'block_4_img'];
	}

	protected static $upload = ['img', 'block_1_img', 'block_2_img', 'block_3_img', 'block_4_img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, ContractualPage::class);
	}
}
