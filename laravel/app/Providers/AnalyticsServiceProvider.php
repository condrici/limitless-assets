<?php

namespace App\Providers;

use App\Http\Client\HttpClient;
use App\Http\Services\AnalyticsHttpService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use GuzzleHttp\Client as GuzzleHttpClient;

class AnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AnalyticsHttpService::class, function (Application $app) {
            return new AnalyticsHttpService(
                new HttpClient(new GuzzleHttpClient())
            );
        });

        $this->app->bind("App\Http\Client\HttpClientInterface", "App\Http\Client\HttpClient");
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
