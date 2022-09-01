<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Checks;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Ramsey\Uuid\UuidInterface;

class CheckWithIdDoesNotExistsAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    /**
     * @throws ResourceDoesNotExistException
     */
    public function execute(?UuidInterface $id): void
    {
        if (! $id) {
            return;
        }

        $item = $this->model::find($id->toString());

        if (! $item) {
            throw ResourceDoesNotExistException::create($id->toString());
        }
    }
}
