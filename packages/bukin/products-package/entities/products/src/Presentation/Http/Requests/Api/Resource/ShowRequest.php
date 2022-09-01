<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Products\Application\Queries\FetchItemsByQueryData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('products-can-view');
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
        return new FetchItemsByQueryData(
            filter: ['id' => $this->route('product')],
            include: 'vendor'
        );
    }
}
