<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Resource\Destroy;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;

class DestroyAction
{
    public function __construct(
        protected ProductModelContract $model
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
