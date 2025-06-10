<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class HelperController extends Controller
{
    private $wrapperStyle = "padding: 50; background-color: rgb(27, 37, 59); color: white;  width: 100%; height: 100%;display: flex; align-items: center; justify-content: center; font-size: 96px;";

    public function cache()
    {
        Cache::flush();
        die("<div style=\"" . $this->wrapperStyle . "\"><p>Cache сброшен</p></div>");
    }

    public function hhUpdate()
    {
        $was = Vacancy::count();
        Artisan::call('make:hh');
        $now = Vacancy::count();
        die("<div style=\"flex-direction: column; " . $this->wrapperStyle . "\"><p>Вакансии обновлены</p><p>Было: " . $was . "</p><p>Стало: " . $now . "</p></div>");
    }
}
