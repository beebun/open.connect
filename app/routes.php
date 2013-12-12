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


Route::get('/login', "HomeController@sign_in");
Route::get('/', "HomeController@index");
Route::get('/user', "HomeController@user");
Route::get('/keyword', "HomeController@keyword");
Route::get('/mutual_interests/{fid1}/{fid2}', "HomeController@mutual_interests");


/*	UserController	*/
Route::get('/view/{fid}', "HomeController@view");
Route::get('/get_user_data/{fid}', "HomeController@get_user_data");

/*	KeywordController */
Route::get('/keyword', "KeywordController@index");
Route::get('/keyword/remove', "KeywordController@view_removed_tags");
Route::post('/keyword/remove_tag', "KeywordController@remove_tag");
Route::post('/keyword/add_tag', "KeywordController@add_tag");

Route::get('/keyword/{keyword}', "KeywordController@view");
Route::get('/count/{keyword}', "KeywordController@get_frequency");
Route::get('/test', "KeywordController@get_frequency_by_user");
Route::get('/keyword/graph/{keyword}',"KeywordController@view_keyword_graph");

Route::get('/home', "UserController@home");
Route::get('/sign_in', "UserController@sign_in");
Route::get('/sign_out', "UserController@sign_out");
Route::post('/fb_callback', "UserController@fb_callback");

Route::get('/me',"MeController@index");
Route::any('/edit_minimum_frequency',"MeController@edit_minimum_frequency");
