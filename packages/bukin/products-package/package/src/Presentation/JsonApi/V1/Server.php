<?php

namespace Bukin\ProductsPackage\Presentation\JsonApi\V1;

use Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\ProductSchema;
use Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1\VendorSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{
    protected string $baseUri = '/api/jsonapi/products-package/v1/';

    public function serving(): void
    {
        // no-op
    }

    protected function allSchemas(): array
    {
        return [
            ProductSchema::class,
            VendorSchema::class,
        ];
    }
}
