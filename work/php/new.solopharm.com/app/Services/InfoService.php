<?php

namespace App\Services;

use Illuminate\View\View;
use App\Models\Info;
use Illuminate\Support\Facades\Cache;

class InfoService
{

	public function compose(View $view)
	{
		$data = null;
		$key = 'info-' . app()->getLocale();
		if (Cache::has($key)) {
			$data = Cache::get($key);
		} else {
			$data = Info::lang()
				->first();
			if ($data) {
				$data->sociate = $this->getSociate($data);
			}
			Cache::put($key, $data);
		}

		return $view->with('info', $data);
	}

	private function getSociate($data)
	{
		$sociate = [];
		foreach ($data->getAttributes() as $key => $item) {
			$is = explode('_', $key);
			if (is_array($is) && $is[0] == 'is' && $item) {
				$sociate[$is[1]] = $data[$is[1] . '_url'];
			}
		}
		return $sociate;
	}
}
