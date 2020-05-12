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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup');
Route::resource('/users','UsersController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//由于微博这边只需要添加与删除 所以我们限定资源路由
Route::resource('statuses', 'StatusesController', ['only' => ['store' ,'destroy']]);
Route::get('test','UsersController@test');
//关注列表与粉丝列表
Route::get('/users/{user}/following' , 'UsersController@following')->name('user.following');
Route::get('/users/{user}/followers' , 'UsersController@followers')->name('user.followers');
//允许用户关注与取消关注
Route::post('/users/followers/{user}','FollowersController@store')->name('followers.add');
Route::delete('/users/followers/{user}','FollowersController@destroy')->name('followers.delete');
Route::get('/test-sql', function() {

    DB::enableQueryLog();
    $user_ids=[1,2,3,4,5];
    $user = App\Models\Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc');
    return response()->json(DB::getQueryLog());
});
