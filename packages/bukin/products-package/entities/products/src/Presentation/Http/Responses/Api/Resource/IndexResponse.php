<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Responses\Api\Resource;

use Bukin\AdminPanel\Base\Presentation\Http\Responses\Response as BaseResponse;
use Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource\Index\ItemsCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class IndexResponse extends BaseResponse
{
    public function __construct(protected ?Collection $result)
    {
        parent::__construct();
    }

    public function setResult(?Collection $result): void
    {
        $this->result = $result;
    }

    public function toResponse($request): JsonResponse
    {
        $errorResponse = parent::toResponse($request);

        if ($errorResponse) {
            return $errorResponse;
        }

        $resourceCollection = new ItemsCollection($this->result);

        return $resourceCollection->response();
    }
}
