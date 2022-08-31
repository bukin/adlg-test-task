<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ProductRequest extends ResourceRequest
{
    public function messages(): array
    {
        return [
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'vendor.required' => 'Поле «Вендор» обязательно для заполнения',
        ];
    }

    public function rules(): array
    {
        return [
            'id' => ['required', JsonApiRule::clientId()],
            'name' => ['required', 'max:255', 'string'],
            'vendor' => ['required', JsonApiRule::toOne()],
        ];
    }
}
