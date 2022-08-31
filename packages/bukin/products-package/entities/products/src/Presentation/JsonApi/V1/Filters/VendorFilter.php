<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Filters;

use LaravelJsonApi\Core\Support\Str;
use LaravelJsonApi\Eloquent\Contracts\Filter;
use LaravelJsonApi\Eloquent\Filters\Concerns\IsSingular;

class VendorFilter implements Filter
{
    use IsSingular;

    private string $name;

    private string $column;

    public static function make(string $name, string $column = null): self
    {
        return new static($name, $column);
    }

    public function __construct(string $name, string $column = null)
    {
        $this->name = $name;
        $this->column = $column ?: Str::underscore($name);
    }

    public function key(): string
    {
        return $this->name;
    }

    public function apply($query, $value)
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
