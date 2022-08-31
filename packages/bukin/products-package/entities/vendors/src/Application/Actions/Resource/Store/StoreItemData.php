<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store;

use Bukin\AdminPanel\Base\Application\Casters\UuidCast;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class StoreItemData extends DataTransferObject
{
    #[CastWith(UuidCast::class)]
    public ?UuidInterface $id = null;

    public string $name;

    public string $code;
}
