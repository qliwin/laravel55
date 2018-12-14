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
Route::get('/test', function(){

    $average = collect([['foo' => 10], ['foo' => 10], ['foo' => 20], ['foo' => 40]])->avg('foo');
    dd($average);
});
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

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// 找回密码页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 发送邮件
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// 重置页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 重置更新
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 微博
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
// 用户的关注人列表
Route::get('users/{user}/followings', 'UsersController@followings')->name('users.followings');
// 显示用户的粉丝列表
Route::get('users/{user}/followers', 'UsersController@followers')->name('users.followers');
// 关注
Route::post('users/followers/{user}', 'FollowersController@store')->name('followers.store');
Route::delete('users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');