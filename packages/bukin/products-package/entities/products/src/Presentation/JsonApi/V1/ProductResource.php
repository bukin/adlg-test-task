<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1;

use LaravelJsonApi\Core\Resources\JsonApiResource;

class ProductResource extends JsonApiResource
{
    public function attributes($request): iterable
    {
        return [
            'name' => $this->name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
