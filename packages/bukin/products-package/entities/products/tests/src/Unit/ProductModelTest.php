<?php

namespace Bukin\ProductsPackage\Products\Tests\Unit;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_product_has_a_name()
    {
        $product = ProductModel::factory()->create(['name' => 'Test value']);

        $this->assertEquals('Test value', $product->name);
    }

    /** @test */
    function a_product_has_a_type_attribute()
    {
        $product = ProductModel::factory()->create();

        $this->assertEquals('products_package_product', $product->getTypeAttribute());
    }
}
