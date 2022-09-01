<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Vendors\Application\Queries\FetchItemsByQueryData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('vendors-can-view-any');
    }

    public function messages(): array
    {
        return [
            'filter.array' => 'Поле «filter» должно быть массивом',
            'fields.array' => 'Поле «fields» должно быть массивом',
            'include.string' => 'Поле «include» должно быть строкой',
            'sort.string' => 'Поле «sort» должно быть строкой',
            'page.array' => 'Поле «page» должно быть массивом',
            'page.number.integer' => 'Поле «page.number» должно быть целым числом',
            'page.number.size' => 'Поле «page.size» должно быть целым числом',
        ];
    }

    public function rules(): array
    {
        return [
            'filter' => 'nullable|array',
            'fields' => 'nullable|array',
            'include' => 'nullable|string',
            'sort' => 'nullable|string',
            'page' => 'nullable|array',
            'page.number' => 'integer',
            'page.size' => 'integer',
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDataObject(): ?DataTransferObject
    {
        return new FetchItemsByQueryData($this->validated());
    }
}
