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

use Illuminate\Support\Facades\Route;

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace'=>'Api'], function () {
    Route::group(['namespace'=>'Auth'], function () {
        Route::post('/register', ['uses' => 'RegisterController@register', 'as' => 'api_register']);
        Route::post('/login', ['uses' => 'LoginController@login', 'as' => 'api_login']);
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::prefix('/movies')->group(function () {
            Route::get('/', 'MovieController@index')->name('api_movie_index');
            Route::post('/', 'MovieController@store')->name('api_movie_store');
            Route::get('/{movie}', 'MovieController@show')->name('api_movie_show')
                ->middleware('can:api-movie-show,movie');
            Route::patch('/{movie}', 'MovieController@update')->name('api_movie_update')
                ->middleware('can:api-movie-update,movie');
            Route::delete('/{movie}', 'MovieController@destroy')->name('api_movie_delete')
                ->middleware('can:api-movie-delete,movie');
        });
    });
});
