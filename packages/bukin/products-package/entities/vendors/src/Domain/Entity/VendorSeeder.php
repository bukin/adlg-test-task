<?php

namespace Bukin\ProductsPackage\Vendors\Domain\Entity;

use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run()
    {
        VendorModel::factory()
            ->count(100)
            ->create();
    }
}
