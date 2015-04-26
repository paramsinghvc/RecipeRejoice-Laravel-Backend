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

Route::get('/', function () {
	return View::make('hello');
});

Route::group(['prefix' => 'api'], function () {
	Route::post('recipe/img/{id}', 'RecipesController@uploadPhoto');
	Route::delete('recipe/img/{name}', 'RecipesController@deletePhoto');
	Route::resource('recipes', 'RecipesController');
	Route::resource('comments', 'CommentsController');
});