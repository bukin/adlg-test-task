<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\Http\Controllers\Api;

use Bukin\AdminPanel\Base\Presentation\Http\Controllers\Controller;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Destroy\DestroyAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Store\StoreAction;
use Bukin\ProductsPackage\Vendors\Application\Actions\Resource\Update\UpdateAction;
use Bukin\ProductsPackage\Vendors\Application\Queries\FetchItemsByQueryAction;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource\DestroyRequest;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource\IndexRequest;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource\ShowRequest;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource\StoreRequest;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Requests\Api\Resource\UpdateRequest;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource\DestroyResponse;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource\IndexResponse;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource\ShowResponse;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource\StoreResponse;
use Bukin\ProductsPackage\Vendors\Presentation\Http\Responses\Api\Resource\UpdateResponse;

class ResourceController extends Controller
{
    public function index(IndexRequest $request, FetchItemsByQueryAction $action, IndexResponse $response): IndexResponse
    {
        return $this->process($request, $action, $response);
    }

    public function store(StoreRequest $request, StoreAction $action, StoreResponse $response): StoreResponse
    {
        return $this->process($request, $action, $response);
    }

    public function show(ShowRequest $request, FetchItemsByQueryAction $action, ShowResponse $response): ShowResponse
    {
        return $this->process($request, $action, $response);
    }

    public function update(UpdateRequest $request, UpdateAction $action, UpdateResponse $response): UpdateResponse
    {
        return $this->process($request, $action, $response);
    }

    public function destroy(DestroyRequest $request, DestroyAction $action, DestroyResponse $response): DestroyResponse
    {
        return $this->process($request, $action, $response);
    }
}
