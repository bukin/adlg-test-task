<?php

namespace Bukin\ProductsPackage\Products\Domain\Entity;

use Illuminate\Database\Eloquent\Factories\Factory;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;

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
