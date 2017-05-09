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

Auth::routes();

Route::get('/home', 'LotteryController@index')->name('home');

Route::post('/gifts','GiftController@insert');

//Route::get('/lottery/{vid}','LotteryController@index')->name('lottery_get');
//Route::post('/lottery','LotteryController@luck')->name('lottery_post');
Route::resource('lottery','LotteryController');
Route::post('/lottery/draw','LotteryController@draw')->name('lottery.draw');
Route::get('/lotteries/{id}','LotteryController@getAllGifts')->name('lottery.getAll');
Route::get('/lotteries/gifts/{id}','LotteryController@getCleanGifts')->name('lottery.getClean');
