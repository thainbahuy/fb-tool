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

Route::get('/', 'HomeController@showHomePage');
Route::get('/home', 'HomeController@showHomePage');

Route::get('/login','Auth\LoginController@showLoginForm');
Route::post('/login','Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/like', 'HomeController@executeLike');

Route::group(['middleware' => 'auth.api'], function()
{
    Route::post('account/add','HomeController@addNewAccount');
    Route::get('account/get-total','HomeController@getTotalUser');
    Route::get('post/get-total','HomeController@getTotalPostLiked');
    Route::get('post/get-list-recent-actions','HomeController@getListRecentAction');
});
