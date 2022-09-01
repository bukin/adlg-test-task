<?php

namespace Bukin\ProductsPackage\Vendors\Tests\Unit;

use Bukin\AdminPanel\Base\Application\Exceptions\ResourceDoesNotExistException;
use Bukin\AdminPanel\Base\Application\Exceptions\ResourceExistsException;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Destroy\DestroyAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Destroy\DestroyItemData;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store\StoreAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store\StoreItemData;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update\UpdateAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update\UpdateItemData;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ActionsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    function a_vendor_stored(): void
    {
        $data = new StoreItemData(
            id: $this->faker->uuid(),
            name: $this->faker->text(255),
            code: $this->faker->text(255)
        );

        $result = resolve(StoreAction::class)->execute($data);

        $this->assertDatabaseCount('products_package_vendors', 1);

        $this->assertEquals($data->id, $result->id);
        $this->assertEquals($data->name, $result->name);
        $this->assertEquals($data->code, $result->code);
    }

    /** @test */
    function get_exception_when_store_vendor_with_exist_id(): void
    {
        $this->expectException(ResourceExistsException::class);

        $vendor = VendorModel::factory()->create();

        $data = new StoreItemData(
            id: $vendor->id,
            name: $this->faker->text(255),
            code: $this->faker->text(255)
        );

        resolve(StoreAction::class)->execute($data);
    }

    /** @test */
    function get_exception_when_store_vendor_with_exist_code(): void
    {
        $this->expectException(ResourceExistsException::class);

        $vendor = VendorModel::factory()->create();

        $data = new StoreItemData(
            id: $this->faker->uuid(),
            name: $this->faker->text(255),
            code: $vendor->code
        );

        resolve(StoreAction::class)->execute($data);
    }

    /** @test */
    function a_vendor_updated(): void
    {
        $vendor = VendorModel::factory()->create();

        $data = new UpdateItemData(
            id: $vendor->id,
            name: $this->faker->text(255),
            code: $vendor->code,
        );

        $result = resolve(UpdateAction::class )->execute($data);

        $this->assertDatabaseCount('products_package_vendors', 1);

        $this->assertEquals($data->id, $result->id);
        $this->assertEquals($data->name, $result->name);
        $this->assertEquals($data->code, $result->code);
    }

    /** @test */
    function get_exception_when_update_non_existent_vendor(): void
    {
        $this->expectException(ResourceDoesNotExistException::class);

        $data = new UpdateItemData(
            id: $this->faker->uuid(),
            name: $this->faker->text(255),
            code: $this->faker->text(255)
        );

        resolve(UpdateAction::class )->execute($data);
    }

    /** @test */
    function get_exception_when_update_vendor_with_exist_code(): void
    {
        $this->expectException(ResourceExistsException::class);

        $vendors = VendorModel::factory(2)->create();

        $data = new UpdateItemData(
            id: $vendors->first()->id,
            name: $this->faker->text(255),
            code: $vendors->last()->code
        );

        resolve(UpdateAction::class )->execute($data);
    }

    /** @test */
    function a_vendor_destroyed(): void
    {
        $vendors = VendorModel::factory(2)->create();

        $data = new DestroyItemData(
            id: $vendors->first()->id,
        );

        $result = resolve(DestroyAction::class)->execute($data);

        $this->assertCount(1, VendorModel::all());
        $this->assertNotEquals($vendors->first()->id, VendorModel::first()->id);
        $this->assertEquals(1, $result);
    }

    /** @test */
    function get_exception_when_destroy_non_existent_vendor(): void
    {
        $this->expectException(ResourceDoesNotExistException::class);

        VendorModel::factory()->create();

        $data = new DestroyItemData(
            id: $this->faker->uuid()
        );

        resolve(DestroyAction::class)->execute($data);
    }
}
