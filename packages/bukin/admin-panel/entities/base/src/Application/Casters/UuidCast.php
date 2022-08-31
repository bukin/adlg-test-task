<?php

namespace Bukin\AdminPanel\Base\Application\Casters;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\Caster;

class UuidCast implements Caster
{
    public function cast(mixed $value): ?UuidInterface
    {
        return ($value && is_string($value)) ? Uuid::fromString($value) : null;
    }
}
