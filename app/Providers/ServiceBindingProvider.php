<?php

namespace App\Providers;

use App\Services\BannerService;
use App\Contracts\BannerContract;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BannerContract::class , BannerService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
