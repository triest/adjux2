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


Route::get('/', 'MainController@index')->name('main');

Route::get('/a/create', 'AController@create');

Route::get('a', 'AController@index')->name('a');
Route::get('b', 'BController@index')->name('b');

Route::post('a/store', 'AController@store')->name('storeA');