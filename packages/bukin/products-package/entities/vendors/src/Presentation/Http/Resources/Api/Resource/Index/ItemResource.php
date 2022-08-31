<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Resources\Api\Resource\Index;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'code' => $this->resource->code,
            'products' => $this->whenLoaded('products'),
        ];
    }
}
