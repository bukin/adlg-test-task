<?php

namespace Bukin\ProductsPackage\Products\Tests;

use Bukin\ProductsPackage\Products\Infrastructure\Providers\ServiceProvider as ProductsServiceProvider;
use Bukin\ProductsPackage\Vendors\Infrastructure\Providers\ServiceProvider as VendorsServiceProvider;
use Bukin\ProductsPackage\Infrastructure\Providers\ServiceProvider as PackageServiceProvider;
use LaravelJsonApi\Core\Facades\JsonApi;
use LaravelJsonApi\Encoder\Neomerx\ServiceProvider as LaravelJsonApiEncoderServiceProvider;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\ServiceProvider as LaravelJsonApiServiceProvider;
use LaravelJsonApi\Spec\ServiceProvider as LaravelJsonApiSpecServiceProvider;
use LaravelJsonApi\Validation\ServiceProvider as LaravelJsonApiValidationServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelJsonApiServiceProvider::class,
            LaravelJsonApiEncoderServiceProvider::class,
            LaravelJsonApiSpecServiceProvider::class,
            LaravelJsonApiValidationServiceProvider::class,
            PackageServiceProvider::class,
            VendorsServiceProvider::class,
            ProductsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'JsonApi' => JsonApi::class,
            'JsonApiRoute' => JsonApiRoute::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../../vendors/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:jXEV5lsYsDz/7LtvuEB/4psnit6zHTbFQ57eKSjoKkQ=');
        $app['config']->set('database.default', 'testing');
    }
}
