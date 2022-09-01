<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Products\Application\Actions\Resource\Store\StoreItemData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('products-can-create');
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Поле «id» обязательно для заполнения',
            'id.uuid' => 'Поле «id» должно быть в формате UUID',
            'name.required' => 'Поле «name» обязательно для заполнения',
            'name.max' => 'Поле «name» не должно превышать 255 символов',
            'vendor_id.required' => 'Поле «vendor_id» обязательно для заполнения',
            'vendor_id.uuid' => 'Поле «vendor_id» должно быть в формате UUID',
        ];
    }

    public function rules(): array
    {
        return [
            'id' => 'required|uuid',
            'name' => 'required|string',
            'vendor_id' => 'required|uuid',
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
