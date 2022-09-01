<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource;

use Bukin\AdminPanel\Base\Presentation\Http\Responses\Response as BaseResponse;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Resources\Api\Resource\DestroyResource;
use Illuminate\Http\JsonResponse;

class DestroyResponse extends BaseResponse
{
    public function __construct(protected ?int $result = 0)
    {
        parent::__construct();
    }

    public function setResult(?int $result): void
    {
        $this->result = $result;
    }

    public function toResponse($request): JsonResponse
    {
        $errorResponse = parent::toResponse($request);

        if ($errorResponse) {
            return $errorResponse;
        }

        $resource = new DestroyResource($this->result);

        return $resource->response();
    }
}
