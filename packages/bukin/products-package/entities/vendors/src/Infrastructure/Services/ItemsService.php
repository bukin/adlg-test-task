<?php

namespace Bukin\ProductsPackage\Vendors\Infrastructure\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;

class ItemsService
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    public function getByCodes(string|array $codes): Collection
    {
        $codes = Arr::wrap($codes);

        return $this->model::whereIn('code', $codes)->get();
    }
}
