<?php

namespace Bukin\ProductsPackage\Products\Domain\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SuggestionFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'like', '%'.$value.'%');
    }
}
