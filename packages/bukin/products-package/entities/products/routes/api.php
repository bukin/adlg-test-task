<?php

use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use Illuminate\Routing\Middleware\SubstituteBindings;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use Bukin\ProductsPackage\Products\Presentation\Http\Controllers\Api\ResourceController;

Route::group(
    [
        'middleware' => ['api', 'auth:sanctum'],
    ],
    function () {
        JsonApiRoute::server('api.jsonapi.products-package.v1')
            ->prefix('api/jsonapi/products-package/v1')
            ->withoutMiddleware(SubstituteBindings::class)
            ->resources(function ($server) {
                $server->resource('products', JsonApiController::class)
                    ->relationships(function ($relationships) {
                        $relationships->hasOne('vendor')->readOnly();
                    });;
            });

        Route::group([
            'prefix' => 'api/simple/products-package/v1',
        ], function () {
            Route::apiResource('products', ResourceController::class);
        });
    }
);
