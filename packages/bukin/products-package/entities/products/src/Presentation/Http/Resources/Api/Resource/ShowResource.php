<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Resources\Api\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'vendor' => $this->whenLoaded('vendor')
        ];
    }
}
