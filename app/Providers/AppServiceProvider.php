<?php

namespace App\Providers;

use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Product\ProductRepositoryImplementation;
use App\Http\Repositories\Review\ReviewRepository;
use App\Http\Repositories\User\UserRepository;
use App\Http\Repositories\User\UserRepositoryImplementation;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Product\ProductServiceImplementation;
use App\Http\Services\Review\ReviewService;
use App\Http\Services\Review\ReviewServiceImplementation;
use App\Models\Review;
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
        $this->app->bind(ProductRepository::class,ProductRepositoryImplementation::class);
        $this->app->bind(ProductService::class,ProductServiceImplementation::class);
        $this->app->bind(UserRepository::class,UserRepositoryImplementation::class);
        $this->app->bind(ReviewService::class,ReviewServiceImplementation::class);
        $this->app->bind(ReviewRepository::class,ReviewServiceImplementation::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
