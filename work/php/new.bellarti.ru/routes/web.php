<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CosmetologyController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsDetailController;
use App\Http\Controllers\BlogDetailController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\CosmetologyDetailController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

// Главная +
Route::get('/', HomeController::class)->name('home');
// Страница косметологам +
Route::get('/cosmetology', CosmetologyController::class)->name('cosmetology');
// Страница детального продукта +
Route::get('/product/{url}/{code?}', [ProductController::class, 'index'])->name('product');
// Страница О нас +
Route::get('/about', [AboutController::class, 'index'])->name('about');
// Страница Контакты +
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');
// Страница Косметологам +
Route::get('/patient', PatientController::class)->name('patient');
// Страница "ПОЛИТИКА ОБРАБОТКИ ПЕРСОНАЛЬНЫХ ДАННЫХ"
Route::get('/policy', PolicyController::class)->name('policy');
// Получение видео
Route::get('/products/videos', [ProductController::class, 'getVideos']);

Route::get('/ajax/calendar-detail/{type}/{date}/{page}', [AjaxController::class, 'detailCalendar']);
Route::get('/ajax/calendar-detail/{date}/{page}', [AjaxController::class, 'detailCalendarDay']);


Route::get('/ajax/full-calendar/{type}/{city}/{date}/{page}', [AjaxController::class, 'fullCalendar']);

// Страница новостей
Route::get('/news', NewsController::class)->name('news');
// Страница детальных новостей
Route::get('/news/{code?}', NewsDetailController::class)->name('newsDetails');
// Страница блогов
Route::get('/blogs', BlogController::class)->name('blogs');
// Страница детальных блогов
Route::get('/blogs/{code?}', BlogDetailController::class)->name('blogDetails');
// Страница событий
Route::get('/events', EventController::class)->name('events');
// Страница детальной событий
Route::get('/events/{code?}', EventDetailController::class)->name('eventsDetails');
Route::get('/cosmetology/{code?}', CosmetologyDetailController::class)->name('cosmetologyDetail');
// Страница с отзывом
Route::get('/feedback', FeedbackController::class)->name('feedback');

Route::get('/ajax/clinics/{page}', [AjaxController::class, 'getClinicList']);
Route::get('/ajax/clinic/{id}/', [AjaxController::class, 'getClinic']);
Route::get('/ajax/city/{id}/{page}', [AjaxController::class, 'getCity']);
Route::get('/ajax/pages/{type}', [AjaxController::class, 'getNextPage']);

Route::get('/ajax/calendar/{type}/{date}/{page}', [AjaxController::class, 'calendar']);
Route::get('/ajax/calendar/{date}/{page}', [AjaxController::class, 'calendarDay']);

Route::post('/form/feedback', [FormController::class, 'feedback']);

// Redirect со старого сайта
Route::get('/manufacture', function () {
	return redirect('/about', 301);
});

Route::get('/anonsy', function () {
	return redirect('/events', 301);
});

Route::get('/where-to-buy', function () {
	return redirect('/contacts', 301);
});

Route::get('/single-product/hydrate', function () {
	return redirect('/product/bellarti-hydrate', 301);
});

Route::get('/single-product/lift', function () {
	return redirect('/product/bellarti-lift', 301);
});

Route::get('/single-product/plus', function () {
	return redirect('/product/bellarti-plus', 301);
});

Route::get('/single-product/extra-plus', function () {
	return redirect('/product/bellarti-plus', 301);
});

Route::get('/single-product/amino', function () {
	return redirect('/product/bellarti-amino', 301);
});

Route::get('/single-product/amino-plus', function () {
	return redirect('/product/bellarti-amino-plus', 301);
});

Route::get('/single-product/oxy', function () {
	return redirect('/product/bellarti-oxy', 301);
});

Route::get('/single-product/estilla', function () {
	return redirect('/product/bellarti-estilla', 301);
});

Route::get('/single-product/vita', function () {
	return redirect('/product/bellarti-vita', 301);
});

Route::get('/single-product/vita-plus', function () {
	return redirect('/product/bellarti-vita-plus', 301);
});
