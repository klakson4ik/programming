<?php

namespace App\Models;

use App\Casts\ToWebpCast;
use App\Helpers\StorageHelper;
use App\Support\Traits\HasModifyImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trade extends BaseModel
{
	use HasFactory;
	use HasModifyImages;

	protected $table = 'trades';
    protected $fillable = ['sort'];
	protected static $upload = ['img'];

	protected $casts = [
		'export_countries' => 'json',
		'img' => ToWebpCast::class
	];

	public function technology(): BelongsTo
	{
		return $this->belongsTo(Technology::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function direction(): BelongsTo
	{
		return $this->belongsTo(Direction::class);
	}

	protected function getResizeImageColumns(): array
	{
		return ['img'];
	}

	protected static function boot(): void
	{
		parent::boot();
		StorageHelper::deleteAfterUpdate(self::$upload, Trade::class);
	}

	public function scopeForList($query)
	{
		return $query->where('show_in_list', 1)->orWhere('is_main', 1);
	}
}
