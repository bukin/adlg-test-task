<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store\StoreItemData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('vendors-can-create');
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Поле «id» обязательно для заполнения',
            'id.uuid' => 'Поле «id» должно быть в формате UUID',
            'name.required' => 'Поле «Название» обязательно для заполнения',
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'code.required' => 'Поле «Код» обязательно для заполнения',
            'code.max' => 'Поле «Код» не должно превышать 255 символов',
        ];
    }

    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
            'name' => 'required|string',
            'code' => 'required|string',
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDataObject(): ?DataTransferObject
    {
        return new StoreItemData($this->validated());
    }
}
