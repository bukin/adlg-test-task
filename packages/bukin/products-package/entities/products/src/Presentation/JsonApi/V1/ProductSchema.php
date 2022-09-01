<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Filters\SuggestionFilter;
use Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Filters\VendorFilter;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class ProductSchema extends Schema
{
    public static string $model = ProductModel::class;

    protected bool $selfLink = false;

    protected ?string $uriType = 'products';

    public static function type(): string
    {
        return 'products';
    }

    public function fields(): array
    {
        return [
            ID::make()->uuid()->clientIds(),
            Str::make('name')->sortable(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
            BelongsTo::make('vendor'),
        ];
    }

    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            SuggestionFilter::make('suggestion'),
            VendorFilter::make('vendor'),
        ];
    }

    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }
}
