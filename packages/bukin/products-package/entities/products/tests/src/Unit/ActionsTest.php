<?php

namespace Bukin\ProductsPackage\Products\Tests\Unit;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Destroy\DestroyAction;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Destroy\DestroyItemData;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Store\StoreAction;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Store\StoreItemData;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Update\UpdateAction;
use Bukin\ProductsPackage\Products\Application\Actions\Resource\Update\UpdateItemData;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Tests\TestCase;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ActionsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    function a_product_stored(): void
    {
        $vendor = VendorModel::factory()->create();

        $data = new StoreItemData(
            id: $this->faker->uuid(),
            name: $this->faker->text(255),
            vendor_id: $vendor->id
        );

        $result = resolve(StoreAction::class)->execute($data);

        $this->assertDatabaseCount('products_package_products', 1);

        $this->assertEquals($data->id, $result->id);
        $this->assertEquals($data->name, $result->name);
    }

    /** @test */
    function get_exception_when_store_product_with_exist_id(): void
    {
        $this->expectException(ResourceExistsException::class);

        $vendor = VendorModel::factory();
        $product = ProductModel::factory()->for($vendor, 'vendor')->create();

        $data = new StoreItemData(
            id: $product->id,
            name: $this->faker->text(255),
            vendor_id: $product->vendor->id
        );

        resolve(StoreAction::class)->execute($data);
    }

    /** @test */
    function a_product_updated(): void
    {
        $vendor = VendorModel::factory();
        $product = ProductModel::factory()->for($vendor, 'vendor')->create();

        $data = new UpdateItemData(
            id: $product->id,
            name: $this->faker->text(255),
            vendor_id: $product->vendor->id
        );

        $result = resolve(UpdateAction::class)->execute($data);

        $this->assertDatabaseCount('products_package_products', 1);

        $this->assertEquals($data->id, $result->id);
        $this->assertEquals($data->name, $result->name);
        $this->assertEquals($data->vendor_id, $result->vendor_id);
    }

    /** @test */
    function get_exception_when_update_non_existent_product(): void
    {
        $this->expectException(ResourceDoesNotExistException::class);

        $vendor = VendorModel::factory()->create();

        $data = new UpdateItemData(
            id: $this->faker->uuid(),
            name: $this->faker->text(255),
            vendor_id: $vendor->id
        );

        resolve(UpdateAction::class)->execute($data);
    }

    /** @test */
    function a_product_destroyed(): void
    {
        $vendor = VendorModel::factory();
        $products = ProductModel::factory(2)->for($vendor, 'vendor')->create();

        $data = new DestroyItemData(
            id: $products->first()->id,
        );

        $result = resolve(DestroyAction::class)->execute($data);

        $this->assertCount(1, ProductModel::all());
        $this->assertNotEquals($products->first()->id, ProductModel::first()->id);
        $this->assertEquals(1, $result);
    }

    /** @test */
    function get_exception_when_destroy_non_existent_product(): void
    {
        $this->expectException(ResourceDoesNotExistException::class);

        $vendor = VendorModel::factory();
        ProductModel::factory()->for($vendor, 'vendor')->create();

        $data = new DestroyItemData(
            id: $this->faker->uuid()
        );

        $result = resolve(DestroyAction::class)->execute($data);

        $this->assertCount(1, ProductModel::all());
        $this->assertEquals(0, $result);
    }
}
