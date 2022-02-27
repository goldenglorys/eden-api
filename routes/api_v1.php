<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\CountryController;
use App\Http\Controllers\APi\v1\GardenerController;
use App\Http\Controllers\API\v1\LocationAreaController;


Route::get('', 'App\Http\Controllers\API\v1\WelcomeController@index');

Route::resource('countries', CountryController::class, ['only' => ['index', 'show']]);

Route::resource('gardeners', GardenerController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);

Route::resource('locations', LocationAreaController::class, ['only' => ['index', 'show']]);


