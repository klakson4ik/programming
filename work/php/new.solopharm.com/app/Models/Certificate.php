<?php

namespace App\Models;

use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

	protected $table = 'certificates';

	protected static $upload = ['file'];

	public function getFormattedDateAttribute()
	{
		return date('Y/m/d', strtotime($this->date));
	}

	public function scopeGetItems($query)
	{
		return $query
            ->where('lang', '=', app()->getLocale() ?: 'ru')
            ->where('active', '=', true)
            ->select('title', 'desc', 'text', 'file', 'date', 'additional_text')
            ->orderBy('sort', 'ASC');
	}

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Certificate::class);
	}
}
