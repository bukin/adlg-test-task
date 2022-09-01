<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Checks;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Ramsey\Uuid\UuidInterface;

class CheckWithIdExistsAction
{
    public function __construct(
        protected ProductModelContract $model
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
