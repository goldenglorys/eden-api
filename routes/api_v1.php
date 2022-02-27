<?php

use Illuminate\Support\Facades\Route;


Route::get('', 'App\Http\Controllers\API\v1\WelcomeController@index');