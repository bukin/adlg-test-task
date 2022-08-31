<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use InetStudio\ACL\Users\Contracts\Models\UserModelContract;
use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(?UserModelContract $user)
    {
        return true;
    }

    public function view(?UserModelContract $user, ProductModelContract $product)
    {
        return true;
    }

    public function create(?UserModelContract $user)
    {
        return true;
    }

    public function update(?UserModelContract $user)
    {
        return true;
    }

    public function delete(?UserModelContract $user, ProductModelContract $product)
    {
        return true;
    }

    public function viewVendor(?UserModelContract $user, ProductModelContract $product)
    {
        return true;
    }
}
