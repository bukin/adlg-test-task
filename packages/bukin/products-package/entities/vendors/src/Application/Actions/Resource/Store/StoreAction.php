<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Vendors\Application\Actions\Checks\CheckWithCodeExistsAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Checks\CheckWithIdExistsAction;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreAction
{
    public function __construct(
        protected VendorModelContract $model,
        protected CheckWithCodeExistsAction $checkWithCodeExistsAction,
        protected CheckWithIdExistsAction $checkWithIdExistsAction
    ) {}

    /**
     * @throws ResourceExistsException
     * @throws SaveResourceToDBException
     */
    public function execute(StoreItemData $data): VendorModelContract
    {
        $this->checkWithIdExistsAction->execute($data->id);
        $this->checkWithCodeExistsAction->execute($data->code);

        try {
            $item = DB::transaction(function() use ($data) {
                $item = new $this->model;

                $item->id = $data->id->toString() ?: $item->id;
                $item->name = $data->name;
                $item->code = $data->code;

                $item->save();

                return $item->fresh();
            });
        } catch (Throwable $e) {
            throw SaveResourceToDBException::create();
        }

        return $item;
    }
}
