<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Checks;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;

class CheckWithCodeExistsAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    /**
     * @throws ResourceExistsException
     */
    public function execute(string $code, ?VendorModelContract $excludeItem = null): void
    {
        $exists = $this->model::where('code', '=', $code)
            ->when($excludeItem, function ($query) use ($excludeItem) {
                $query->where('id', '!=', $excludeItem->id);
            })->exists();

        if ($exists) {
            throw ResourceExistsException::resourceWithFieldExists('code', $code);
        }
    }
}
