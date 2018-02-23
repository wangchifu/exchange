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

Route::get('/', 'HomeController@index')->name('index');

//Auth::routes();
//登入/登出
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('login/refereshcapcha', 'Auth\LoginController@refereshcapcha');




//管理者
Route::group(['middleware' => 'admin'],function(){
    Route::get('admin', 'HomeController@admin')->name('admin');
});

//登入會員
Route::group(['middleware' => 'auth'],function() {
    Route::get('home', 'HomeController@home')->name('home');
});
