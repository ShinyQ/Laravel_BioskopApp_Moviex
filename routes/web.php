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

Route::get('/home', 'HomeController@index');

Route::prefix('genre')->group(function(){
    Route::get('/', 'GenresController@index');
    Route::get('{id}', 'GenresController@show');
    Route::get('delete/{id}', 'GenresController@destroy');
    Route::post('/', 'GenresController@store');
    Route::put('{id}', 'GenresController@update');
});

Route::prefix('studio')->group(function(){
    Route::get('/', 'StudiosController@index');
    Route::get('{id}', 'StudiosController@show');
    Route::get('{id}', 'StudiosController@delete');
    Route::post('/', 'StudiosController@store');
    Route::put('/', 'StudiosController@update');
});

Route::prefix('film')->group(function(){
    Route::get('/', 'FilmsController@index');
    Route::get('{id}', 'FilmsController@show');
    Route::get('{id}', 'FilmsController@delete');
    Route::post('/', 'FilmsController@store');
    Route::put('/', 'FilmsController@update');
});

Route::prefix('order')->group(function(){
    Route::get('/', 'OrdersController@index');
    Route::get('{id}', 'OrdersController@show');
    Route::get('{id}', 'OrdersController@delete');
    Route::post('/', 'OrdersController@store');
    Route::put('/', 'OrdersController@update');
});
