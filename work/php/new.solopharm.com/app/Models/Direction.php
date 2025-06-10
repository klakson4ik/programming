<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direction extends BaseModel
{
  use HasFactory;
  use HasModifyImages;

  protected $casts = [
	  'img' => ToWebpCast::class
  ];

  public function products()
  {
    return $this->belongsToMany(Product::class);
  }

  protected function getResizeImageColumns(): array
  {
	  return ['img'];
  }

  protected static $upload = ['img', 'label'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Direction::class);
	}
}
