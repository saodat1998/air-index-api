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
        'middleware' => 'auth:api',
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


    // AqiCategories
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'aqi-categories',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'AqiCategoriesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'AqiCategoriesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'AqiCategoriesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'AqiCategoriesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'AqiCategoriesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'AqiCategoriesController@destroy',
        ]);

    });

    // Departments
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'departments',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'DepartmentsController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'DepartmentsController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'DepartmentsController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'DepartmentsController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'DepartmentsController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'DepartmentsController@destroy',
        ]);

    });

    // Regions
    Route::group([
        'prefix'     => 'regions',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'RegionsController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'RegionsController@index',
        ]);

        Route::post('/create', [
            'middleware' => 'auth:api',
            'as'   => 'create',
            'uses' => 'RegionsController@store',
        ]);

        Route::get('/{id}', [
            'middleware' => 'auth:api',
            'as'   => 'show',
            'uses' => 'RegionsController@show',
        ]);

        Route::post('/update/{id}', [
            'middleware' => 'auth:api',
            'as'   => 'update',
            'uses' => 'RegionsController@update',
        ]);

        Route::post('/delete/{id}', [
            'middleware' => 'auth:api',
            'as'   => 'delete',
            'uses' => 'RegionsController@destroy',
        ]);

    });

    // Employees
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'employees',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'EmployeesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'EmployeesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'EmployeesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'EmployeesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'EmployeesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'EmployeesController@destroy',
        ]);

    });

    // Research values
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'research-values',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'ResearchValuesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'ResearchValuesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'ResearchValuesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'ResearchValuesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'ResearchValuesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'ResearchValuesController@destroy',
        ]);

    });

    // Technical values
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'technical-values',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'TechnicalValuesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'TechnicalValuesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'TechnicalValuesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'TechnicalValuesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'TechnicalValuesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'TechnicalValuesController@destroy',
        ]);

    });

    // Statistics values
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'statistic-values',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'StatisticValuesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'StatisticValuesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'StatisticValuesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'StatisticValuesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'StatisticValuesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'StatisticValuesController@destroy',
        ]);

    });

    // Units
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'pollutants',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'PollutantsController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'PollutantsController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'PollutantsController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'PollutantsController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'PollutantsController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'PollutantsController@destroy',
        ]);

    });

    // Users
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'users',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'UsersController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'UsersController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'UsersController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'UsersController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'UsersController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'UsersController@destroy',
        ]);

    });

    // Resources
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'resources',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'ResourcesController@index',
        ]);

        Route::get('/index', [
            'as'   => 'index',
            'uses' => 'ResourcesController@index',
        ]);

        Route::post('/create', [
            'as'   => 'create',
            'uses' => 'ResourcesController@store',
        ]);

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'ResourcesController@show',
        ]);

        Route::post('/update/{id}', [
            'as'   => 'update',
            'uses' => 'ResourcesController@update',
        ]);

        Route::post('/delete/{id}', [
            'as'   => 'delete',
            'uses' => 'ResourcesController@destroy',
        ]);

    });

    // Resources
    Route::group([
        'prefix'     => 'dates',
    ], function () {

        Route::get('/', [
            'as'   => 'index',
            'uses' => 'DatesController@index',
        ]);

        Route::get('/statistics', [
            'as'   => 'statistics',
            'uses' => 'DatesController@statistics',
        ]);

        Route::get('/{date}', [
            'as'   => 'show',
            'uses' => 'DatesController@show',
        ]);

    });

});
