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
Route::group(['namespace'=>'Basic','prefix'=>'Basic'],function(){
    Route::get('/', 'IndexController@index');

    Route::group(['namespace'=>'Auth','prefix'=>'Auth'],function(){
        Route::get('/', 'IndexController@index');
    });


    Route::group(['namespace'=>'Goods','prefix'=>'Goods'],function(){
        Route::get('/getData', 'GoodsController@getGoodsData');
    });
});