<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CheckupApprovalController;
/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\CheckupPdfController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RanmorApprovalController;
use App\Http\Controllers\Admin\RanmorPdfController;
use App\Http\Controllers\Admin\SimperController as AdminSimperController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Admin\UjsimpApprovalController;
use App\Http\Controllers\Admin\UjsimpPdfController;
use App\Http\Controllers\Avp\ApprovalHistoryController;
use App\Http\Controllers\Avp\ApprovalQueueController;
use App\Http\Controllers\Avp\CheckupApprovalController as AvpCheckupApprovalController;
use App\Http\Controllers\Avp\DashboardController as AvpDashboardController;
use App\Http\Controllers\Avp\RanmorApprovalController as AvpRanmorApprovalController;
use App\Http\Controllers\Avp\SimperApprovalController as AvpSimperApprovalController;
use App\Http\Controllers\Avp\UjsimpApprovalController as AvpUjsimpApprovalController;
use App\Http\Controllers\Petugas\CheckupController as PetugasCheckupController;
use App\Http\Controllers\Api\IdentityLookupController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\RanmorController as PetugasRanmorController;
use App\Http\Controllers\Petugas\SimperController as PetugasSimperController;
use App\Http\Controllers\Petugas\UjsimpController as PetugasUjsimpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Viewer\CheckupController as ViewerCheckupController;
use App\Http\Controllers\Viewer\DashboardController as ViewerDashboardController;
use App\Http\Controllers\Viewer\RanmorController as ViewerRanmorController;
use App\Http\Controllers\Viewer\SimperController as ViewerSimperController;
use App\Http\Controllers\Viewer\UjsimpController as ViewerUjsimpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'super_admin') {
            return redirect()->route('super-admin.dashboard');
        }
        if ($user->role === 'admin' || $user->role === 'admin_perijinan') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'petugas' || $user->role === 'checker_lapangan') {
            return redirect()->route('petugas.dashboard');
        }
        if ($user->role === 'avp') {
            return redirect()->route('avp.dashboard');
        }
        if ($user->role === 'viewer' || $user->role === 'user') {
            return redirect()->route('viewer.dashboard');
        }

        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| ROLE REDIRECT DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $user = Auth::user();

    if ($user->role === 'super_admin') {
        return redirect()->route('super-admin.dashboard');
    }

    if ($user->role === 'admin' || $user->role === 'admin_perijinan') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'petugas' || $user->role === 'checker_lapangan') {
        return redirect()->route('petugas.dashboard');
    }

    if ($user->role === 'avp') {
        return redirect()->route('avp.dashboard');
    }

    if ($user->role === 'viewer' || $user->role === 'user') {
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
    Route::get('/account', [ProfileController::class, 'index'])->name('account.index');
    Route::post('/account/password', [ProfileController::class, 'updatePassword'])->name('account.password');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\SuperAdmin\CompanyController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TokenController as SuperAdminTokenController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ZoneController;

/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super-admin')
    ->name('super-admin.')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

        // USER MANAGEMENT
        Route::resource('users', SuperAdminUserController::class)->except(['create', 'store']);

        // TOKEN MANAGEMENT
        Route::get('/tokens', [SuperAdminTokenController::class, 'index'])->name('tokens.index');
        Route::post('/tokens/generate', [SuperAdminTokenController::class, 'generate'])->name('tokens.generate');
        Route::post('/tokens/{token}/reveal', [SuperAdminTokenController::class, 'reveal'])->name('tokens.reveal');

        Route::resource('companies', CompanyController::class);
        Route::resource('zones', ZoneController::class);

        // MASTER DATA CONFIGURATION
        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('simper', \App\Http\Controllers\SuperAdmin\SimperItemController::class);
            Route::resource('ujsimp', \App\Http\Controllers\SuperAdmin\UjsimpItemController::class);
            Route::resource('checkup', \App\Http\Controllers\SuperAdmin\CheckupItemController::class);
            Route::resource('ranmor', \App\Http\Controllers\SuperAdmin\RanmorFieldController::class);
        });

        // SYSTEM MONITORING
        Route::prefix('monitoring')->name('monitoring.')->group(function () {
            Route::get('/', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'index'])->name('index');
            Route::get('/login', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'loginLogs'])->name('login');
            Route::get('/register', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'registerLogs'])->name('register');
            Route::get('/exam/created', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'examCreated'])->name('exam.created');
            Route::get('/exam/submitted', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'examSubmitted'])->name('exam.submitted');
            Route::get('/exam/verified', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'examVerified'])->name('exam.verified');
            Route::get('/exam/approved', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'examApproved'])->name('exam.approved');
            Route::get('/exam/rejected', [\App\Http\Controllers\SuperAdmin\SystemMonitoringController::class, 'examRejected'])->name('exam.rejected');
        });
    });

