<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'contacts';

	protected $casts = [
		'data' => 'json',
		'img' => ToWebpCast::class
	];

	protected static $upload = ['img'];

	public function locations()
	{
		return $this->hasMany(Location::class);
	}

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Contact::class);
	}
}
