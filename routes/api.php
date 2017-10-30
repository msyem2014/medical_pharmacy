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
Route::get('special', 'AuthController@special');
Route::get('chats','ChatsController@getChats');
Route::post('search-build','BuildController@search');
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('check_like','FavouriteController@checkLike');
Route::post('send-message','ChatsController@sendMessage');
Route::get('get-messages','ChatsController@getMessages');
Route::get('get-notifications','notificationsController@getNotifications');
Route::get('get-notifications-count','notificationsController@getNotificationsCount');
Route::get('user', 'AuthController@user');
Route::post('search', 'AuthController@search');
Route::get('view-user','AuthController@viewUser');
Route::resource('post', 'PostController');
Route::resource('favourite', 'FavouriteController');
Route::resource('comment', 'CommentController');
