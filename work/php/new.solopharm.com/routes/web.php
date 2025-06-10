<?php

use App\Http\Controllers\AdverseReactionController;
use App\Http\Controllers\BiotechController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LiquidPlantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SwitchLangController;
use App\Http\Controllers\SolidPlantController;
use App\Http\Controllers\SupPlantController;
use App\Http\Controllers\RndController;
use App\Http\Controllers\ValuesController;
use App\Http\Controllers\PressController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\LabInternshipController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\PanoramaController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\SoftFormPlantController;
use Illuminate\Support\Facades\Route;
use MoonShine\Http\Controllers\AuthenticateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'moonshine']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::get('/switch-lang/{lang}', SwitchLangController::class);
Route::get('/panorama', [PanoramaController::class, 'index'])->name('panorama');
Route::group(['middleware' => 'moonshine'], function () {
    Route::get('/admin/hh-update', [HelperController::class, 'hhUpdate'])->name('hh-update');
    Route::get('/admin/cache-clear', [HelperController::class, 'cache'])->name('cache-clear');
});
Route::get('/upload/files/memo.pdf', function () {
    return response()->file(public_path('/storage/files/static/memo.pdf'));
});

Route::get('/upload/files/Solopharm_ophtalmo-hirurg_catalog.pdf', function () {
    return response()->file(public_path('/storage/files/static/Solopharm_ophtalmo-hirurg_catalog.pdf'));
});

Route::get('/upload/files/Solopharm_ophtalmo-huring_catalog.pdf', function () {
    return response()->file(public_path('/storage/files/static/Solopharm_ophtalmo-hirurg_catalog.pdf'));
});

// фича на редирект с несущтвуещюго url 
Route::get('/storage/files/products/b9lN0Nd26Spwx78qKK3RqmpMgOnSSUERpQKJ2XCi/preview', function () {
    return response()->file(public_path('/storage/files/products/b9lN0Nd26Spwx78qKK3RqmpMgOnSSUERpQKJ2XCi.pdf'));
});


