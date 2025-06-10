<?php

namespace App\Casts;

use App\Services\ImageService\Providers\Laravel\ImageService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class ToWebpCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
       if (!is_string($value) || !file_exists(Storage::disk('public')->path($value)) || $this->is_webp($value)) {
		   return $value;
	   }

		$image = ImageService::make($value, params: [
			'format' => 'webp',
			'quality' => 90
		])
			->setup()
			->process()
			->getBasePath();

	   return $image ?: $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
		return $value;
    }

	protected function is_webp($path): bool
	{
		return exif_imagetype(Storage::disk('public')->path($path)) === IMAGETYPE_WEBP;
	}
}
