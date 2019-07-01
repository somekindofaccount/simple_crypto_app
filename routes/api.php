<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'AuthController@issueToken');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/coinmarket_coins', 'Api\CoinMarketController@coins')->middleware('cache.fetch:coins_list', 'cache.put:coins_list,3600');
    Route::get('/get_user_coins', 'Api\CoinMarketController@getUserCoins');
    Route::post('/save_user_coin', 'Api\CoinMarketController@saveUserCoin');
});







