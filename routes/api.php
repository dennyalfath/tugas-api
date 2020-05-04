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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::post('login', 'Api\UserController@login');
    Route::post('register', 'Api\UserController@register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('my-account', 'Api\UserController@myAccount');
    });

    Route::get('products', 'Api\ProductController@index');
    Route::post('products/store', 'Api\ProductController@store');
    Route::put('products/update', 'Api\ProductController@update');
    Route::delete('products/delete', 'Api\ProductController@destroy');
    Route::get('products/show/{id}', 'Api\ProductController@show');

    Route::get('category', 'Api\CategoryController@index');
    Route::post('category/store', 'Api\CategoryController@store');
    Route::put('category/update', 'Api\CategoryController@update');
    Route::delete('category/delete', 'Api\CategoryController@destroy');
    Route::get('category/show/{id}', 'Api\CategoryController@show');
});
