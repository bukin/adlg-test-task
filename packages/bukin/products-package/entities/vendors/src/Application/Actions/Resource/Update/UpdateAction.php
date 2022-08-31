<?php

namespace Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update;

use Illuminate\Support\Facades\DB;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Throwable;

class UpdateAction
{
    public function __construct(
        protected VendorModelContract $model
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
            $this->checkWithCodeExists($item, $data->code);
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

    /**
     * @throws ResourceExistsException
     */
    protected function checkWithCodeExists(VendorModelContract $item, string $code): void
    {
        $exists = $this->model::where('id', '!=', $item->id)->where('code', '=', $code)->exists();

        if ($exists) {
            throw ResourceExistsException::resourceWithFieldExists('code', $code);
        }
    }

    protected function getDataForUpdate(VendorModelContract $item, UpdateItemData $data): array
    {
        $currentItemData = $item->attributesToArray();
        $requestData = collect($data->toArray())->filter()->toArray();

        return array_merge($currentItemData, $requestData);
    }
}
