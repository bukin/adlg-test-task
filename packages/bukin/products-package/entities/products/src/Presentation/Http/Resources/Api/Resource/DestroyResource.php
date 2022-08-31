<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class DestroyResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request): array
    {
        return [];
    }

    public function withResponse($request, $response)
    {
        $code = ($this->resource > 0) ? 200 : 404;

        $response->setStatusCode($code);
    }
}
