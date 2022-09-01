<?php

namespace Bukin\ProductsPackage\Vendors\Infrastructure\Providers;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Bukin\ProductsPackage\Vendors\Presentation\Console\Commands\SetupCommand;
use Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1\Policies\VendorPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public array $bindings = [
        VendorModelContract::class => VendorModel::class
    ];

    public function provides(): array
    {
        return array_keys($this->bindings);
    }

    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerPolicies();
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
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../../../database/migrations/create_products_package_vendors_tables.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_products_package_vendors_tables.php'),
        ], 'migrations');
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../../routes/api.php');
    }

    protected function registerPolicies(): void
    {
        $model = resolve(VendorModelContract::class);

        Gate::policy($model::class, VendorPolicy::class);
    }
}
