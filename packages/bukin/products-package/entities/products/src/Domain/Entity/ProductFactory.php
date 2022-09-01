<?php

namespace Bukin\ProductsPackage\Products\Domain\Entity;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = ProductModel::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->text(255),
            'vendor_id' => VendorModel::factory(),
        ];
    }
}
