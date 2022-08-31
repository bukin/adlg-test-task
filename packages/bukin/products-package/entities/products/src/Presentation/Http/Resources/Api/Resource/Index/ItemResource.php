<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource\Index;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'vendor' => $this->whenLoaded('vendor'),
        ];
    }
}
