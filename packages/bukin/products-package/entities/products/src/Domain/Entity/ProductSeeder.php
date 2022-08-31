<?php

namespace Bukin\ProductsPackage\Products\Domain\Entity;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        ProductModel::factory()
            ->count(100)
            ->create();
    }
}
