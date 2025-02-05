<?php

namespace App\Providers;

use App\Repository\Meta\MetaRepository;
use App\Repository\Meta\MetaRepositoryInterface;
use App\Repository\Post\PostRepository;
use App\Repository\Post\PostRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView("vendor.pagination.bootstrap-5");
        $this->app->bind(MetaRepositoryInterface::class, MetaRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }
}
