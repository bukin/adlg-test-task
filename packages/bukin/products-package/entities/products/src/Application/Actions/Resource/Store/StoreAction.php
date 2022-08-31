<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Resource\Store;

use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Ramsey\Uuid\UuidInterface;
use Throwable;

class StoreAction
{
    use QueueableAction;

    public function __construct(
        protected ProductModelContract $model
    ) {}

    /**
     * @throws ResourceExistsException
     * @throws SaveResourceToDBException
     */
    public function execute(StoreItemData $data): ProductModelContract
    {
        $this->checkWithIdExists($data->id);

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
}
