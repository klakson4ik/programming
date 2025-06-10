<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GallerySite extends BaseModel
{
    use HasFactory;
	use HasModifyImages;

	protected $table = 'gallery_sites';

	protected $casts = [
		'img' => ToWebpCast::class
	];

	public function galleries()
    {
      return $this->hasMany(Gallery::class);
    }

	protected static $upload = ['img'];
	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, GallerySite::class);
	}
}
