<?php

use Illuminate\Http\Request;

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

Route::post('/artists', 'APIController@showArtists');
Route::post('/artists/get', 'APIController@getArtists');
Route::post('/artists/add', 'APIController@addArtists');
Route::post('/artists/update', 'APIController@updateArtists');
Route::post('/artists/delete', 'APIController@deleteArtists');

