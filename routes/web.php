<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', "IndexController@index");
Route::group(['namespace'=>'Admin','prefix'=>'Admin'],function(){
    Route::get('/', 'IndexController@index');

    Route::group(['namespace'=>'Auth','prefix'=>'Auth'],function(){
        Route::get('/', 'IndexController@index');
    });
});