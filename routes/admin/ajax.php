<?php

use Illuminate\Support\Facades\Route;
use Lareon\CMS\App\Http\Controllers\Ajax\Admin\Authorization\RolesController;
use Lareon\CMS\App\Http\Controllers\Ajax\Admin\Users\UsersController;


Route::get('users/get',[UsersController::class ,'get'])->name('users.get');
Route::get('roles/get',[RolesController::class ,'get'])->name('roles.get');
