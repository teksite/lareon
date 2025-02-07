<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Web\Admin\Appearance\IconsController;
use Lareon\CMS\App\Http\Controllers\Web\Admin\DashboardController;

Route::get('/',[DashboardController::class, 'show'])->name('dashboard');
Route::prefix('appearance')->name('appearance.')->group(function () {
    Route::get('/icons',[IconsController::class, 'index'])->name('icons.index');

});
