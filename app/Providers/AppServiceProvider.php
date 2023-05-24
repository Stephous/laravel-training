<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RateService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RateService::class, function ($app) {
            $url = config('app.api_url');
            return new RateService($url);
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
