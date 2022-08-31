<?php

namespace Bukin\ProductsPackage\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Bukin\ProductsPackage\Presentation\Console\Commands\SetupCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
    }

    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(
            [
                SetupCommand::class,
            ]
        );
    }

    protected function registerPublishes(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/jsonapi.php', 'jsonapi.servers.api.jsonapi'
        );
    }
}
