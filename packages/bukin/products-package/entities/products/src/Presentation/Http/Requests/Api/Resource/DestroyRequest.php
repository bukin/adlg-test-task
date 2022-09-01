<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Products\Application\Actions\Resource\Destroy\DestroyItemData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class DestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('products-can-delete');
    }

    public function messages(): array
    {
        return [];
    }

    public function rules(): array
    {
        return [];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDataObject(): ?DataTransferObject
    {
        return new DestroyItemData(
            id: $this->route('product')
        );
    }
}
