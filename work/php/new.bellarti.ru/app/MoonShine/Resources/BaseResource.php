<?php

namespace App\MoonShine\Resources;

use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use App\Helpers\SiteHelpers;
use Illuminate\Support\Facades\Cache;

abstract class BaseResource extends ModelResource
{
	protected $originalData = null;
	/**
	 * Массив полей изображений, которые будут очищаться при изменении их значений
	 * Напр ['img'] - при изменении поля img будут удалены все модификаты старой картинки из этого поля
	 * При удалении записи так же будут удалены все модификаты картинокиз указанных полей
	 */
	protected array $imagesFieldsToClear = ['img'];
	protected bool $isCaching = false;

	public function redirectAfterSave(): string
	{
		return $this->indexPageUrl();
	}

	protected function beforeUpdating(Model $item): Model
	{
		$this->originalData = $item->getOriginal();
		$key = $item->getTable();

		if(Cache::has($key) && $this->isCaching) {
			Cache::forget($key);
		}
		return $item;
	}

	protected function afterCreated(Model $item): Model
	{
		$service = new ImageService(true);

		foreach($this->imagesFieldsToClear as $key => $field) {

			if($imageName = $item->getAttribute($field)) {
				if(gettype($imageName) == 'array') {
					foreach($imageName as $img) {
						if(gettype($img) == 'array') $img = reset($img);
						$service->getWebp($img);
					}
				} else {
					$service->getWebp($imageName);
				}
			}
		}

		return $item;
	}

	protected function afterUpdated(Model $item): Model
	{
		$service = new ImageService(true);

		foreach($item->getChanges() as $key => $value) {
			$data = $this->originalData[$key];
			if(in_array($key, $this->imagesFieldsToClear) && $data) {

				if(gettype($data) == 'array') {
					foreach(SiteHelpers::arrayDiffRecursive($data, $item->$key) as $img) {
						if(gettype($img) == 'array') $img = reset($img);
						$service->removeImage($img);
					}
				} else {
					$service->removeImage($data);
				}

				if(gettype($item->$key) == 'array') {
					foreach($item->$key as $img) {
						if(gettype($img) == 'array') $img = reset($img);
						$service->getWebp($img);
					}
				} else {
					$service->getWebp($item->$key);
				}
			}
		}
		return $item;
	}

	protected function beforeDeleting(Model $item): Model
	{
		$service = new ImageService(true);

		foreach($this->imagesFieldsToClear as $field) {
			if($item->getAttribute($field)) {
				$imgTmp = $item->getAttribute($field);
				if(gettype($imgTmp) == 'array') {
					foreach($imgTmp as $img) {
						$service->removeImage($img);
					}
				} else {
					$service->removeImage($imgTmp);
				}
			}
		}
		return $item;
	}
}
