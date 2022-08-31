<?php

namespace Bukin\ProductsPackage\Products\Infrastructure\Services;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;

class ItemsService
{
    public function __construct(
        protected ProductModelContract $model
    ) {}
}
