<?php

namespace Bukin\ProductsPackage\Products\Tests\Feature\JsonApi;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Products\Tests\TestCase;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use LaravelJsonApi\Testing\MakesJsonApiRequests;

class ResourceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use MakesJsonApiRequests;

    /** @test */
    function index_endpoint()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedMany($products);
    }

    /** @test */
    function index_endpoint_with_empty_response()
    {
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function index_endpoint_with_id_sort_asc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('id')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortBy('id'));
    }

    /** @test */
    function index_endpoint_with_id_sort_desc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('-id')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortByDesc('id'));
    }

    /** @test */
    function index_endpoint_with_name_sort_asc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('name')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortBy('name'));
    }

    /** @test */
    function index_endpoint_with_name_sort_desc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('-name')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortByDesc('name'));
    }

    /** @test */
    function index_endpoint_with_created_at_sort_asc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('createdAt')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortBy('created_at'));
    }

    /** @test */
    function index_endpoint_with_created_at_sort_desc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('-createdAt')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortByDesc('created_at'));
    }

    /** @test */
    function index_endpoint_with_updated_at_sort_asc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('updatedAt')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortBy('updated_at'));
    }

    /** @test */
    function index_endpoint_with_updated_at_sort_desc()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sort('-updatedAt')
            ->get($url);

        $response->assertFetchedManyInOrder($products->sortByDesc('updated_at'));
    }

    /** @test */
    function index_endpoint_with_id_filter()
    {
        $products = ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['id' => [$products->first()->id]])
            ->get($url);

        $response->assertFetchedMany([$products->first()]);
    }

    /** @test */
    function index_endpoint_with_id_filter_empty_response()
    {
        ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['id' => ['test']])
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function index_endpoint_with_vendor_filter()
    {
        $products = ProductModel::factory()->count(5);
        $vendor = VendorModel::factory()->has($products, 'products')->create();
        ProductModel::factory(5)->create();

        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['vendor' => $vendor->code])
            ->get($url);

        $response->assertFetchedMany($vendor->products);
    }

    /** @test */
    function index_endpoint_with_vendor_filter_empty_response()
    {
        $products = ProductModel::factory()->count(5);
        VendorModel::factory()->has($products, 'products')->create();

        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['vendor' => 'test_vendor'])
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function index_endpoint_with_suggestion_filter()
    {
        ProductModel::factory(5)->create();

        $firstExpectedProduct = ProductModel::factory()->create([
            'name' => 'suggestion_test'
        ]);

        $secondExpectedProduct = ProductModel::factory()->create([
            'name' => 'suggestion_test_2'
        ]);

        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['suggestion' => 'suggestion_test'])
            ->get($url);

        $response->assertFetchedMany([$firstExpectedProduct, $secondExpectedProduct]);
    }

    /** @test */
    function index_endpoint_with_suggestion_filter_empty_response()
    {
        ProductModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['suggestion' => 'suggestion_test'])
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function get_error_when_index_endpoint_with_invalid_filter()
    {
        $url = route('api.jsonapi.products-package.v1.products.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->filter(['test' => 'test'])
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'filter'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function show_product_without_vendor(): void
    {
        $product = ProductModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response
            ->assertFetchedOne($product)
            ->assertDoesntHaveIncluded();
    }

    /** @test */
    public function show_product_with_include_vendor(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->includePaths('vendor')
            ->get($url);

        $response
            ->assertFetchedOne($product)
            ->assertIncluded([[
                'type' => 'vendors',
                'id' => $product->vendor->id,
            ]]);
    }

    /** @test */
    public function show_endpoint(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $expected = [
            'type' => 'products',
            'id' => (string) $product->getRouteKey(),
            'attributes' => [
                'createdAt' => $product->created_at,
                'name' => $product->name,
                'updatedAt' => $product->updated_at,
            ]
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertFetchedOneExact($expected);
    }

    /** @test */
    public function get_error_when_show_product_with_invalid_include(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->includePaths('invalid_relation')
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'include'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function show_product_with_sparse_fields(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $expected = [
            'type' => 'products',
            'id' => (string) $product->getRouteKey(),
            'attributes' => [
                'name' => $product->name,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sparseFields('products', ['name'])
            ->get($url);

        $response->assertFetchedOneExact($expected);
    }

    /** @test */
    public function show_product_with_sparse_vendor_relation(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->includePaths('vendor')
            ->sparseFields('products', ['vendor'])
            ->get($url);

        $response
            ->assertFetchedOne($product)
            ->assertIncluded([[
                'type' => 'vendors',
                'id' => $product->vendor->id,
            ]]);
    }

    /** @test */
    function get_error_when_show_product_with_invalid_field()
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->sparseFields('products', ['test'])
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'fields'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function get_error_when_show_non_existent_product(): void
    {
        $url = route('api.jsonapi.products-package.v1.products.show', ['product' => 'test']);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->get($url);

        $response->assertNotFound();
    }

    /** @test */
    public function store_product(): void
    {
        $vendor = VendorModel::factory()->create();
        $product = ProductModel::factory()->make();

        $url = route('api.jsonapi.products-package.v1.products.store');

        $data = [
            'type' => 'products',
            'id' => $product->id,
            'attributes' => [
                'name' => $product->name,
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $vendor->id,
                    ],
                ],
            ],
        ];

        $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->includePaths('vendor')
            ->post($url);

        $this->assertDatabaseHas('products_package_products', [
            'id' => $product->id,
            'name' => $product->name,
            'vendor_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function get_error_when_store_product_without_id(): void
    {
        $product = ProductModel::factory()->make();

        $url = route('api.jsonapi.products-package.v1.products.store');

        $data = [
            'type' => 'products',
            'attributes' => [
                'name' => $product->name,
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $product->vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/id'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function get_error_when_store_product_with_incorrect_id(): void
    {
        $product = ProductModel::factory()->make();

        $url = route('api.jsonapi.products-package.v1.products.store');

        $data = [
            'type' => 'products',
            'id' => 'test',
            'attributes' => [
                'name' => $product->name,
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $product->vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/id'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function get_error_when_store_product_without_name(): void
    {
        $product = ProductModel::factory()->make();

        $url = route('api.jsonapi.products-package.v1.products.store');

        $data = [
            'type' => 'products',
            'id' => $product->id,
            'attributes' => [
                'name' => null,
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $product->vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function get_error_when_store_product_with_long_name(): void
    {
        $product = ProductModel::factory()->make([
            'name' => $this->faker->text(500),
        ]);

        $url = route('api.jsonapi.products-package.v1.products.store');

        $data = [
            'type' => 'products',
            'id' => $product->id,
            'attributes' => [
                'name' => $this->faker->text(500),
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $product->vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_products', [
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    /** @test */
    public function update_product(): void
    {
        $vendor = VendorModel::factory()->create();
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.update', ['product' => $product->getRouteKey()]);

        $data = [
            'type' => 'products',
            'id' => (string) $product->getRouteKey(),
            'attributes' => [
                'name' => 'updated-name',
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->includePaths('vendor')
            ->patch($url);

        $response->assertFetchedOne($product);

        $this->assertDatabaseHas('products_package_products', [
            'id' => $product->getKey(),
            'name' => $data['attributes']['name'],
            'vendor_id' => $vendor->id,
        ]);
    }

    /** @test */
    public function get_error_when_update_product_with_long_name(): void
    {
        $product = ProductModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.products.update', ['product' => $product->getRouteKey()]);

        $data = [
            'type' => 'products',
            'id' => (string) $product->getRouteKey(),
            'attributes' => [
                'name' => $this->faker->text(500),
            ],
            'relationships' => [
                'vendor' => [
                    'data' => [
                        'type' => 'vendors',
                        'id' => (string) $product->vendor->getRouteKey(),
                    ],
                ],
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->patch($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseHas('products_package_products', [
            'id' => $product->getKey(),
            'name' => $product->name,
            'vendor_id' => $product->vendor_id,
        ]);
    }

    /** @test */
    public function get_error_when_update_non_existent_product(): void
    {
        $url = route('api.jsonapi.products-package.v1.products.update', ['product' => 'test']);

        $data = [
            'type' => 'products',
            'id' => 'test',
            'attributes' => [
                'name' => 'updated-name',
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('products')
            ->withData($data)
            ->patch($url);

        $response->assertNotFound();
    }

    /** @test */
    public function destroy_product(): void
    {
        $product = ProductModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.products.destroy', ['product' => $product->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->delete($url);

        $response->assertNoContent();

        $this->assertSoftDeleted('products_package_products', [
            'id' => $product->getKey(),
        ]);
    }

    /** @test */
    public function get_error_when_destroy_non_existent_product(): void
    {
        $url = route('api.jsonapi.products-package.v1.products.destroy', ['product' => 'test']);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->delete($url);

        $response->assertNotFound();
    }
}
