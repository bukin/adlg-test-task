<?php

namespace Bukin\ProductsPackage\Vendors\Application\Queries;

use Spatie\DataTransferObject\DataTransferObject;

class FetchItemsByQueryData extends DataTransferObject
{
    public array $filter = [];

    public string $sort = '';

    public string $include = '';

    public array $fields = [];

    public array $page = [];
}
