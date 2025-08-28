<?php

namespace Wavius\WhatsApp;

use Illuminate\Support\ServiceProvider;
use Wavius\WhatsApp\Config\WaviusConfig;
use Wavius\WhatsApp\Contracts\WaviusClientInterface;
use Wavius\WhatsApp\Services\WaviusClient;
use Wavius\WhatsApp\Services\WaviusService;

/**
 * Wavius Service Provider
 * 
 * Main service provider for the Wavius WhatsApp Laravel SDK.
 * Handles package registration, configuration, and service bindings.
 */
class WaviusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/wavius.php', 'wavius'
        );

        // Bind the Wavius client interface to its implementation
        $this->app->bind(WaviusClientInterface::class, WaviusClient::class);

        // Bind the main Wavius service
        $this->app->singleton(WaviusService::class, function ($app) {
            return new WaviusService(
                $app->make(WaviusClientInterface::class),
                $app->make(WaviusConfig::class)
            );
        });

        // Bind the facade
        $this->app->singleton('wavius', function ($app) {
            return $app->make(WaviusService::class);
        });

        // Bind the configuration class
        $this->app->singleton(WaviusConfig::class, function ($app) {
            return new WaviusConfig($app['config']->get('wavius'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/wavius.php' => config_path('wavius.php'),
            ], 'wavius-config');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            WaviusService::class,
            WaviusClientInterface::class,
            WaviusConfig::class,
        ];
    }
}
