<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Resource\Update;

use Bukin\AdminPanel\Base\Application\Casters\UuidCast;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateItemData extends DataTransferObject
{
    #[CastWith(UuidCast::class)]
    public UuidInterface $id;

    public ?string $name;

    #[CastWith(UuidCast::class)]
    public ?UuidInterface $vendor_id;
}
