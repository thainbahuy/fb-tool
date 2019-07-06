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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('account/add','HomeController@addNewAccount');
Route::get('account/get-total','HomeController@getTotalUser');
Route::get('post/get-total','HomeController@getTotalPostLiked');
Route::get('post/get-list-recent-actions','HomeController@getListRecentAction');


Route::post('authentication/login','Auth\LoginController@login');
