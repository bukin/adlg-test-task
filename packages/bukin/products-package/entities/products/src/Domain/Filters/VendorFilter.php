<?php

namespace Bukin\ProductsPackage\Products\Domain\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

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
