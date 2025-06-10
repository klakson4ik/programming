<?php

namespace App\Models;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Legal extends BaseModel
{
	use HasFactory;

	protected $table = 'legals';

	public function legalSite()
	{
		return $this->belongsTo(LegalSite::class);
	}

	protected static $upload = ['img'];

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Legal::class);
	}
}
