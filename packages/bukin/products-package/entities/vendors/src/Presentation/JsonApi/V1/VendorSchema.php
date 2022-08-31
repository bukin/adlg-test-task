<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1\Filters\SuggestionFilter;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class VendorSchema extends Schema
{
    public static string $model = VendorModel::class;

    protected bool $selfLink = false;

    protected ?string $uriType = 'vendors';

    public static function type(): string
    {
        return 'vendors';
    }

    public function fields(): array
    {
        return [
            ID::make()->uuid()->clientIds(),
            Str::make('name')->sortable(),
            Str::make('code')->sortable(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
            BelongsToMany::make('products'),
        ];
    }

    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            Where::make('code')->singular(),
            SuggestionFilter::make('suggestion'),
        ];
    }

    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }
}
