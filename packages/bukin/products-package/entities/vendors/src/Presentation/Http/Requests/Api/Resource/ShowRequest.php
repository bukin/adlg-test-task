<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Bukin\ProductsPackage\Vendors\Application\Queries\FetchItemsByQueryData;

class ShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            filter: ['id' => $this->route('vendor')],
            include: 'products'
        );
    }
}
