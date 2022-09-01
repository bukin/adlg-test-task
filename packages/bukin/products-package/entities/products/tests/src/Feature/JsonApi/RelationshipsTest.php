<?php

namespace Bukin\ProductsPackage\Products\Tests\Feature\JsonApi;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Tests\TestCase;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use LaravelJsonApi\Testing\MakesJsonApiRequests;

class RelationshipsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use MakesJsonApiRequests;

    /** @test */
    function show_product_vendor(): void
    {
        $vendor = VendorModel::factory();
        $product = ProductModel::factory()->for($vendor, 'vendor')->create();

        $url = route('api.jsonapi.products-package.v1.products.vendor', ['product' => (string) $product->getRouteKey()]);

        $expected = [
            'type' => 'vendors',
            'id' => (string) $product->vendor->getRouteKey(),
            'attributes' => [
                'code' => $product->vendor->code,
                'name' => $product->vendor->name,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response->assertFetchedOne($expected);
    }

    /** @test */
    function show_product_vendor_relationship(): void
    {
        $vendor = VendorModel::factory();
        $product = ProductModel::factory()->for($vendor, 'vendor')->create();

        $url = route('api.jsonapi.products-package.v1.products.vendor.show', ['product' => (string) $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response->assertFetchedToOne($product->vendor);
    }
}
