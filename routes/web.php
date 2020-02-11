<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ArtistsController@index')->middleware('auth');

Route::get('login', function(){ return view('login'); })->name('login');
Route::post('login', 'Auth\LoginController@login')->name('verify-login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
