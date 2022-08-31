<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Responses\Api\Resource;

use Bukin\AdminPanel\Base\Presentation\Http\Responses\Response as BaseResponse;
use Illuminate\Http\JsonResponse;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource\StoreResource;

class StoreResponse extends BaseResponse
{
    public function __construct(protected ?ProductModelContract $result = null)
    {
        parent::__construct();
    }

    public function setResult(?ProductModelContract $result): void
    {
        $this->result = $result;
    }

    public function toResponse($request): JsonResponse
    {
        $errorResponse = parent::toResponse($request);

        if ($errorResponse) {
            return $errorResponse;
        }

        $resource = new StoreResource($this->result);

        return $resource->response();
    }
}
