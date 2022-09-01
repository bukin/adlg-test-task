<?php

namespace Bukin\ProductsPackage\Products\Presentation\Http\Requests\Api\Resource;

use Bukin\ProductsPackage\Products\Application\Actions\Resource\Update\UpdateItemData;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('products-can-update');
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Поле «Название» не должно превышать 255 символов',
            'vendor_id.uuid' => 'Поле «vendor_id» должно быть в формате UUID',
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'vendor_id' => 'nullable|uuid',
        ];
    }

    /**
     * @throws UnknownProperties
     */
    public function getDataObject(): ?DataTransferObject
    {
        return new UpdateItemData(
            array_merge(
                ['id' => $this->route('product')],
                $this->validated()
            )
        );
    }
}
