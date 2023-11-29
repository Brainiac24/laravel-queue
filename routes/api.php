<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    //Route::post('/exchange/callback', ['as' => 'exchange', 'uses' => 'ExchangeController@testCallback']);
    Route::post('/exchange', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/callback/abs', ['as' => 'exchange', 'uses' => 'TestController@Callback']);
    //Route::post('/callback/rucard', ['as' => 'exchange', 'uses' => 'TestController@callbackRucard']);
    //Route::post('/cards/list', ['as' => 'exchange', 'uses' => 'TestController@cardList']);
    //Route::get('/rucard/fill', ['as' => 'exchange', 'uses' => 'TestController@rucardFill']);
});

Route::group(['prefix' => 'v2'], function () {
    
    Route::post('/exchange', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/test', ['as' => 'exchange', 'uses' => 'TestController@testRucard']);
    Route::post('/exchange/testseq', ['as' => 'exchange', 'uses' => 'ExchangeController@testLogSenderSeq']);
    Route::post('/callback/abs', ['as' => 'exchange', 'uses' => 'BusProxyController@Callback']);
    Route::post('/callback/rucard', ['as' => 'exchange', 'uses' => 'TestController@callbackRucard']);
    /*Route::post('/exchange/card_fill', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_cancel', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_confirm', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_2_card', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_check_balance', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_history', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_lock_unlock', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);
    Route::post('/exchange/card_pay', ['as' => 'exchange', 'uses' => 'ExchangeController@store']);*/
   
});