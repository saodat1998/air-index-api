<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



//----------------------------------
// Api
Route::group([
    //'middleware' => 'cors',
    'prefix'     => 'v1',
    'as'         => 'api.',
    'namespace'  => 'Api\\v1',
], function () {

    // Authentication & Password Reset
    Route::group([
        'prefix'     => 'auth',
        'namespace'  => 'Auth',
    ], function () {

        Route::post('/login', [
            'as'   => 'login',
            'uses' => 'AccessTokensController@store',
        ]);

        Route::post('/check', [
            'as'   => 'check',
            'uses' => 'AccessTokensController@check',
        ]);

        Route::get('/logout', [
            'as'   => 'logout',
            'uses' => 'AccessTokensController@destroy',
        ]);

        Route::post('/refresh_token', [
            'as'   => 'refresh_token',
            'uses' => 'AccessTokensController@update',
        ]);

        Route::post('/password/email', [
            'uses' => 'ForgotPasswordController@sendResetLinkEmail',
        ])->name('password.email');

        Route::post('/reset/password', [
            'uses' => 'ResetPasswordController@reset',
        ])->name('password.reset');

        Route::post('/is-registered', [
            'as'   => 'is-registered',
            'uses' => 'AccessTokensController@isRegistered',
        ]);

    });



    // Topic services
    Route::group([
        //'middleware' => 'auth:api',
        'prefix'     => 'countries',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'CountriesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'CountriesController@index',
        ]);

    });


    // Publisher
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'publishers',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'PublishersController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'PublishersController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'PublishersController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'PublishersController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'PublishersController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'PublishersController@destroy',
        ]);

    });

});
