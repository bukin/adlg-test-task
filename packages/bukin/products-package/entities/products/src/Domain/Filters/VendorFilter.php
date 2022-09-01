<?php

namespace Bukin\ProductsPackage\Products\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class VendorFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas(
            'vendor',
            function ($query) use ($value) {
                $query->where(function ($vendorQuery) use ($value) {
                    $vendorQuery->where('name', '=', $value)
                        ->orWhere('code', '=', $value);
                });
            }
        );
    }
}
