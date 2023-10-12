<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VersionController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('version/test@19', [VersionController::class, 'index']);