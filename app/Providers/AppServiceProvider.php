<?php

namespace App\Providers;

use App\StaticData\CurrencyExchangeRateInterface;
use App\StaticData\CurrencyExchangeRateNormal;

use App\Services\CurrencyExchangeServiceInterface;
use App\Services\CurrencyExchangeService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CurrencyExchangeRateInterface::class,
            CurrencyExchangeRateNormal::class
        );

        $this->app->singleton(
            CurrencyExchangeServiceInterface::class,
            CurrencyExchangeService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
