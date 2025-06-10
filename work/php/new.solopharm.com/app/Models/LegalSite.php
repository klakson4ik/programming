<?php

namespace App\Models;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalSite extends BaseModel
{
    use HasFactory;

	protected $table = 'legalsites';

	public function legals()
    {
      return $this->hasMany(Legal::class);
    }

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, LegalSite::class);
	}
}
