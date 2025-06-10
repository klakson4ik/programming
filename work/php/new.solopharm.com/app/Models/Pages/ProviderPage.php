<?php

namespace App\Models\Pages;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Models\BaseModel;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProviderPage extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $casts = [
		'img' => ToWebpCast::class
	];

	protected $table = 'provider_page';

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, ProviderPage::class);
	}
}
