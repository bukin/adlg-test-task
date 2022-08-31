<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Requests\Api\Resource;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Bukin\ProductsPackage\Products\Application\Queries\FetchItemsByQueryData;

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
            filter: ['id' => $this->route('product')],
            include: 'vendor'
        );
    }
}
