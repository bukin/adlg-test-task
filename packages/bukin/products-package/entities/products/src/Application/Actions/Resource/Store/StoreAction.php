<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Resource\Store;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Products\Application\Actions\Checks\CheckWithIdExistsAction as CheckProductWithIdExistsAction;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Bukin\ProductsPackage\Vendors\Application\Actions\Checks\CheckWithIdDoesNotExistsAction as CheckVendorWithIdDoesNotExistsAction;
use Illuminate\Support\Facades\DB;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

class StoreAction
{
    use QueueableAction;

    public function __construct(
        protected ProductModelContract $model,
        protected CheckProductWithIdExistsAction $checkProductWithIdExistsAction,
        protected CheckVendorWithIdDoesNotExistsAction $checkVendorWithIdDoeNotExistsAction
    ) {}

    /**
     * @throws ResourceExistsException
     * @throws ResourceDoesNotExistException
     * @throws SaveResourceToDBException
     * @throws UnknownProperties
     */
    public function execute(StoreItemData $data): ProductModelContract
    {
        $this->checkProductWithIdExistsAction->execute($data->id);
        $this->checkVendorWithIdDoeNotExistsAction->execute($data->vendor_id);

        try {
            $item = DB::transaction(function () use ($data) {
                $item = new $this->model;

                $item->id = $data->id->toString() ?: $item->id;
                $item->name = $data->name;
                $item->vendor_id = $data->vendor_id;

                $item->save();

                return $item->load('vendor')->fresh();
            });
        } catch (Throwable $e) {
            throw SaveResourceToDBException::create();
        }

        return $item;
    }
}
