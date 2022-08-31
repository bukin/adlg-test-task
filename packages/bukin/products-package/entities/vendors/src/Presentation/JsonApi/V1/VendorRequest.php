<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class VendorRequest extends ResourceRequest
{
    public function messages(): array
    {
        return [
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'code.required' => 'Поле «Код» обязательно для заполнения',
            'code.max' => 'Поле «Код» не должно превышать 255 символов',
            'code.unique' => 'Такое значение поля «Код» уже существует',
        ];
    }

    public function rules(): array
    {
        $unique = Rule::unique('products_package_vendors');

        if ($vendor = $this->model()) {
            $unique->ignore($vendor);
        }

        return [
            'id' => ['required', JsonApiRule::clientId()],
            'name' => ['required', 'max:255', 'string'],
            'code' => ['required', 'max:255', 'string', $unique],
            'products' => ['nullable', JsonApiRule::toMany()],
        ];
    }
}
