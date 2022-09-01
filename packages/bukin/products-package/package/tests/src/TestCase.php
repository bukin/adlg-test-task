<?php

namespace Bukin\ProductsPackage\Tests;

use Bukin\ProductsPackage\Infrastructure\Providers\ServiceProvider as PackageServiceProvider;
use Bukin\ProductsPackage\Products\Infrastructure\Providers\ServiceProvider as ProductsServiceProvider;
use Bukin\ProductsPackage\Vendors\Infrastructure\Providers\ServiceProvider as VendorsServiceProvider;
use Illuminate\Support\Facades\Config;
use InetStudio\ACL\Permissions\Providers\BindingsServiceProvider as AclPermissionsBindingsServiceProvider;
use InetStudio\ACL\Permissions\Providers\ServiceProvider as AclPermissionsServiceProvider;
use InetStudio\ACL\Providers\BindingsServiceProvider as AclBindingsServiceProvider;
use InetStudio\ACL\Providers\ServiceProvider as AclServiceProvider;
use InetStudio\ACL\Roles\Providers\BindingsServiceProvider as AclRolesBindingsServiceProvider;
use InetStudio\ACL\Roles\Providers\ServiceProvider as AclRolesServiceProvider;
use InetStudio\ACL\Users\Models\UserModel;
use InetStudio\ACL\Users\Providers\BindingsServiceProvider as AclUsersBindingsServiceProvider;
use InetStudio\ACL\Users\Providers\ServiceProvider as AclUsersServiceProvider;
use Laratrust\LaratrustServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\SanctumServiceProvider;
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
            AclBindingsServiceProvider::class,
            AclServiceProvider::class,
            AclUsersBindingsServiceProvider::class,
            AclUsersServiceProvider::class,
            AclPermissionsBindingsServiceProvider::class,
            AclPermissionsServiceProvider::class,
            AclRolesBindingsServiceProvider::class,
            AclRolesServiceProvider::class,
            LaratrustServiceProvider::class,
            LaravelJsonApiServiceProvider::class,
            LaravelJsonApiEncoderServiceProvider::class,
            LaravelJsonApiSpecServiceProvider::class,
            LaravelJsonApiValidationServiceProvider::class,
            PackageServiceProvider::class,
            ProductsServiceProvider::class,
            SanctumServiceProvider::class,
            VendorsServiceProvider::class,
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
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../../../entities/products/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../../../entities/vendors/database/migrations');
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:jXEV5lsYsDz/7LtvuEB/4psnit6zHTbFQ57eKSjoKkQ=');
        $app['config']->set('database.default', 'testing');
    }

    protected function getUserWithRole(string $roleName): UserModel
    {
        Config::set('laratrust.user_models', [
            'users' => 'InetStudio\ACL\Users\Models\UserModel',
        ]);
        Config::set('laratrust.models', [
            'role' => 'InetStudio\ACL\Roles\Models\RoleModel',
            'permission' => 'InetStudio\ACL\Permissions\Models\PermissionModel',
        ]);

        $user = UserModel::factory()->create();

        $roleService = resolve('InetStudio\ACL\Roles\Contracts\Services\Back\ItemsServiceContract');
        $role = $roleService->getModel()->where([['name', '=', $roleName]])->first();
        if (! $role) {
            $role = $roleService->save(
                [
                    'name' => $roleName,
                    'display_name' => $roleName,
                ],
                0
            );
        }

        $user->attachRole($role);

        Sanctum::actingAs($user, ['*']);

        return $user;
    }
}
