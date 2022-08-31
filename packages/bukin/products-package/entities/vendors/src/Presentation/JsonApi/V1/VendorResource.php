<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1;

use LaravelJsonApi\Core\Resources\JsonApiResource;

class VendorResource extends JsonApiResource
{
    public function attributes($request): iterable
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
