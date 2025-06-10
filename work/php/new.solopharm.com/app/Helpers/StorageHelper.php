<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
	private const DISK = 'public';

	public static function delete($entry)
	{
		if (is_array($entry)) {
			self::deleteAll($entry);
		} else if($entry) {
			self::deleteOne($entry);
		}
	}

	public static function deleteAfterUpdate($data, $model)
	{
		foreach ($data as $el) {
			$model::updated(static function ($item) use ($el) {
				if (
					$item->wasChanged($el) && $item->getOriginal($el)
					&&
					$item->getChanges()[$el] != $item->getOriginal($el)	
				) {
					self::deleteOne($item->getOriginal($el));
				}
			});
		}
	}

	public static function deleteOne($item)
	{
		if (Storage::disk(self::DISK)->exists($item)) {
			Storage::disk(self::DISK)->delete($item);
		}
	}

	public static function deleteAll($items)
	{
		foreach ($items as $item) {
			if ($item)
				self::deleteOne($item);
		}
	}
}
