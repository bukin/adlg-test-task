<?php

namespace Bukin\AdminPanel\Base\Application\Exceptions;

use Exception;

class SaveResourceToDBException extends Exception
{
    public static function create(): self
    {
        return new static('DB errors occurred while saving.', 500);
    }
}
