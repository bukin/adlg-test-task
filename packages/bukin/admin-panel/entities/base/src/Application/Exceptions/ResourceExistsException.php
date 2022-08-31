<?php

namespace Bukin\AdminPanel\Base\Application\Exceptions;

use Exception;

class ResourceExistsException extends Exception
{
    public static function resourceWithFieldExists(string $field, string $value): self
    {
        $message = 'Resource with %s %s already exists.';

        return new static(sprintf($message, $field, $value), 409);
    }
}
