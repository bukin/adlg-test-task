<?php

namespace Bukin\ProductsPackage\Vendors\Domain\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SuggestionFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query
            ->where('name', 'like', '%'.$value.'%')
            ->orWhere('code', 'like', '%'.$value.'%');
    }
}
