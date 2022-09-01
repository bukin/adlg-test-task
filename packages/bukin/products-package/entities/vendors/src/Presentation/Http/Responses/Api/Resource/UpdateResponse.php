<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource;

use Bukin\AdminPanel\Base\Presentation\Http\Responses\Response as BaseResponse;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Resources\Api\Resource\UpdateResource;
use Illuminate\Http\JsonResponse;

class UpdateResponse extends BaseResponse
{
    public function __construct(protected ?VendorModelContract $result = null)
    {
        parent::__construct();
    }

    public function setResult(?VendorModelContract $result): void
    {
        $this->result = $result;
    }

    public function toResponse($request): JsonResponse
    {
        $errorResponse = parent::toResponse($request);

        if ($errorResponse) {
            return $errorResponse;
        }

        $resource = new UpdateResource($this->result);

        return $resource->response();
    }
}
