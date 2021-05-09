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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/listings')->group(function () {
    Route::get('/', "ListingsController@getAll");
    Route::get('{listingId}', "ListingsController@getOne");
    Route::post('/', "ListingsController@create");
    Route::put('{listingId}', "ListingsController@updateOne");
    Route::delete('{listingId}', "ListingsController@deleteOne");
});

Route::prefix('/categories')->group(function () {
    Route::get('/', "CategoriesController@getAll");
    Route::get('{categoryId}', "CategoriesController@getOne");
    Route::post('/', "CategoriesController@create");
    Route::put('{categoryId}', "CategoriesController@updateOne");
    Route::delete('{categoryId}', "CategoriesController@deleteOne");
});

Route::prefix('/brands')->group(function () {
    Route::get('/', "BrandsController@getAll");
    Route::get('{brandId}', "BrandsController@getOne");
    Route::post('/', "BrandsController@create");
    Route::put('{brandId}', "BrandsController@updateOne");
    Route::delete('{brandId}', "BrandsController@deleteOne");
});

Route::prefix('/pricing-options')->group(function () {
    Route::get('/', "PricingOptionsController@getAll");
    Route::get('{pricingId}', "PricingOptionsController@getOne");
    Route::post('/', "PricingOptionsController@create");
    Route::put('{pricingId}', "PricingOptionsController@updateOne");
    Route::delete('{pricingId}', "PricingOptionsController@deleteOne");
});


