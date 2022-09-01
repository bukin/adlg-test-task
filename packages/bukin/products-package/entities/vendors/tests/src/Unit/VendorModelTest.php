<?php

namespace Bukin\ProductsPackage\Vendors\Tests\Unit;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_vendor_has_a_name(): void
    {
        $vendor = VendorModel::factory()->create(['name' => 'Test name']);

        $this->assertEquals('Test name', $vendor->name);
    }

    /** @test */
    function a_vendor_has_a_code(): void
    {
        $vendor = VendorModel::factory()->create(['code' => 'Test code']);

        $this->assertEquals('Test code', $vendor->code);
    }

    /** @test */
    function a_vendor_has_a_type_attribute(): void
    {
        $vendor = VendorModel::factory()->create();

        $this->assertEquals('products_package_vendor', $vendor->getTypeAttribute());
    }
}
