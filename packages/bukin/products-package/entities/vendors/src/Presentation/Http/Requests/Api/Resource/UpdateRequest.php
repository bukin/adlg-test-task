<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update\UpdateItemData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('vendors-can-update');
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'code.max' => 'Поле «Код» не должно превышать 255 символов',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDataObject(): ?DataTransferObject
    {
        return new UpdateItemData(
            array_merge(
                ['id' => $this->route('vendor')],
                $this->validated()
            )
        );
    }
}
