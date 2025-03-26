<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Appearance\IconsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorization\PermissionsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorization\RolesController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\DashboardController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Settings\CachesController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Settings\InfoController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Settings\LogsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Users\UsersController;

Route::get('/', [DashboardController::class, 'show'])->name('dashboard');

Route::prefix('appearance')->name('appearance.')->group(function () {
    Route::get('/icons', [IconsController::class, 'index'])->name('icons.index');
    // Route::get('/file-media', [MediaController::class, 'index'])->name('media.index');
});

Route::prefix('authorize')->name('authorize.')->group(function () {
    Route::resource('permissions', PermissionsController::class);
    Route::resource('roles', RolesController::class);
});

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('info', [InfoController::class, 'index'])->name('info.index');
    Route::prefix('caches')->name('caches.')->group(function () {
        Route::get('/', [CachesController::class, 'index'])->name('index');
        Route::post('/', [CachesController::class, 'run'])->name('run');
    });
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/', [LogsController::class, 'index'])->name('index');
        Route::delete('/clear', [LogsController::class, 'clear'])->name('clear');
        Route::delete('/destroy', [LogsController::class, 'destroy'])->name('destroy');
    });
});

Route::resource('users', UsersController::class);
