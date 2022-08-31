<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Resources\Api\Resource\Index;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'items' => $this->collection,
        ];
    }
}
