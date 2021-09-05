<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListingsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\MemberController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('admin/auth/')->group(function () {
    Route::post('login', [AdminAuthController::class, "login"]);
});


Route::prefix('/auth')->group(function () {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);
    Route::post('{provider}/register', [AuthController::class, "socialResgister"]);
    Route::post('{provider}/login', [AuthController::class, "socialLogin"]);
});


Route::prefix('users')
    //->middleware("role:super-administrator,administrator")
    ->group(function () {
        Route::get('/', [AdminController::class, 'getAll']);
        Route::get('/search', [AdminController::class, "search"]);
        Route::get('{userCode}', [AdminController::class, 'getOne']);
        //->middleware("ability:get-users");
        Route::post('/', [AdminController::class, 'create']);
        Route::patch('{userCode}', [AdminController::class, 'update']);
        //Route::post('{userId}/appovals', [AdminController::class, 'approveAdminUser']);
});

Route::prefix('/members')->group(function () {
    Route::get('/', [MemberController::class, 'getAll']);
    Route::get('search', [MemberController::class, 'search']);
    Route::get('{memberCode}', [MemberController::class, 'getOne']);
    // Route::post('/', [PermissionController::class, 'create']);
    Route::patch('{memberCode}', [MemberController::class, 'update']);
});

Route::prefix('/listings')->group(function () {
    Route::get('/', [ListingsController::class, "getAll"]);
    Route::get('/search', [ListingsController::class, "search"]);
    Route::get('{listingSlug}', [ListingsController::class, "getOne"]);
    Route::post('/', [ListingsController::class, "create"]);
    Route::patch('{listingReferenceId}', [ListingsController::class, "updateOne"]);
    Route::delete('{listingReferenceId}', [ListingsController::class, "deleteOne"]);
    Route::post('uploads/images', [ListingsController::class, "uploadImage"]);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoriesController::class, "getAll"]);
    Route::get('search', [CategoriesController::class, "search"]);
    Route::get('{categoryId}', [CategoriesController::class, "getOne"]);

    Route::post('/', [CategoriesController::class, "create"]);
    Route::patch('{categoryId}', [CategoriesController::class, "updateOne"]);
    Route::delete('{categoryId}', [CategoriesController::class, "deleteOne"]);
});

Route::prefix('/brands')->group(function () {
    Route::get('/', [BrandsController::class, "getAll"]);
    Route::post('/', [BrandsController::class, "create"]);
    Route::get('search', [BrandsController::class, "search"]);
    Route::get('{brandCode}', [BrandsController::class, "getOne"]);
    Route::patch('{brandCode}', [BrandsController::class, "updateOne"]);
    Route::delete('{brandCode}', [BrandsController::class, "deleteOne"]);
});

Route::prefix('/pricing-options')->group(function () {
    Route::get('/', [PricingOptionsController::class, "getAll"]);
    Route::post('/', [PricingOptionsController::class, "create"]);
    Route::get('{pricingId}', [PricingOptionsController::class, "getOne"]);
    Route::patch('{pricingId}', [PricingOptionsController::class, "updateOne"]);
    Route::delete('{pricingId}', [PricingOptionsController::class, "deleteOne"]);
});

Route::prefix('/uploads')->group(function () {
    Route::post('images', [UploadsController::class, "uploadImage"]);
});

Route::prefix('/permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'getAll']);
    Route::get('search', [PermissionController::class, 'search']);
    Route::get('{permissionCode}', [PermissionController::class, 'getOne']);
    Route::post('/', [PermissionController::class, 'create']);
    Route::patch('{permissionCode}', [PermissionController::class, 'update']);
});

Route::prefix('/roles')->group(function () {
    Route::get('/', [RoleController::class, 'getAll']);
    Route::get('search', [RoleController::class, 'search']);
    Route::get('{roleCode}', [RoleController::class, 'getOne']);
    Route::post('/', [RoleController::class, 'create']);
    Route::patch('{roleCode}', [RoleController::class, 'update']);
});
