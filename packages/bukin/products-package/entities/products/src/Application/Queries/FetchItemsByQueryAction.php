<?php

namespace Bukin\ProductsPackage\Products\Application\Queries;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Bukin\ProductsPackage\Products\Domain\Filters\SuggestionFilter;
use Bukin\ProductsPackage\Products\Domain\Filters\VendorFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FetchItemsByQueryAction
{
    public function __construct(
        protected ProductModelContract $model
    ) {}

    public function execute(FetchItemsByQueryData $data): Collection
    {
        $query = QueryBuilder::for($this->model::class, new Request($data->toArray()))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                'vendor_id',
                AllowedFilter::custom('suggestion', new SuggestionFilter()),
                AllowedFilter::custom('vendor', new VendorFilter()),
            ])
            ->allowedFields([
                'id', 'name', 'vendor_id', 'created_at', 'updated_at',
            ])
            ->allowedIncludes(['vendor'])
            ->allowedSorts(['name', 'created_at', 'updated_at']);

        if (! empty($data->page)) {
            $perPage = (int) ((($data->page['size'] <= 0)) ? 10 : $data->page['size']);
            $page = (int) $data->page['number'];

            $query->simplePaginate($perPage, ['*'], 'page.number', $page);
        }

        return $query->get();
    }
}
