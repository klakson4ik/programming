<?php

namespace App\Models;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends BaseModel
{
  use HasFactory;

  protected $table = 'locations';

  public function contact()
  {
    return $this->belongsTo(Contact::class);
  }

  protected static $upload = ['file'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Location::class);
	}
}
