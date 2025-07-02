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

Route::name('api.pilot.')
    ->controller(\App\Http\Controllers\PilotController::class)
    ->prefix('pilot')
    ->group(function () {
        Route::get('/{pilot}', 'show')->name('show');
        Route::get('/{pilot}/training', 'showTrainings')->name('training.show');
        Route::get('/{pilot}/training/critical', 'showCriticalTrainings')->name('training.critical');
        Route::get('/{pilot}/training/expired', 'showExpiredTrainings')->name('training.expired');
        Route::get('/', 'index')->name('index');
    })
    //->middleware('auth:sanctum') ToDo: Add proper api authentication handled by sanctum
;

Route::name('api.training.')
    ->controller(\App\Http\Controllers\TrainingController::class)
    ->prefix('training')
    ->group(function () {
        Route::get('/{training}', 'show')->name('show');
        Route::get('/', 'index')->name('index');
    })
    //->middleware('auth:sanctum') ToDo: Add proper api authentication handled by sanctum
;

