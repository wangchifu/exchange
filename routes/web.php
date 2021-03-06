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
Route::get('forgetPW', 'Auth\LoginController@forgetPW')->name('forgetPW');
Route::get('download_pdf', 'Auth\LoginController@download_pdf')->name('download_pdf');
Route::post('upload_pic', 'Auth\LoginController@upload_pic')->name('upload_pic');
Route::get('forgetPW/{page}', 'Auth\LoginController@forgetPW_show')->name('forgetPW_show');
Route::get('pic/{pic}',function($pic){
    $path = storage_path('app/public/applications/') . $pic;
    $file = \Illuminate\Support\Facades\File::get($path);
    $type = \Illuminate\Support\Facades\File::mimeType($path);
    $response = \Illuminate\Support\Facades\Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

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
    Route::get('system/user/{user}/default/{pw}', 'AdminController@user_default')->name('system.user_default');
    Route::get('system/user/{user}/delete', 'AdminController@user_delete')->name('system.user_delete');
    Route::get('system/user/{user}/setAdmin', 'AdminController@setAdmin')->name('system.user_setAdmin');
    Route::get('system/user/{user}/disAdmin', 'AdminController@disAdmin')->name('system.user_disAdmin');

    Route::get('system/group', 'AdminController@group')->name('system.group');
    Route::post('system/group/store', 'AdminController@group_store')->name('system.group_store');
    Route::patch('system/group/{group}', 'AdminController@group_update')->name('system.group_update');
    Route::get('system/group/{group}/delete', 'AdminController@group_delete')->name('system.group_delete');

    Route::get('system/application', 'AdminController@application')->name('system.application');


    Route::get('system/application/view/{pic}', 'AdminController@application_view')->name('system.application_view');
    Route::post('system/application/update', 'AdminController@application_update')->name('system.application_update');
    Route::get('system/application/{application}/delete', 'AdminController@application_delete')->name('system.application_delete');
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

    //Route::get('posts/' , 'AdminController@index')->name('posts.index');
    Route::get('posts/create' , 'AdminController@post_create')->name('post.create');
    Route::post('posts' , 'AdminController@post_store')->name('post.store');
    Route::get('posts/{post}', 'AdminController@post_destroy')->name('post.destroy');

});


//登入會員
Route::group(['middleware' => 'auth'],function() {
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('change_pass', 'HomeController@change_pass')->name('change_pass');
    Route::get('about', 'HomeController@about')->name('about');
    Route::get('upload_publickey', 'HomeController@upload_publickey')->name('upload_publickey');
    Route::post('store_publickey', 'HomeController@store_publickey')->name('store_publickey');
    Route::post('delete_publickey/{user}', 'HomeController@delete_publickey')->name('delete_publickey');

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

    Route::get('inbox', 'ChangeController@inbox')->name('inbox');
    Route::post('inbox/{change}', 'ChangeController@inbox_download')->name('inbox_download');
    Route::post('outbox', 'ChangeController@outbox_store')->name('outbox_store');
    Route::get('outbox', 'ChangeController@outbox')->name('outbox');

    Route::get('posts/show/{post}' , 'AdminController@post_show')->name('post.show');

});
