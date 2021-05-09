<?php

namespace App\Providers;

use App\Services\ListingsService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\Contracts\BrandServiceInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\ListingsServiceInterface;
use App\Services\Contracts\PricingOptionServiceInterface;
use App\Services\PricingOptionService;
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
        $this->app->bind(ListingsServiceInterface::class, ListingsService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(PricingOptionServiceInterface::class, PricingOptionService::class);

    }
}
