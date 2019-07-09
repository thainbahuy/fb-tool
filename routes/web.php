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
// fb
//Route::get('/auth/redirect/{provider}', 'HomeController@redirect');
//Route::get('/callback/{provider}', 'HomeController@callback');

//web
Route::get('/', 'HomeController@showHomePage');
Route::get('/home', 'HomeController@showHomePage');
Route::get('/user', 'HomeController@showUserPage');

Route::get('/login','Auth\LoginController@showLoginForm');
Route::post('/login','Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');


//vuejs
Route::group(['middleware' => 'auth.api'], function()
{
    Route::post('account/add','HomeController@addNewAccount');
    Route::get('account/get-total','HomeController@getTotalUser');
    Route::get('post/get-total','HomeController@getTotalPostLiked');
    Route::get('post/get-list-recent-actions','HomeController@getListRecentAction');
});


// cron tab
Route::get('cron/like', 'HomeController@executeLike');
Route::get('cron/deleteAllPosts', 'HomeController@deleteAllPostLiked');
