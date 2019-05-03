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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

  Route::post('register','Auth\RegisterController@register');
  Route::post('login','Auth\LoginController@login');
  Route::get('logout','Auth\LoginController@logout');


  Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user','Auth\UserController@detail');

    Route::prefix('v1')->group(function(){
      Route::apiResource("genre", "Api\GenresController");
      Route::apiResource("studio", "Api\StudioController");
    });
  });
