<?php

namespace App\Support\Traits;

use App\Services\ImageService\Providers\Laravel\ImageService;
use Illuminate\Database\Eloquent\Model;

trait HasModifyImages
{
	protected static function bootHasModifyImages(): void
	{
		self::updated(function (Model $item) {
			$item->onUpdateResizeImage();
		});

		self::deleted(function (Model $item) {
			$item->onDeleteResizeImage();
		});
	}

	protected function onDeleteResizeImage(): void
	{
		$columns = $this->getResizeImageColumns();

		foreach ($columns as $column) {
			ImageService::make($this->{$column})->delete();
		}
	}

	protected function onUpdateResizeImage(): void
	{
		$columns = $this->getResizeImageColumns();
		$changes = $this->getChanges();

		foreach ($columns as $column) {
			$origin = $this->getOriginal($column);

			if (array_key_exists($column, $changes) && $origin && $changes[$column] !== $origin) {
				ImageService::make($origin)->delete();
			}
		}
	}

	protected function getResizeImageColumns(): array
	{
		return ['img'];
	}
}
