<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Ajax\Admin\Settings\SystemUsagesController;


Route::prefix('settings')->name('settings.')->group(function () {

    Route::get('system_usage',[SystemUsagesController::class,'get'])->name('systemusage.get');
});



