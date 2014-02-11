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
Route::get('/logout', "UserController@sign_out");
Route::get('/', "HomeController@index");
Route::get('/user', "HomeController@user");
Route::get('/cluster', "HomeController@view_cluster");
Route::get('/mutual_interests/{fid1}/{fid2}', "HomeController@mutual_interests");
Route::any('/save_news_feed', "NewsFeedController@save_news_feed");


/*	UserController	*/
Route::get('/view/{fid}', "HomeController@view");
Route::get('/get_user_data/{fid}', "HomeController@get_user_data");

/*	KeywordController */
Route::get('/keyword', "KeywordController@index");
Route::get('/keyword/remove', "KeywordController@view_removed_tags");
Route::any('/keyword/remove_tag', "KeywordController@remove_tag");
Route::post('/keyword/add_tag', "KeywordController@add_tag");

Route::get('/keyword/{keyword}', "KeywordController@view");
Route::get('/count/{keyword}', "KeywordController@get_frequency");
Route::get('/test', "KeywordController@test");
Route::get('/keyword/graph/{keyword}',"KeywordController@view_keyword_graph");

Route::get('/home', "UserController@home");
Route::get('/sign_in', "UserController@sign_in");
Route::get('/sign_out', "UserController@sign_out");
Route::post('/fb_callback', "UserController@fb_callback");

Route::get('/me',"MeController@index");
Route::any('/edit_minimum_frequency',"MeController@edit_minimum_frequency");
Route::any('/generate_keyword',"MeController@generate_keyword");
Route::any('/generate_keyword_rank',"MeController@generate_keyword_rank");


Route::any('/group',"GroupController@index");
Route::get('/group/create',"GroupController@create");
Route::post('/group/create',"GroupController@post_create");
Route::get('/group/view/{group_id}',"GroupController@view");
Route::get('/group/delete/{group_id}',"GroupController@delete");
Route::get('/group/add_to_group',"GroupController@add_to_group");
Route::post('/group/add_to_group',"GroupController@post_add_to_group");
