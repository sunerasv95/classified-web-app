<?php

namespace App\Providers;

use App\Services\CategoryService;
use app\Services\Contracts\CategoryServiceInterface;
use app\Services\Contracts\ListingsServiceInterface;
use App\Services\ListingsService;
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
    }
}
