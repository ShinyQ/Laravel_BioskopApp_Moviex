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

Route::get('/logout1', 'Auth\LoginController@dologout');
Route::get('/home', 'HomeController@index');
Route::get('/login', 'Auth\LoginController@index');
Route::get('/register', 'Auth\RegisterController@index');
Route::post('/login1', 'Auth\LoginController@doLogin');
Route::post('/register1', 'Auth\RegisterController@doRegister');

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
    Route::get('delete/{id}', 'StudiosController@destroy');
    Route::post('/', 'StudiosController@store');
    Route::put('{id}', 'StudiosController@update');
});

Route::prefix('film')->group(function(){
    Route::get('/', 'FilmsController@index');
    Route::get('{id}', 'FilmsController@show');
    Route::get('delete/{id}', 'FilmsController@destroy');
    Route::post('/', 'FilmsController@store');
    Route::put('{id}', 'FilmsController@update');
});

Route::prefix('order')->group(function(){
    Route::get('/', 'OrdersController@index');
    Route::get('detail/{id}', 'OrdersController@show');
    Route::get('{id}', 'OrdersController@edit');
    Route::get('delete/{id}', 'OrdersController@destroy');
    Route::post('/', 'OrdersController@store');
    Route::put('{id}', 'OrdersController@update');
});