/*
|--------------------------------------------------------------------------
| AVP ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:avp'])
    ->prefix('avp')
    ->name('avp.')
    ->group(function () {

        Route::get('/dashboard', [AvpDashboardController::class, 'index'])->name('dashboard');

        Route::get('/approval-queue', [ApprovalQueueController::class, 'index'])->name('approval-queue');

        Route::get('/approval-history', [ApprovalHistoryController::class, 'index'])->name('approval-history');

        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {
            Route::get('/{id}', [AvpUjsimpApprovalController::class, 'show'])->whereNumber('id')->name('show');
            Route::post('/{id}/approve', [AvpUjsimpApprovalController::class, 'approve'])->whereNumber('id')->name('approve');
            Route::post('/{id}/reject', [AvpUjsimpApprovalController::class, 'reject'])->whereNumber('id')->name('reject');
        });

        Route::prefix('simper')->name('simper.')->group(function () {
            Route::get('/{id}', [AvpSimperApprovalController::class, 'show'])->whereNumber('id')->name('show');
            Route::post('/{id}/approve', [AvpSimperApprovalController::class, 'approve'])->whereNumber('id')->name('approve');
            Route::post('/{id}/reject', [AvpSimperApprovalController::class, 'reject'])->whereNumber('id')->name('reject');
        });

        Route::prefix('checkup')->name('checkup.')->group(function () {
            Route::get('/{id}', [AvpCheckupApprovalController::class, 'show'])->whereNumber('id')->name('show');
            Route::post('/{id}/approve', [AvpCheckupApprovalController::class, 'approve'])->whereNumber('id')->name('approve');
            Route::post('/{id}/reject', [AvpCheckupApprovalController::class, 'reject'])->whereNumber('id')->name('reject');
            Route::delete('/photo/{id}', [AvpCheckupApprovalController::class, 'destroyPhoto'])->whereNumber('id')->name('photo.destroy');
        });

        Route::prefix('ranmor')->name('ranmor.')->group(function () {
            Route::get('/{id}', [AvpRanmorApprovalController::class, 'show'])->whereNumber('id')->name('show');
            Route::post('/{id}/approve', [AvpRanmorApprovalController::class, 'approve'])->whereNumber('id')->name('approve');
            Route::post('/{id}/reject', [AvpRanmorApprovalController::class, 'reject'])->whereNumber('id')->name('reject');
        });
    });

/*
|--------------------------------------------------------------------------
| API LOOKUP (Session-based)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/api/identity/{code}', [IdentityLookupController::class, 'show'])->name('api.identity.lookup');
});

/*
|--------------------------------------------------------------------------
| PETUGAS ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [PetugasSimperController::class, 'index'])->name('index');
            Route::get('/create', [PetugasSimperController::class, 'create'])->name('create');
            Route::post('/', [PetugasSimperController::class, 'store'])->name('store');

            Route::get('/{id}', [PetugasSimperController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasSimperController::class, 'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasSimperController::class, 'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasSimperController::class, 'submit'])
                ->whereNumber('id')->name('submit');
        });

        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [PetugasUjsimpController::class, 'index'])->name('index');
            Route::get('/create', [PetugasUjsimpController::class, 'create'])->name('create');
            Route::post('/', [PetugasUjsimpController::class, 'store'])->name('store');

            Route::get('/{id}', [PetugasUjsimpController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasUjsimpController::class, 'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasUjsimpController::class, 'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasUjsimpController::class, 'submit'])
                ->whereNumber('id')->name('submit');
        });

        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [PetugasCheckupController::class, 'index'])->name('index');
            Route::get('/create', [PetugasCheckupController::class, 'create'])->name('create');
            Route::post('/', [PetugasCheckupController::class, 'store'])->name('store');

            Route::get('/{id}', [PetugasCheckupController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasCheckupController::class, 'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasCheckupController::class, 'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasCheckupController::class, 'submit'])
                ->whereNumber('id')->name('submit');

            Route::get('/{id}/preview', [PetugasCheckupController::class, 'preview'])
                ->whereNumber('id')->name('preview');
        });

        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [PetugasRanmorController::class, 'index'])->name('index');
            Route::get('/create', [PetugasRanmorController::class, 'create'])->name('create');
            Route::post('/', [PetugasRanmorController::class, 'store'])->name('store');

            Route::get('/{id}', [PetugasRanmorController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/edit', [PetugasRanmorController::class, 'edit'])
                ->whereNumber('id')->name('edit');

            Route::put('/{id}', [PetugasRanmorController::class, 'update'])
                ->whereNumber('id')->name('update');

            Route::post('/{id}/submit', [PetugasRanmorController::class, 'submit'])
                ->whereNumber('id')->name('submit');
        });

    });

/*
|--------------------------------------------------------------------------
| VIEWER ROUTES (READ ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:viewer'])
    ->prefix('viewer')
    ->name('viewer.')
    ->group(function () {

        Route::get('/dashboard', [ViewerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/simper-list', [ViewerDashboardController::class, 'simper'])->name('simper');
        Route::get('/ujsimp-list', [ViewerDashboardController::class, 'ujsimp'])->name('ujsimp');
        Route::get('/checkup-list', [ViewerDashboardController::class, 'checkup'])->name('checkup');
        Route::get('/ranmor-list', [ViewerDashboardController::class, 'ranmor'])->name('ranmor');

        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [ViewerSimperController::class, 'index'])->name('index');

            Route::get('/{id}', [ViewerSimperController::class, 'show'])
                ->whereNumber('id')->name('show');
        });

        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [ViewerUjsimpController::class, 'index'])->name('index');

            Route::get('/{id}', [ViewerUjsimpController::class, 'show'])
                ->whereNumber('id')->name('show');
        });

        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [ViewerCheckupController::class, 'index'])->name('index');

            Route::get('/{id}', [ViewerCheckupController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::get('/{id}/preview', [ViewerCheckupController::class, 'preview'])
                ->whereNumber('id')->name('preview');
        });

        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [ViewerRanmorController::class, 'index'])->name('index');

            Route::get('/{id}', [ViewerRanmorController::class, 'show'])
                ->whereNumber('id')->name('show');
        });

    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,admin_perijinan,super_admin'])->group(function () {
    Route::get('/admin/tokens', [TokenController::class, 'index'])->name('admin.tokens.index');
    Route::post('/admin/tokens', [TokenController::class, 'store'])->name('admin.tokens.store');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | ACTIVITY LOGS
        */
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        /*
        | VERIFICATION HISTORY
        */
        Route::get('/verification-history', [\App\Http\Controllers\Admin\VerificationHistoryController::class, 'index'])
            ->name('verification-history');

        /*
        | SIMPER
        */
        Route::prefix('simper')->name('simper.')->group(function () {

            Route::get('/', [AdminSimperController::class, 'index'])->name('index');

            Route::get('/{id}', [AdminSimperController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [AdminSimperController::class, 'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [AdminSimperController::class, 'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [AdminSimperController::class, 'previewPdf'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [AdminSimperController::class, 'downloadPdf'])
                ->whereNumber('id')->name('download');
        });

        /*
        | UJSIMP
        */
        Route::prefix('ujsimp')->name('ujsimp.')->group(function () {

            Route::get('/', [UjsimpApprovalController::class, 'index'])->name('index');

            Route::get('/{id}', [UjsimpApprovalController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/verify', [UjsimpApprovalController::class, 'verify'])
                ->whereNumber('id')->name('verify');

            Route::post('/{id}/reject', [UjsimpApprovalController::class, 'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [UjsimpPdfController::class, 'preview'])
                ->whereNumber('id')->name('preview');
        });

        /*
        | CHECKUP
        */
        Route::prefix('checkup')->name('checkup.')->group(function () {

            Route::get('/', [CheckupApprovalController::class, 'index'])->name('index');

            Route::get('/{id}', [CheckupApprovalController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [CheckupApprovalController::class, 'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [CheckupApprovalController::class, 'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [CheckupPdfController::class, 'preview'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [CheckupPdfController::class, 'download'])
                ->whereNumber('id')->name('download');

            Route::delete('/photo/{id}', [CheckupApprovalController::class, 'destroyPhoto'])
                ->whereNumber('id')->name('photo.destroy');
        });

        /*
        | RANMOR
        */
        Route::prefix('ranmor')->name('ranmor.')->group(function () {

            Route::get('/', [RanmorApprovalController::class, 'index'])->name('index');

            Route::get('/{id}', [RanmorApprovalController::class, 'show'])
                ->whereNumber('id')->name('show');

            Route::post('/{id}/approve', [RanmorApprovalController::class, 'approve'])
                ->whereNumber('id')->name('approve');

            Route::post('/{id}/reject', [RanmorApprovalController::class, 'reject'])
                ->whereNumber('id')->name('reject');

            Route::get('/{id}/preview', [RanmorPdfController::class, 'preview'])
                ->whereNumber('id')->name('preview');

            Route::get('/{id}/download', [RanmorPdfController::class, 'download'])
                ->whereNumber('id')->name('download');
        });

    });

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
