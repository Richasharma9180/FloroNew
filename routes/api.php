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
Route::post('users/login','API\UserController@login');
Route::post('users/register','API\UserController@register');

Route::middleware(['auth:api'])->group(function () {
    Route::post('users/store', 'API\UserController@store');
    Route::post('users/update/{id}', 'API\UserController@update');
    Route::delete('users/delete/{id}', 'API\UserController@destroy');
    
    //Route::resource('drivers', 'DriversController');
    Route::get('users/search', 'API\UserController@getSearchResults'); //search route
    Route::get('users/sort', 'API\UserController@sort');
    Route::get('users/logout','API\UserController@logout');
    Route::get('/users/getall', 'API\UserController@index');

});

Route::get('/export/users', 'ExportUserController@exportUsers')->name('usersExport');
    Route::get('/download/users', 'ExportUserController@showUsersDownload')->name('showUsersDownload');
     Route::get('/download/users-file', 'ExportUserController@downloadUsers')->name('usersDownload');
     
    

