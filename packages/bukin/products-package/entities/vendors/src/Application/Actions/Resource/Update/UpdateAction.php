<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Vendors\Application\Actions\Checks\CheckWithCodeExistsAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Checks\CheckWithIdExistsAction;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateAction
{
    public function __construct(
        protected VendorModelContract $model,
        protected CheckWithCodeExistsAction $checkWithCodeExistsAction,
        protected CheckWithIdExistsAction $checkWithIdExistsAction
    ) {}

    /**
     * @throws ResourceDoesNotExistException
     * @throws SaveResourceToDBException
     * @throws ResourceExistsException
     */
    public function execute(UpdateItemData $data): ?VendorModelContract
    {
        /** @var  ?VendorModelContract $item */
        $item = $this->model::find($data->id->toString());

        if (! $item) {
            throw ResourceDoesNotExistException::create($data->id);
        }

        if ($data->code) {
            $this->checkWithCodeExistsAction->execute($data->code, $item);
        }

        $preparedData = $this->getDataForUpdate($item, $data);

        try {
            $item = DB::transaction(function() use ($item, $data, $preparedData) {
                foreach ($preparedData as $field => $value) {
                    $item->$field = $value;
                }

                $item->save();

                return $item->fresh();
            });
        } catch (Throwable $e) {
            throw SaveResourceToDBException::create();
        }

        return $item;
    }

    protected function getDataForUpdate(VendorModelContract $item, UpdateItemData $data): array
    {
        $currentItemData = $item->attributesToArray();
        $requestData = collect($data->toArray())->filter()->toArray();

        return array_merge($currentItemData, $requestData);
    }
}
