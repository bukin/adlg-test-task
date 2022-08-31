<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store;

use Illuminate\Support\Facades\DB;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Ramsey\Uuid\UuidInterface;
use Throwable;

class StoreAction
{
    public function __construct(
        protected VendorModelContract $model
    ) {}

    /**
     * @throws ResourceExistsException
     * @throws SaveResourceToDBException
     */
    public function execute(StoreItemData $data): VendorModelContract
    {
        $this->checkWithIdExists($data->id);
        $this->checkWithCodeExists($data->code);

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

    /**
     * @throws ResourceExistsException
     */
    protected function checkWithIdExists(?UuidInterface $id): void
    {
        if (! $id) {
            return;
        }

        $item = $this->model::find($id->toString());

        if ($item) {
            throw ResourceExistsException::resourceWithFieldExists('id', $id->toString());
        }
    }

    /**
     * @throws ResourceExistsException
     */
    protected function checkWithCodeExists(string $code): void
    {
        $exists = $this->model::where('code', '=', $code)->exists();

        if ($exists) {
            throw ResourceExistsException::resourceWithFieldExists('code', $code);
        }
    }
}
