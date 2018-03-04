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




//最高管理者
Route::group(['middleware' => 'admin'],function(){
    Route::get('system/user', 'AdminController@user')->name('system.user');
    Route::post('system/user/store', 'AdminController@user_store')->name('system.user_store');
    Route::patch('system/user/{user}', 'AdminController@user_update')->name('system.user_update');
    Route::get('system/user/{user}/default', 'AdminController@user_default')->name('system.user_default');
    Route::get('system/user/{user}/delete', 'AdminController@user_delete')->name('system.user_delete');

    Route::get('system/group', 'AdminController@group')->name('system.group');
    Route::post('system/group/store', 'AdminController@group_store')->name('system.group_store');
    Route::patch('system/group/{group}', 'AdminController@group_update')->name('system.group_update');
    Route::get('system/group/{group}/delete', 'AdminController@group_delete')->name('system.group_delete');
});

//管理者
Route::group(['middleware' => 'group1'],function() {
    Route::get('system/action', 'AdminController@action')->name('system.action');
    Route::post('system/action', 'AdminController@action_store')->name('system.action_store');
    Route::delete('system/action/{action}', 'AdminController@action_destroy')->name('system.action_destroy');
    Route::patch('system/action/{action}',  'AdminController@action_update')->name('system.action_update');
    Route::get('system/show_upload/{action_id}',  'AdminController@show_upload')->name('system.show_upload');
    Route::get('system/download/{upload}',  'AdminController@download')->name('system.download');
    Route::get('system/downloadZip/{action}',  'AdminController@downloadZip')->name('system.downloadZip');
    Route::delete('system/delete_upload/{upload}',  'AdminController@delete_upload')->name('system.delete_upload');
    Route::post('system/show_one_upload', 'AdminController@show_one_upload')->name('system.show_one_upload');
});


//登入會員
Route::group(['middleware' => 'auth'],function() {
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('change_pass', 'HomeController@change_pass')->name('change_pass');
    Route::get('about', 'HomeController@about')->name('about');
    Route::get('contact', 'HomeController@contact')->name('contact');
    Route::get('upload_public', 'HomeController@upload_public')->name('upload_public');

    Route::patch('update_pass/{user}', 'HomeController@update_pass')->name('update_pass');

    Route::get('new_student', 'NewStudentController@index')->name('new_student.index');
    Route::post('new_student/upload', 'NewStudentController@upload')->name('new_student.upload');
    Route::post('new_student/do_upload/{action}',  'NewStudentController@do_upload')->name('new_student.do_upload');
    Route::post('new_student/show', 'NewStudentController@show')->name('new_student.show');
    Route::post('new_student/store',  'NewStudentController@store')->name('new_student.store');
    Route::get('new_student/download_sample', 'NewStudentController@download_sample')->name('new_student.download_sample');

    Route::get('other_action', 'OtherActionController@index')->name('other_action.index');
    Route::get('other_action/upload/{action}',  'OtherActionController@upload')->name('other_action.upload');
    Route::post('other_action/store',  'OtherActionController@store')->name('other_action.store');
    Route::get('other_action/download/{upload}',  'OtherActionController@download')->name('other_action.download');



});
