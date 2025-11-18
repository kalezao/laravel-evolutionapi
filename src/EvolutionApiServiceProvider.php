<?php

declare(strict_types=1);

namespace Kalezao\EvolutionApi;

use Illuminate\Support\ServiceProvider;
use Kalezao\EvolutionApi\Contracts\EvolutionApiInterface;
use Kalezao\EvolutionApi\Services\EvolutionApiService;

final class EvolutionApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/evolution-api.php',
            'evolution-api'
        );

        $this->app->singleton(EvolutionApiService::class, function ($app) {
            return new EvolutionApiService(
                config('evolution-api.base_url'),
                config('evolution-api.api_key'),
                (int) config('evolution-api.timeout', 30)
            );
        });

        $this->app->bind(EvolutionApiInterface::class, function ($app) {
            return $app->make(EvolutionApiService::class);
        });

        $this->app->alias(EvolutionApiService::class, 'evolution-api');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/evolution-api.php' => config_path('evolution-api.php'),
            ], 'evolution-api-config');
        }
    }
}
