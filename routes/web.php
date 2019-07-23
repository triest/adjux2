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

Auth::routes();

Route::get('/', 'MainController@index')->name('main');

Route::get('/a/create', 'AController@create');

Route::get('a', 'AController@index')->name('a');
Route::get('b', 'BController@index')->name('b');

Route::post('a/store', 'AController@store')->name('storeA');
Auth::routes();

Route::post('admin/deleteB', 'AdminController@deleteUserB')->name('deleteDid');
Route::post('admin/deleteA', 'AdminController@deleteUserA')->name('deleteRand');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/', 'AdminController@b')->name('admin');
    Route::get('admin/b/{id}', 'AdminController@showB')->name('showB');
    Route::get('admin/a/{id}', 'AdminController@showA')->name('showA');
    Route::get('admin/b/delete/{id}', 'AdminController@deleteB')
        ->name('deleteB')->middleware('superAdmin');
    Route::get('admin/a/delete/{id}', 'AdminController@deleteA')
        ->name('deleteA')->middleware('superAdmin');
    Route::get('admin/b', 'AdminController@didIndex')->name('adminB');
    Route::get('admin/a', 'AdminController@randIndex')->name('adminA');
    Route::get('admin/Organizer', 'AdminController@Organizer')
        ->name('makeOrganizer')/*->middleware('superAdmin');*/
    ;
    Route::get('admin/getUsers', 'AdminController@getUsers')->name('getUsers');
    Route::get('main/create', 'MainController@create')->name('createMain')
        ->middleware('superAdmin');
    Route::post('main/store', 'MainController@store')->name('storeMain')
        ->middleware('superAdmin');
    Route::get('main/edit', 'MainController@edit')->name('editMain')
        ->middleware('superAdmin');
    Route::post('main/update', 'MainController@update')->name('updateMain');
    Route::get('main/getImages', 'AdminController@getImages')
        ->name('getImages');
    Route::post('main/imageUpload', 'MainController@updateImage')
        ->name('updateImageMain');

    Route::post('admin/makeB', 'AdminController@makeB')->name('makeB');
    Route::post('admin/makeA', 'AdminController@makeA')->name('makeA');
});