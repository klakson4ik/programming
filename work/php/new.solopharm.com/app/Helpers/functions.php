<?php

use Illuminate\Support\Facades\Request;

function href($item)
{
    $locale = app()->getLocale();
    $item = trim($item);
    $is_def = $locale === config('app.fallback_locale') ? true : false;
    if ($item[0] == '/') {
        return $is_def ? $item : '/' . $locale . $item;
    } else {
        return $item;
    }
}

function locale()
{
    return app()->getLocale() == config('app.fallback_locale') ? '' : app()->getLocale() . '/';
}

function routeName(){
    return Request::route()->getName();
}
