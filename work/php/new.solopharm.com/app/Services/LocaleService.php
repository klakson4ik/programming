<?php

namespace App\Services;

use Illuminate\View\View;
use Illuminate\Http\Request;

class LocaleService
{

	private const RU_COUNTRY_LOCALES = ['kz', 'ua', 'az', 'hy', 'be', 'ka', 'ky', 'tg', 'tk', 'uz'];

	public function compose(View $view)
	{
		return $view->with('locales', config('app.available_locales'));
	}

	public static function getAutoLocale(Request $request)
	{
		$userLocales = $request->getLanguages();
		$locale = config('app.locale') ?: $request->getLocale();
		if (isset($userLocales[0]) && !empty(config('app.available_locales'))) {
			$langRaw = explode('_', $userLocales[0]);

			$lang = is_array($langRaw) ?  $langRaw[0] : $langRaw;
			if (in_array($lang, config('app.available_locales'))) {
				$locale = $lang;
			} elseif ('ru' !== $lang) {
				$locale = in_array($lang, self::RU_COUNTRY_LOCALES) ? 'ru' : 'en';
			} else {
				$locale = 'ru';
			}
		}
		return $locale;
	}

	public static function checkLocale($locale)
	{
		return in_array($locale, config('app.available_locales')) ?
			true : false;
	}
}
