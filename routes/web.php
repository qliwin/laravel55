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

// Route::get('/', function () {
//    return view('welcome');
// });

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

//定义用户资源路由
Route::resource('users', 'UsersController');
//等同于如下代码
// Route::get('/users', 'UsersController@index')->name('users.index');         // 显示所有用户列表的页面
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');    // 显示用户个人信息的页面
// Route::get('/users/create', 'UsersController@create')->name('users.create');// 创建用户的页面
// Route::post('/users', 'UsersController@store')->name('users.store');        // 创建用户行为
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit'); // 编辑用户个人资料的页面
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update'); // 更新用户
// Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy'); // 删除用户

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store')->name('login');
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

Route::get('/test', 'Admin\TestsController@test')->name('test');
