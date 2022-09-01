<?php

namespace Bukin\ProductsPackage\Products\Infrastructure\Providers;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Bukin\ProductsPackage\Products\Presentation\Console\Commands\SetupCommand;
use Bukin\ProductsPackage\Products\Presentation\Console\Commands\ShowProductsCommand;
use Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public array $bindings = [
        ProductModelContract::class => ProductModel::class
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
                ShowProductsCommand::class,
            ]
        );
    }

    protected function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../../../database/migrations/create_products_package_products_tables.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_products_package_products_tables.php'),
        ], 'migrations');
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../../routes/api.php');
    }

    protected function registerPolicies(): void
    {
        $model = resolve(ProductModelContract::class);

        Gate::policy($model::class, ProductPolicy::class);
    }
}
