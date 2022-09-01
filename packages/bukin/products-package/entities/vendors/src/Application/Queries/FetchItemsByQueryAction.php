<?php

namespace Bukin\ProductsPackage\Vendors\Application\Queries;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Bukin\ProductsPackage\Vendors\Domain\Filters\SuggestionFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FetchItemsByQueryAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    public function execute(FetchItemsByQueryData $data): Collection
    {
        $query = QueryBuilder::for($this->model::class, new Request($data->toArray()))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                'code',
                AllowedFilter::custom('suggestion', new SuggestionFilter()),
            ])
            ->allowedFields([
                'id', 'name', 'code', 'created_at', 'updated_at',
            ])
            ->allowedIncludes(['products'])
            ->allowedSorts(['name', 'code', 'created_at', 'updated_at']);

        if (! empty($data->page)) {
            $perPage = (int) ((($data->page['size'] <= 0)) ? 10 : $data->page['size']);
            $page = (int) $data->page['number'];

            $query->simplePaginate($perPage, ['*'], 'page.number', $page);
        }

        return $query->get();
    }
}
