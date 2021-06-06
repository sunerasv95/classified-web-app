<?php

namespace App\Providers;

use App\Models\AccessoriesDetails;
use App\Models\BoardDetails;
use App\Services\AdminAuthService;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\ListingsService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\Contracts\AdminAuthServiceInterface;
use App\Services\Contracts\AdminServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\BrandServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\FileServiceInterface;
use App\Services\Contracts\ListingImageServiceInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Services\Contracts\PermissionServiceInterface;
use App\Services\Contracts\PricingOptionServiceInterface;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\FileService;
use App\Services\ListingImageService;
use App\Services\PermissionService;
use App\Services\PricingOptionService;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //Admin
        $this->app->bind(AdminServiceInterface::class, AdminService::class);


        $this->app->bind(ListingsServiceInterface::class, ListingsService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(PricingOptionServiceInterface::class, PricingOptionService::class);
        $this->app->bind(ListingImageServiceInterface::class, ListingImageService::class);

        //Authentication
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AdminAuthServiceInterface::class, AdminAuthService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);

        //file service
        $this->app->bind(FileServiceInterface::class, FileService::class);

        Relation::morphMap([
            "BOARD_LISTING" => BoardDetails::class
        ]);
    }
}
