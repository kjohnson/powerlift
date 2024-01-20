<?php

namespace App\Providers;

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
        $this->app->singleton(
            abstract: 'kisi',
            concrete: fn () => new \App\Services\Kisi\Api(
                apiKey: strval(config('services.kisi.api_key')),
            ),
        );
    }
}
