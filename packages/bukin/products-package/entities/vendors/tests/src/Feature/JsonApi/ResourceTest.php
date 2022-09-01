<?php

namespace Bukin\ProductsPackage\Vendors\Tests\Feature\JsonApi;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModel;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModel;
use Bukin\ProductsPackage\Vendors\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use LaravelJsonApi\Testing\MakesJsonApiRequests;

class ResourceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use MakesJsonApiRequests;

    /** @test */
    function index_endpoint(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response->assertFetchedMany($vendors);
    }

    /** @test */
    function index_endpoint_with_empty_response(): void
    {
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function index_endpoint_with_id_sort_asc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('id')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortBy('id'));
    }

    /** @test */
    function index_endpoint_with_id_sort_desc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('-id')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortByDesc('id'));
    }

    /** @test */
    function index_endpoint_with_created_at_sort_asc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('createdAt')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortBy('created_at'));
    }

    /** @test */
    function index_endpoint_with_created_at_sort_desc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('-createdAt')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortByDesc('created_at'));
    }

    /** @test */
    function index_endpoint_with_updated_at_sort_asc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('updatedAt')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortBy('updated_at'));
    }

    /** @test */
    function index_endpoint_with_updated_at_sort_desc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('-updatedAt')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortByDesc('updated_at'));
    }

    /** @test */
    function index_endpoint_with_name_sort_asc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('name')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortBy('name'));
    }

    /** @test */
    function index_endpoint_with_name_sort_desc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('-name')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortByDesc('name'));
    }

    /** @test */
    function index_endpoint_with_code_sort_asc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('code')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortBy('code'));
    }

    /** @test */
    function index_endpoint_with_code_sort_desc(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sort('-code')
            ->get($url);

        $response->assertFetchedManyInOrder($vendors->sortByDesc('code'));
    }

    /** @test */
    function index_endpoint_with_id_filter(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['id' => [$vendors->first()->id]])
            ->get($url);

        $response->assertFetchedMany([$vendors->first()]);
    }

    /** @test */
    function index_endpoint_with_id_filter_empty_response(): void
    {
        VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['id' => ['test']])
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function index_endpoint_with_code_filter(): void
    {
        $vendors = VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['code' => $vendors->first()->code])
            ->get($url);

        $response->assertFetchedOne($vendors->first());
    }

    /** @test */
    function index_endpoint_with_code_filter_empty_response(): void
    {
        VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['code' => 'test'])
            ->get($url);

        $response->assertFetchedNull();
    }

    /** @test */
    function index_endpoint_with_suggestion_filter(): void
    {
        VendorModel::factory(5)->create();

        $firstExpectedVendor = VendorModel::factory()->create([
            'name' => 'suggestion_test'
        ]);
        $secondExpectedVendor = VendorModel::factory()->create([
            'code' => 'suggestion_test'
        ]);

        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['suggestion' => 'suggestion_test'])
            ->get($url);

        $response->assertFetchedMany([$firstExpectedVendor, $secondExpectedVendor]);
    }

    /** @test */
    function index_endpoint_with_suggestion_filter_empty_response(): void
    {
        VendorModel::factory(5)->create();
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['suggestion' => 'suggestion_test'])
            ->get($url);

        $response->assertFetchedNone();
    }

    /** @test */
    function get_error_when_index_endpoint_with_invalid_filter(): void
    {
        $url = route('api.jsonapi.products-package.v1.vendors.index');

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->filter(['test' => 'test'])
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'filter'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function show_vendor_without_products(): void
    {
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response
            ->assertFetchedOne($vendor)
            ->assertDoesntHaveIncluded();
    }

    /** @test */
    public function show_vendor_with_include_products(): void
    {
        $products = ProductModel::factory()->count(5);
        $vendor = VendorModel::factory()->has($products, 'products')->create();

        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->includePaths('products')
            ->get($url);

        $response
            ->assertFetchedOne($vendor)
            ->assertIncluded($vendor->products->map(fn(ProductModel $product) => [
                'type' => 'products',
                'id' => $product->id,
            ])->all());
    }

    /** @test */
    public function get_error_when_show_vendor_with_invalid_include(): void
    {
        $products = ProductModel::factory()->count(5);
        $vendor = VendorModel::factory()->has($products, 'products')->create();

        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->includePaths('invalid_relation')
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'include'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function show_vendor_with_sparse_fields(): void
    {
        $vendor = VendorModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $expected = [
            'type' => 'vendors',
            'id' => (string) $vendor->getRouteKey(),
            'attributes' => [
                'code' => $vendor->code,
                'name' => $vendor->name,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sparseFields('vendors', ['code', 'name'])
            ->get($url);

        $response->assertFetchedOneExact($expected);
    }

    /** @test */
    public function show_vendor_with_sparse_products_relation(): void
    {
        $products = ProductModel::factory()->count(5);
        $vendor = VendorModel::factory()->has($products, 'products')->create();

        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->includePaths('products')
            ->sparseFields('vendors', ['products'])
            ->get($url);

        $response
            ->assertFetchedOne($vendor)
            ->assertIncluded($vendor->products->map(fn(ProductModel $product) => [
                'type' => 'products',
                'id' => $product->id,
            ])->all());
    }

    /** @test */
    function get_error_when_show_vendor_with_invalid_field(): void
    {
        $vendor = VendorModel::factory()->create();

        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->sparseFields('vendors', ['test'])
            ->get($url);

        $response->assertErrorStatus([
            'source' => ['parameter' => 'fields'],
            'status' => '400',
            'title' => 'Invalid Query Parameter',
        ]);
    }

    /** @test */
    public function get_error_when_show_non_existent_vendor(): void
    {
        $url = route('api.jsonapi.products-package.v1.vendors.show', ['vendor' => 'test']);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->get($url);

        $response->assertNotFound();
    }

    /** @test */
    public function store_vendor(): void
    {
        $vendor = VendorModel::factory()->make();
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $this->assertDatabaseHas('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_without_id(): void
    {
        $vendor = VendorModel::factory()->make();
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/id'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_with_incorrect_id(): void
    {
        $vendor = VendorModel::factory()->make();
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => 'test',
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/id'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_without_name(): void
    {
        $vendor = VendorModel::factory()->make();
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_with_long_name(): void
    {
        $vendor = VendorModel::factory()->make([
            'name' => $this->faker->text(500),
        ]);
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_without_code(): void
    {
        $vendor = VendorModel::factory()->make();
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'name' => $vendor->name,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/code'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_with_long_code(): void
    {
        $vendor = VendorModel::factory()->make([
            'code' => $this->faker->text(500),
        ]);
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/code'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_store_vendor_with_non_unique_code(): void
    {
        $existsVendor = VendorModel::factory()->create();
        $vendor = VendorModel::factory()->make([
            'code' => $existsVendor->code,
        ]);
        $url = route('api.jsonapi.products-package.v1.vendors.store');

        $id = Str::uuid();

        $data = [
            'type' => 'vendors',
            'id' => $id,
            'attributes' => [
                'name' => $vendor->name,
                'code' => $vendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->post($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/code'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseMissing('products_package_vendors', [
            'id' => $id,
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function update_vendor(): void
    {
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.update', ['vendor' => $vendor->getRouteKey()]);

        $data = [
            'type' => 'vendors',
            'id' => (string) $vendor->getRouteKey(),
            'attributes' => [
                'name' => 'updated-name',
                'code' => 'updated-code',
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->patch($url);

        $response->assertFetchedOne($vendor);

        $this->assertDatabaseHas('products_package_vendors', [
            'id' => $vendor->getKey(),
            'name' => $data['attributes']['name'],
            'code' => $data['attributes']['code'],
        ]);
    }

    /** @test */
    public function get_error_when_update_vendor_with_long_name(): void
    {
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.update', ['vendor' => $vendor->getRouteKey()]);

        $data = [
            'type' => 'vendors',
            'id' => (string) $vendor->getRouteKey(),
            'attributes' => [
                'name' => $this->faker->text(500),
                'code' => 'updated-code',
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->patch($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/name'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseHas('products_package_vendors', [
            'id' => $vendor->getKey(),
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_update_vendor_with_long_code(): void
    {
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.update', ['vendor' => $vendor->getRouteKey()]);

        $data = [
            'type' => 'vendors',
            'id' => (string) $vendor->getRouteKey(),
            'attributes' => [
                'name' => 'updated-name',
                'code' => $this->faker->text(500),
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->patch($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/code'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseHas('products_package_vendors', [
            'id' => $vendor->getKey(),
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_update_vendor_with_non_unique_code(): void
    {
        $existsVendor = VendorModel::factory()->create();
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.update', ['vendor' => $vendor->getRouteKey()]);

        $data = [
            'type' => 'vendors',
            'id' => (string) $vendor->getRouteKey(),
            'attributes' => [
                'name' => 'updated-name',
                'code' => $existsVendor->code,
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->patch($url);

        $response->assertErrorStatus([
            'source' => ['pointer' => '/data/attributes/code'],
            'status' => '422',
            'title' => 'Unprocessable Entity',
        ]);

        $this->assertDatabaseHas('products_package_vendors', [
            'id' => $vendor->getKey(),
            'name' => $vendor->name,
            'code' => $vendor->code,
        ]);
    }

    /** @test */
    public function get_error_when_update_non_existent_vendor(): void
    {
        $url = route('api.jsonapi.products-package.v1.vendors.update', ['vendor' => 'test']);

        $data = [
            'type' => 'vendors',
            'id' => 'test',
            'attributes' => [
                'name' => 'updated-name',
                'code' => 'updated-code',
            ],
        ];

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->expects('vendors')
            ->withData($data)
            ->patch($url);

        $response->assertNotFound();
    }

    /** @test */
    public function destroy_vendor(): void
    {
        $vendor = VendorModel::factory()->create();
        $url = route('api.jsonapi.products-package.v1.vendors.destroy', ['vendor' => $vendor->getRouteKey()]);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->delete($url);

        $response->assertNoContent();

        $this->assertSoftDeleted('products_package_vendors', [
            'id' => $vendor->getKey(),
        ]);
    }

    /** @test */
    public function get_error_when_destroy_non_existent_vendor(): void
    {
        $url = route('api.jsonapi.products-package.v1.vendors.destroy', ['vendor' => 'test']);

        $response = $this
            ->actingAs($this->getUserWithRole('admin'))
            ->jsonApi()
            ->delete($url);

        $response->assertNotFound();
    }
}
