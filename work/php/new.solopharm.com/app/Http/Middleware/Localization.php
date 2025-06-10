<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Closure;
use App\Services\LocaleService;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        if (isset($_SERVER['HTTP_REFERER']) && (0 === strpos($_SERVER['HTTP_REFERER'], $_SERVER['APP_URL']))) {
            // если пользователь вошел первый раз на сайт , язык берется из настроек браузера и записывается в Cookie,  в последуюшие разы язык берется из Cookie
            $defaultLocale = config('app.fallback_locale');
            if ($request->cookie('locale')) {
                $locale = $request->cookie('locale');
            } else {
                if (!$request->locale) {
                    $locale = LocaleService::getAutoLocale($request);
                } else if(LocaleService::checkLocale($request->locale)) {
                    $locale = $request->locale;
                } else {
                    $locale = config('app.locale');
                }
                Cookie::queue('locale', $locale, 365 * 24 * 60);
            }
            app()->setLocale($locale);

            if ($locale !== $defaultLocale && !$request->locale) {
                return redirect($locale . '/' . $request->path());
            }
            if ($request->locale && $locale == $defaultLocale) {
                $url = str_replace($request->locale, '', $request->path());
                return redirect($url);
            }
        } else {
            // если пользователь пришел по прямой ссылке или из поисковика.Язык выбирается из url и уставливается по умолчанию в Cookie
            $availableLocales = implode('|', config('app.available_locales'));
            $regex = $_SERVER['APP_URL'] . '\/?(' . $availableLocales . ')?';
            preg_match("#^{$regex}.*#i", $request->url(), $matches);
            $locale =  $matches[1] ?? config('app.fallback_locale');
            app()->setLocale($locale);
            Cookie::queue('locale', $locale, 365 * 24 * 60);
        }
        return $next($request);
    }
}
