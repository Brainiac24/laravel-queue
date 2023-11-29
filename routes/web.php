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

Route::get('/phpinfo', ['as' => 'test', 'uses' => 'TestController@php_info']);
//Route::get('/search-card', ['as' => 'test', 'uses' => 'TestController@searchCard']);