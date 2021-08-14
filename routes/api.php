<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PricingOptionsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadsController;
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

/*****************************************
 * ************ ADMIN ROUTES *************
*/
Route::prefix('admin/auth/')->group(function(){
    Route::post('login', [AdminAuthController::class, "login"]);
});

// Route::prefix('/admin')->middleware(["client"])->group(function(){
Route::prefix('admin')
//->middleware(["auth:api-admin"])
->group(function () {
    Route::prefix('users')
    //->middleware("role:super-administrator,administrator")
    ->group(function () {
        Route::get('/', [AdminController::class, 'getAll']);
        Route::get('{userCode}', [AdminController::class, 'getOne']);
        //->middleware("ability:get-users");
        Route::post('/', [AdminController::class, 'create']);
        //Route::post('{userId}/appovals', [AdminController::class, 'approveAdminUser']);
    });
});

/*****************************************
 * ************ MEMBER ROUTES *************
*/

Route::prefix('/auth')->group(function(){
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);
    Route::post('{provider}/register', [AuthController::class, "socialResgister"]);
    Route::post('{provider}/login', [AuthController::class, "socialLogin"]);
});


/*****************************************
 * ************ COMMON RESOUCES ROUTES ***
*/

Route::prefix('/listings')->group(function () {
    Route::get('/', [ListingsController::class ,"getAll"]);
    Route::post('/', [ListingsController::class, "create"]);
    Route::get('{listingId}', [ListingsController::class, "getOne"]);
    Route::put('{listingId}', [ListingsController::class, "updateOne"]);
    Route::delete('{listingId}', [ListingsController::class, "deleteOne"]);
    Route::post('uploads/images', [ListingsController::class, "uploadImage"]);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoriesController::class, "getAll"]);
    Route::get('/search', [CategoriesController::class, "search"]);
    Route::get('{categoryId}', [CategoriesController::class, "getOne"]);

    Route::post('/', [CategoriesController::class, "create"]);
    Route::put('{categoryId}', [CategoriesController::class, "updateOne"]);
    Route::delete('{categoryId}', [CategoriesController::class, "deleteOne"]);

});

Route::prefix('/brands')->group(function () {
    Route::get('/', [BrandsController::class, "getAll"]);
    Route::post('/', [BrandsController::class, "create"]);
    Route::get('{brandId}', [BrandsController::class, "getOne"]);
    Route::put('{brandId}', [BrandsController::class, "updateOne"]);
    Route::delete('{brandId}', [BrandsController::class, "deleteOne"]);
});

Route::prefix('/pricing-options')->group(function () {
    Route::get('/', [PricingOptionsController::class, "getAll"]);
    Route::post('/', [PricingOptionsController::class, "create"]);
    Route::get('{pricingId}', [PricingOptionsController::class, "getOne"]);
    Route::put('{pricingId}', [PricingOptionsController::class, "updateOne"]);
    Route::delete('{pricingId}', [PricingOptionsController::class, "deleteOne"]);
});

Route::prefix('/uploads')->group(function () {
    Route::post('images', [UploadsController::class, "uploadImage"]);
});

Route::prefix('/permissions')->group(function(){
    Route::get('/', [PermissionController::class, 'getAll']);
    Route::post('/', [PermissionController::class, 'create']);
    Route::put('{permissionId}', [PermissionController::class, 'update']);
    Route::get('{permissionId}', [PermissionController::class, 'getOne']);
});

Route::prefix('/roles')->group(function(){
    Route::get('/', [RoleController::class, 'getAll']);
    Route::post('/', [RoleController::class, 'create']);
    Route::put('{roleId}', [RoleController::class, 'update']);
    Route::get('{roleId}', [RoleController::class, 'getOne']);
});

