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
Route::group(['namespace'=>'Admin','prefix'=>'admin',"middleware"=>"auth:1"],function($router){
    Route::get('/', function (){ return redirect()->action('Admin\IndexController@index');});
    Route::get('/index', 'IndexController@index');

    Route::get('/get', 'AdminController@get');

    Route::group(['prefix'=>'powerGroup'],function(){
        Route::get("/detail/{id}","PowerController@detail");

        Route::get("/get","PowerController@get");
        Route::post("/add","PowerController@add");
        Route::get("/del","PowerController@del");
        Route::post("/update","PowerController@update");

        Route::get("/permit","PowerController@getAllPermit");
    });

});

Route::group(['namespace'=>'Goods','prefix'=>'goods',"middleware"=>"auth:1"],function($router){
    Route::get('/', function (){ return redirect()->action('Goods\IndexController@index');});
    Route::get('/index', 'IndexController@index');


    Route::group(['prefix'=>'goods'],function(){
        Route::get("/get","GoodsController@get");
        Route::get("/detail","GoodsController@detail");
        Route::get("/appear","GoodsController@appear");

    });
    Route::group(['prefix'=>'shop'],function(){
        Route::get("/detail","ShopController@detail");
        Route::get("/update","ShopController@update");
    });
    Route::group(['prefix'=>'monitor'],function(){
        Route::get("/get","MonitorController@get");
        Route::get("/detail","MonitorController@detail");

        Route::post("/add","MonitorController@add");
    });


});