<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Checks;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Ramsey\Uuid\UuidInterface;

class CheckWithIdExistsAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    /**
     * @throws ResourceExistsException
     */
    public function execute(?UuidInterface $id): void
    {
        if (! $id) {
            return;
        }

        $item = $this->model::find($id->toString());

        if ($item) {
            throw ResourceExistsException::resourceWithFieldExists('id', $id->toString());
        }
    }
}
