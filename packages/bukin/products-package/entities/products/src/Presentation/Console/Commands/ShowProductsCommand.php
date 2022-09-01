<?php

namespace Bukin\ProductsPackage\Products\Presentation\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Bukin\ProductsPackage\Products\Application\Queries\FetchItemsByQueryData;
use Bukin\ProductsPackage\Products\Application\Queries\FetchItemsByQueryAction;

class ShowProductsCommand extends Command
{
    protected $name = 'bukin:products-package:products:show';

    protected $description = 'Show products';

    public function __construct(
        protected FetchItemsByQueryAction $productsFetcher
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $query = new FetchItemsByQueryData(
            include: 'vendor'
        );

        $items = $this->productsFetcher->execute($query);

        $headers = ['id', 'name', 'vendor.name'];
        $data = $items->map(function($item) {
            return [
                $item->id,
                Str::limit($item->name, 75),
                Str::limit($item->vendor->name ?? '', 75),
            ];
        })->toArray();

        $this->table($headers, $data);
    }
}
