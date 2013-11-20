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

Route::get('/view/{fid}', "HomeController@view");
Route::get('/get_user_data/{fid}', "HomeController@get_user_data");
Route::get('/view_keyword/{view_keyword}', "HomeController@view_keyword");