<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.company.')
    ->controller(CompanyController::class)
    ->prefix('company')
    ->group(function () {
        Route::get('/{company}', 'show')->name('show');
        Route::get('/', 'index')->name('index');
    })
    //->middleware('auth:sanctum') ToDo: Add proper api authentication handled by sanctum
;

