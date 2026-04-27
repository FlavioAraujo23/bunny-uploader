<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BunnyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    $this->app->singleton(BunnyServiceProvider::class, function ($app) {
        return new BunnyServiceProvider([
            'api_key' => config('bunny.api_key'),
            'library_educacao_digital_id' => config('bunny.library_educacao_digital_id'),
        ]);
    });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}