<?php

namespace Bukin\ProductsPackage\Products\Application\Actions\Resource\Update;

use Illuminate\Support\Facades\DB;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\AdminPanel\Base\Application\Exceptions\SaveResourceToDBException;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

class UpdateAction
{
    use QueueableAction;

    public function __construct(
        protected ProductModelContract $model
    ) {}

    /**
     * @throws ResourceDoesNotExistException
     * @throws SaveResourceToDBException
     * @throws ResourceExistsException
     */
    public function execute(UpdateItemData $data): ?ProductModelContract
    {
        /** @var  ?ProductModelContract $item */
        $item = $this->model::find($data->id->toString());

        if (! $item) {
            throw ResourceDoesNotExistException::create($data->id);
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

    protected function getDataForUpdate(ProductModelContract $item, UpdateItemData $data): array
    {
        $currentItemData = $item->attributesToArray();
        $requestData = collect($data->toArray())->filter()->toArray();

        return array_merge($currentItemData, $requestData);
    }
}
