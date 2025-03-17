<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Apearance\IconsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Apearance\MediaController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorization\PermissionsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Authorization\RolesController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\DashboardController;

Route::get('/', [DashboardController::class, 'show'])->name('dashboard');

Route::prefix('appearance')->name('appearance.')->group(function () {
    Route::get('/icons', [IconsController::class, 'index'])->name('icons.index');
   // Route::get('/file-media', [MediaController::class, 'index'])->name('media.index');
});

Route::prefix('authorize')->name('authorize.')->group(function () {
    Route::resource('permissions', PermissionsController::class);
    Route::resource('roles', RolesController::class);
});
