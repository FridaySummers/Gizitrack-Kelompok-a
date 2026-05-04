<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('profiles.index');
});

Route::resource('profiles', ProfileController::class);
