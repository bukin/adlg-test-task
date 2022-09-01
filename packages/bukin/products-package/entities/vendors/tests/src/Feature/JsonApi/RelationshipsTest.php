<?php

namespace Bukin\ProductsPackage\Vendors\Tests\Feature\JsonApi;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use LaravelJsonApi\Testing\MakesJsonApiRequests;

class RelationshipsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use MakesJsonApiRequests;

    /** @test */
    function show_vendor_products(): void
    {
        $vendor = VendorModel::factory()->create();
        $products = ProductModel::factory(5)->create(['vendor_id' => $vendor->id]);

        $url = route('api.jsonapi.products-package.v1.vendors.products', ['vendor' => (string) $vendor->getRouteKey()]);

        $expected = $products->map(fn(ProductModel $product) => [
            'type' => 'products',
            'id' => (string) $product->getRouteKey(),
            'attributes' => [
                'createdAt' => $product->created_at,
                'name' => $product->name,
                'updatedAt' => $product->updated_at,
            ],
        ])->all();

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedMany($expected);
    }

    /** @test */
    function show_vendor_products_relationship(): void
    {
        $vendor = VendorModel::factory()->create();
        $products = ProductModel::factory(5)->create(['vendor_id' => $vendor->id]);

        $url = route('api.jsonapi.products-package.v1.vendors.products.show', ['vendor' => (string) $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedToMany($products);
    }

    /** @test */
    function show_empty_vendor_products_relationship(): void
    {
        $vendor = VendorModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.vendors.products.show', ['vendor' => (string) $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedNone();
    }
}
