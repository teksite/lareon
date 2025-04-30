<?php

use Illuminate\Support\Facades\Route;
Route::delete('/', function (){
    auth()->logout();
    return redirect('/');
})->name('logout');
