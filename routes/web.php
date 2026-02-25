<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\SimperController as PetugasSimperController;
use App\Http\Controllers\Petugas\UjsimpController as PetugasUjsimpController;
use App\Http\Controllers\Petugas\CheckupController as PetugasCheckupController;
use App\Http\Controllers\Petugas\RanmorController as PetugasRanmorController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SimperController as AdminSimperController;
use App\Http\Controllers\Admin\UjsimpApprovalController;
use App\Http\Controllers\Admin\UjsimpPdfController;
use App\Http\Controllers\Admin\CheckupApprovalController;
use App\Http\Controllers\Admin\CheckupPdfController;
use App\Http\Controllers\Admin\RanmorApprovalController;
use App\Http\Controllers\Admin\RanmorPdfController;

use App\Http\Controllers\Viewer\DashboardController as ViewerDashboardController;
use App\Http\Controllers\Viewer\RanmorController as ViewerRanmorController;
use App\Http\Controllers\Viewer\SimperController as ViewerSimperController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Viewer\UjsimpController as ViewerUjsimpController;
use App\Http\Controllers\Viewer\CheckupController as ViewerCheckupController;


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| ROLE REDIRECT DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }

    if ($user->role === 'viewer') {
        return redirect()->route('viewer.dashboard');
    }

    return redirect('/');

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| PROFILE (shared by all authenticated users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| PETUGAS ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class,'index'])
            ->name('dashboard');


        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [PetugasSimperController::class,'index'])->name('index');
            Route::get('/create', [PetugasSimperController::class,'create'])->name('create');
            Route::post('/', [PetugasSimperController::class,'store'])->name('store');

            Route::get('/{id}', [PetugasSimperController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasSimperController::class,'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasSimperController::class,'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasSimperController::class,'submit'])
                ->whereNumber('id')->name('submit');
        });


        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [PetugasUjsimpController::class,'index'])->name('index');
            Route::get('/create', [PetugasUjsimpController::class,'create'])->name('create');
            Route::post('/', [PetugasUjsimpController::class,'store'])->name('store');

            Route::get('/{id}', [PetugasUjsimpController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasUjsimpController::class,'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasUjsimpController::class,'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasUjsimpController::class,'submit'])
                ->whereNumber('id')->name('submit');
        });


        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [PetugasCheckupController::class,'index'])->name('index');
            Route::get('/create', [PetugasCheckupController::class,'create'])->name('create');
            Route::post('/', [PetugasCheckupController::class,'store'])->name('store');

            Route::get('/{id}', [PetugasCheckupController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasCheckupController::class,'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasCheckupController::class,'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasCheckupController::class,'submit'])
                ->whereNumber('id')->name('submit');

            Route::get('/{id}/preview', [PetugasCheckupController::class,'preview'])
                ->whereNumber('id')->name('preview');
        });


        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [PetugasRanmorController::class,'index'])->name('index');
            Route::get('/create', [PetugasRanmorController::class,'create'])->name('create');
            Route::post('/', [PetugasRanmorController::class,'store'])->name('store');

            Route::get('/{id}', [PetugasRanmorController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasRanmorController::class,'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasRanmorController::class,'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasRanmorController::class,'submit'])
                ->whereNumber('id')->name('submit');
        });

});


/*
|--------------------------------------------------------------------------
| VIEWER ROUTES (READ ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:viewer'])
    ->prefix('viewer')
    ->name('viewer.')
    ->group(function () {

        Route::get('/dashboard', [ViewerDashboardController::class,'index'])
            ->name('dashboard');

        Route::get('/simper', [ViewerDashboardController::class, 'simper'])->name('simper');
        Route::get('/ujsimp', [ViewerDashboardController::class, 'ujsimp'])->name('ujsimp');
        Route::get('/checkup', [ViewerDashboardController::class, 'checkup'])->name('checkup');
        Route::get('/ranmor', [ViewerDashboardController::class, 'ranmor'])->name('ranmor');


        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [ViewerSimperController::class,'index'])->name('index');

            Route::get('/{id}', [ViewerSimperController::class,'show'])
                ->whereNumber('id')->name('show');
        });


        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [ViewerUjsimpController::class,'index'])->name('index');

            Route::get('/{id}', [ViewerUjsimpController::class,'show'])
                ->whereNumber('id')->name('show');
        });


        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [ViewerCheckupController::class,'index'])->name('index');

            Route::get('/{id}', [ViewerCheckupController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/preview', [ViewerCheckupController::class,'preview'])
                ->whereNumber('id')->name('preview');
        });


        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [ViewerRanmorController::class,'index'])->name('index');

            Route::get('/{id}', [ViewerRanmorController::class,'show'])
                ->whereNumber('id')->name('show');
        });

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class,'index'])
            ->name('dashboard');


        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [AdminSimperController::class,'index'])->name('index');

            Route::get('/{id}', [AdminSimperController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [AdminSimperController::class,'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [AdminSimperController::class,'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [AdminSimperController::class,'previewPdf'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [AdminSimperController::class,'downloadPdf'])
                ->whereNumber('id')->name('download');
        });


        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [UjsimpApprovalController::class,'index'])->name('index');

            Route::get('/{id}', [UjsimpApprovalController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [UjsimpApprovalController::class,'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [UjsimpApprovalController::class,'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [UjsimpPdfController::class,'preview'])
                ->whereNumber('id')->name('preview');
        });


        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [CheckupApprovalController::class,'index'])->name('index');

            Route::get('/{id}', [CheckupApprovalController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [CheckupApprovalController::class,'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [CheckupApprovalController::class,'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [CheckupPdfController::class,'preview'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [CheckupPdfController::class,'download'])
                ->whereNumber('id')->name('download');
        });


        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [RanmorApprovalController::class,'index'])->name('index');

            Route::get('/{id}', [RanmorApprovalController::class,'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [RanmorApprovalController::class,'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [RanmorApprovalController::class,'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [RanmorPdfController::class,'preview'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [RanmorPdfController::class,'download'])
                ->whereNumber('id')->name('download');
        });

});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';