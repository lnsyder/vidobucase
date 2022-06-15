<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('person')->group(function () {
    Route::post('/', 'PersonController@store');
    Route::get('/', 'PersonController@index');
    Route::get('/{person_id}', 'PersonController@show');
    Route::patch('/{person_id}', 'PersonController@update');
    Route::delete('/{person_id}', 'PersonController@destroy');
});