Route::middleware('locale')->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('main');
    Route::get('/get-products/{id}', [MainController::class, 'getProducts'])->name('main-products');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    Route::get('/404', [ErrorController::class, 'index'])->name('404');
    Route::get('/adverse-reaction-patient', [AdverseReactionController::class, 'index'])->name('reaction-patient');
    Route::get('/adverse-reaction-medical', [AdverseReactionController::class, 'index'])->name('reaction-medical');
    Route::post('/adverse-reaction-patient', [AdverseReactionController::class, 'storePatient'])->name('reaction-patient-store');
    Route::post('/adverse-reaction-medical', [AdverseReactionController::class, 'storeMedical'])->name('reaction-medicali-store');

    Route::get('/products/{name}/{form?}', [ProductController::class, 'show'])->name('products');
    Route::get('/products/{name}/{form?}', [ProductController::class, 'show'])->name('products');
    Route::get('/products/filter/{filters}/apply', [ProductController::class, 'filter'])
        ->name('products')
        ->where('filters', '[a-z0-9-/]+');

    Route::prefix('/contractual')->group(function () {
        Route::get('/', [PartnersController::class, 'contractual'])
            ->name('contractual');

        Route::get('/certificates', [PartnersController::class, 'certificates'])
            ->name('certificates');

        Route::get('/export', [PartnersController::class, 'markets'])
            ->name('markets');
    });

    Route::prefix('/production')->group(function () {
        Route::get('/', [SitesController::class, 'index'])->name('sites');
        Route::get('/technology/{technology?}', [TechnologyController::class, 'index'])->name('technology');
        Route::get('/get-technology/{id}', [TechnologyController::class, 'getData'])->name('get-technology');
        Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment');

        Route::get('/release', [ReleaseController::class, 'index'])->name('release');

        Route::prefix('/sites')->group(function () {
            Route::get('/', [SitesController::class, 'index'])->name('sites');
            Route::get('/biotech', [BiotechController::class, 'index'])->name('biotech');
            Route::get('/liquidplant', [LiquidPlantController::class, 'index'])->name('liquidplant');
            Route::get('/solidplant', [SolidPlantController::class, 'index'])->name('solidplant');
            Route::get('/supplements', [SupPlantController::class, 'index'])->name('supplements');
			Route::get('/soft-form-plant', [SoftFormPlantController::class, 'index'])->name('softformplant');
        });
    });

    Route::prefix('/about')->group(function () {
        Route::get('/', [ValuesController::class, 'index'])->name('values');
        Route::get('/rnd', [RndController::class, 'index'])->name('rnd');
        Route::get('/presses', [PressController::class, 'index'])->name('presses');
        Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');
        Route::get('/news', [NewsController::class, 'index'])->name('news');
        Route::get('/news/{title}', [NewsController::class, 'detail'])->name('news');
        Route::get('/presses/{title}', [PressController::class, 'detail'])->name('presses');
        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
        Route::get('/gallery/{gallery?}', [GalleryController::class, 'show'])->name('gallery');
        Route::get('/legal', [LegalController::class, 'index'])->name('legal');
    });

    route::prefix('/career')->group(function () {
        route::get('/club', [ClubController::class, 'index'])->name('club');
        route::get('/internship', [InternshipController::class, 'index'])->name('internship');
        Route::post('/internship', [InternshipController::class, 'store'])->name('internship-store');
        Route::get('/internship/laboratory', [LabInternshipController::class, 'index'])->name('internship');
        route::get('/', [VacancyController::class, 'index'])->name('vacancies');
        route::get('/{vacancy?}', [VacancyController::class, 'show'])->name('vacancies');
        Route::get('/get-other-region/{city}', [VacancyController::class, 'getPartial'])->name('vacancy-partial');
    });
    route::prefix('/suppliers')->group(function () {
        route::get('/', [SupplierController::class, 'index'])->name('supplier');
        route::post('/', [SupplierController::class, 'store'])->name('supplier-store');
        route::get('/tenders', [TenderController::class, 'index'])->name('tender');
    });
    route::get('/policy', [PolicyController::class, 'index'])->name('policy');

    // Redirect old site url
    Route::get('/drugs/{id?}', function () {
        return redirect('/products', 301);
    });
    Route::get('/worlddrugs/{id?}', function () {
        return redirect('/products', 301);
    });
    Route::get('/about/press/{id?}', function () {
        return redirect('/about/news', 301);
    });

    Route::get('/about/values', function () {
        return redirect('/about', 301);
    });
    Route::get('/production/contractual', function () {
        return redirect('/export/contractual', 301);
    });
    Route::prefix('/partners/export')->group(function () {
        Route::get('/markets', function () {
            return redirect('/export', 301);
        });
        Route::get('/certificates', function () {
            return redirect('/export/certificates', 301);
        });
    });
    Route::get('/suppliers/become-supplier', function () {
        return redirect('/suppliers', 301);
    });
    Route::get('/contacts', function () {
        return redirect('/about/contacts', 301);
    });
    // end

    Route::prefix('{locale}')->group(function () {
        route::get('/policy', [PolicyController::class, 'index'])->name('policy')->whereIn('locale', ['en', 'ru']);
        Route::get('/search', [SearchController::class, 'index'])->name('search')->whereIn('locale', ['en', 'ru']);
        Route::get('/404', [ErrorController::class, 'index'])->name('404');
        Route::get('/products', [ProductController::class, 'index'])->name('products')->whereIn('locale', ['en', 'ru']);
        Route::get('/products/{name}/{form?}', [ProductController::class, 'show'])->name('products')->whereIn('locale', ['ru', 'en']);

        Route::get('/', [MainController::class, 'index'])->name('main')->whereIn('locale', ['ru', 'en']);
        Route::get('/get-products/{id}', [MainController::class, 'getProducts'])->name('main-products')->whereIn('locale', ['ru', 'en']);

        Route::get('/products/filter/{filters}/apply', [ProductController::class, 'filter'])->name('products')->whereIn('locale', ['ru', 'en'])->where('filters', '[a-zA-Z0-9-/]+');

        Route::prefix('/contractual')->group(function () {
            Route::get('/', [PartnersController::class, 'contractual'])
                ->name('contractual');

            Route::get('/certificates', [PartnersController::class, 'certificates'])
                ->name('certificates');

            Route::get('/export', [PartnersController::class, 'markets'])
                ->name('markets');
        })->whereIn('locale', ['ru', 'en']);

        Route::prefix('/production')->group(function () {
            Route::get('/', [SitesController::class, 'index'])->name('sites');
            Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment');
            Route::get('/technology/{technology?}', [TechnologyController::class, 'index'])->name('technology')->where('technology', '[0-9]{1,2}');
            Route::get('/get-technology/{id}', [TechnologyController::class, 'getData'])->name('get-technology')->where('id', '[0-9]{1,2}');
            Route::get('/release', [ReleaseController::class, 'index'])->name('release');
            Route::prefix('/sites')->group(function () {
                Route::get('/', [SitesController::class, 'index'])->name('sites');
                Route::get('/biotech', [BiotechController::class, 'index'])->name('biotech');
                Route::get('/liquidplant', [LiquidPlantController::class, 'index'])->name('liquidplant');
                Route::get('/solidplant', [SolidPlantController::class, 'index'])->name('solidplant');
                Route::get('/supplements', [SupPlantController::class, 'index'])->name('supplements');
                Route::get('/soft-form-plant', [SoftFormPlantController::class, 'index'])->name('softformplant');
            });
        })->whereIn('locale', ['ru', 'en']);

        Route::prefix('/about')->group(function () {
            Route::get('/', [ValuesController::class, 'index'])->name('values');
            Route::get('/rnd', [RndController::class, 'index'])->name('rnd');
            Route::get('/presses', [PressController::class, 'index'])->name('presses');
            Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts');
            Route::get('/news', [NewsController::class, 'index'])->name('news');
            Route::get('/news/{title}', [NewsController::class, 'detail'])->name('news');
            Route::get('/presses/{title}', [PressController::class, 'detail'])->name('presses');
            Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
            Route::get('/gallery/{gallery?}', [GalleryController::class, 'show'])->name('gallery');
            Route::get('/legal', [LegalController::class, 'index'])->name('legal');
        })->whereIn('locale', ['ru', 'en']);

        Route::prefix('/career')->group(function () {
            route::get('/club', [ClubController::class, 'index'])->name('club');
            route::get('/internship', [InternshipController::class, 'index'])->name('internship');
            Route::post('/internship', [InternshipController::class, 'store'])->name('internship-store');
            Route::get('/internship/laboratory', [LabInternshipController::class, 'index'])->name('internship');
            route::get('/', [VacancyController::class, 'index'])->name('vacancies');
            Route::get('/get-other-region/{city}', [VacancyController::class, 'getPartial'])->name('vacancy-partial');
            route::get('/{vacancy?}', [VacancyController::class, 'show'])->name('vacancies');
        })->whereIn('locale', ['ru', 'en']);

        // Redirect old site url
        Route::get('/drugs/{id?}', function () {
            return redirect('/products', 301);
        })->whereIn('locale', ['ru', 'en']);
        Route::get('/worlddrugs/{id?}', function () {
            return redirect('/products', 301);
        })->whereIn('locale', ['ru', 'en']);
        Route::get('/about/press/{id?}', function () {
            return redirect('/about/news', 301);
        })->whereIn('locale', ['ru', 'en']);
        Route::get('/about/values', function () {
            return redirect('/about', 301);
        })->whereIn('locale', ['ru', 'en']);
        Route::get('/production/contractual', function () {
            return redirect('/export/contractual', 301);
        })->whereIn('locale', ['ru', 'en']);
        Route::prefix('/partners/export')->group(function () {
            Route::get('/markets', function () {
                return redirect('/export', 301);
            });
            Route::get('/certificates', function () {
                return redirect('/export/certificates', 301);
            });
        })->whereIn('locale', ['ru', 'en']);
        Route::get('/suppliers/become-supplier', function () {
            return redirect('/suppliers', 301);
        })->whereIn('locale', ['ru']);
        Route::get('/contacts', function () {
            return redirect('/about/contacts', 301);
        })->whereIn('locale', ['ru', 'en']);
        // end
    });
});
