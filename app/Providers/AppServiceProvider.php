<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PostCacheService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PostCacheService::class, function ($app) {
            return new PostCacheService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
