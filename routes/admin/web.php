<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Appearance\IconsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorize\PermissionsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorize\RolesController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\DashboardController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Settings\CachesController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Settings\LogsController;

Route::get('/', [DashboardController::class, 'show'])->name('dashboard');


Route::prefix('settings')->name('settings.')->group(function () {
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/',[LogsController::class, 'show'])->name('show');
        Route::delete('/',[LogsController::class, 'destroy'])->name('delete');
    });
    Route::prefix('cache')->name('caches.')->group(function () {
        Route::get('/',[CachesController::class, 'index'])->name('index');
        Route::post('/',[CachesController::class, 'store'])->name('store');
        Route::delete('/',[CachesController::class, 'destroy'])->name('delete');
    });
});

Route::prefix('appearance')->name('appearance.')->group(function () {
    Route::get('/icons', [IconsController::class, 'index'])->name('icons.index');
});

Route::prefix('authorize')->name('authorize.')->group(function () {
    Route::resource('permissions', PermissionsController::class);
    Route::resource('roles', RolesController::class);
});
