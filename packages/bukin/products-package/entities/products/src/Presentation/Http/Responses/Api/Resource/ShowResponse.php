<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Responses\Api\Resource;

use Bukin\AdminPanel\Base\Presentation\Http\Responses\Response as BaseResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource\ShowResource;

class ShowResponse extends BaseResponse
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

        $resource = new ShowResource($this->result->first());

        return $resource->response();
    }
}
