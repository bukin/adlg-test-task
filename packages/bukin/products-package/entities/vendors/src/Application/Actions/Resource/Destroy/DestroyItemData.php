<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Destroy;

use Bukin\AdminPanel\Base\Application\Casters\UuidCast;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class DestroyItemData extends DataTransferObject
{
    #[CastWith(UuidCast::class)]
    public UuidInterface $id;
}
