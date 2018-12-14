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

Route::get('/', function () {
    return view('welcome');
});

//文件上传接口，前后台共用
Route::post('uploadImg', 'PublicController@uploadImg')->name('uploadImg');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
