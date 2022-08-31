<?php

namespace Bukin\ProductsPackage\Vendors\Domain\Entity;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = VendorModel::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->text(255),
            'code' => $this->faker->md5(),
        ];
    }
}
