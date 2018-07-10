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

//Route::get('/', function () {
//    return view('welcome');
//});

//静态页面路由
//Route::请求方法('url', '控制器@方法名')
/*
    GET 常用于页面读取
    POST 常用于数据提交
    PATCH 常用于数据更新
    DELETE 常用于数据删除
*/
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//注册页面
Route::get('/signup', 'UsersController@create')->name('signup');
