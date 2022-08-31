<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Destroy;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;

class DestroyAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    /**
     * @throws ResourceDoesNotExistException
     */
    public function execute(DestroyItemData $data): int
    {
         $count = $this->model::destroy($data->id->toString());

         if (! $count) {
             throw ResourceDoesNotExistException::create($data->id->toString());
         }

         return $count;
    }
}
