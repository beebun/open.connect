<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', "HomeController@index");
Route::get('/user', "HomeController@user");
Route::get('/keyword', "HomeController@keyword");

Route::get('users', function()
{
    return 'Users!';
});

/*	UserController	*/
Route::get('/view/{fid}', "HomeController@view");
Route::get('/get_user_data/{fid}', "HomeController@get_user_data");

/*	KeywordController */
Route::get('/keyword', "KeywordController@index");
Route::get('/keyword/{keyword}', "KeywordController@view");
Route::get('/count/{keyword}', "KeywordController@get_frequency");
Route::get('/test', "KeywordController@get_frequency_by_user");
Route::get('/keyword/graph/{keyword}',"KeywordController@view_keyword_graph");
