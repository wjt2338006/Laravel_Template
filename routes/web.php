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

//Route::get('/', "IndexController@index");
//Route::group(['namespace'=>'Basic','prefix'=>'Basic'],function(){
//    Route::get('/', 'IndexController@index');
//
//    Route::group(['namespace'=>'Auth','prefix'=>'Auth'],function(){
//        Route::get('/', 'IndexController@index');
//    });
//
//
//    Route::group(['namespace'=>'Goods','prefix'=>'Goods'],function(){
//        Route::get('/getData', 'GoodsController@getGoodsData');
//    });
//
//
//
//});

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@requestLogin');
Route::get('/logout', 'AuthController@logout');

Route::get('/', function (){ return redirect()->action('Admin\IndexController@index');});
Route::group(['namespace'=>'Admin','prefix'=>'admin',"middleware"=>"auth:1"],function(){
    Route::get('/', function (){ return redirect()->action('Admin\IndexController@index');});
    Route::get('/index', 'IndexController@index');

    //员工
    Route::get('/staff', 'IndexController@getStaff');
    Route::post('/getStaffDetail/{id}', 'IndexController@getStaffDetail');
    Route::post('/addStaff', 'IndexController@addStaff');
    Route::post('/delStaff/{id}', 'IndexController@delStaff');
    Route::post('/updateStaff/{id}', 'IndexController@updateStaff');

    //绩效
    Route::post('/generatePerformance', 'IndexController@generatePerformance');

    //职位
    Route::get('/position', 'IndexController@getPosition');
    Route::post('/addPosition', 'IndexController@addPosition');
    Route::post('/updatePosition', 'IndexController@updatePosition');
    Route::post('/delPosition', 'IndexController@delPosition');



});