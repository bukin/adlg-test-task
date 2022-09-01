<?php

use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use Illuminate\Routing\Middleware\SubstituteBindings;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Controllers\Api\ResourceController;

Route::group(
    [
        'middleware' => ['api', 'auth:sanctum'],
    ],
    function () {
        JsonApiRoute::server('api.jsonapi.products-package.v1')
            ->prefix('api/jsonapi/products-package/v1')
            ->withoutMiddleware(SubstituteBindings::class)
            ->resources(function ($server) {
                $server->resource('vendors', JsonApiController::class)
                    ->relationships(function ($relationships) {
                        $relationships->hasMany('products')->readOnly();
                    });
            });

        Route::group([
            'prefix' => 'api/simple/products-package/v1',
        ], function () {
            Route::apiResource('vendors', ResourceController::class);
        });
    }
);
