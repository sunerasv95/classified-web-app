<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\BoardDetailsRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ListingRepository;
use App\Repositories\ListingImageRepository;
use App\Repositories\PricingOptionRepository;
use App\Repositories\UserRepository;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\BoardDetailsRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ListingImageRepositoryInterface;
use App\Repositories\Contracts\ListingRepositoryInterface;
use App\Repositories\Contracts\PricingOptionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ListingRepositoryInterface::class, ListingRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(PricingOptionRepositoryInterface::class, PricingOptionRepository::class);
        $this->app->bind(ListingImageRepositoryInterface::class, ListingImageRepository::class);
        $this->app->bind(BoardDetailsRepositoryInterface::class, BoardDetailsRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

    }
}
