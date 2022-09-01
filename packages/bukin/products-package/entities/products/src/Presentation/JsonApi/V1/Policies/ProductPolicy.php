<?php

namespace Bukin\ProductsPackage\Products\Presentation\JsonApi\V1\Policies;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Illuminate\Auth\Access\HandlesAuthorization;
use InetStudio\ACL\Users\Contracts\Models\UserModelContract;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-view-any');
    }

    public function view(UserModelContract $user, ProductModelContract $product)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-view');
    }

    public function create(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-create');
    }

    public function update(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-update');
    }

    public function delete(UserModelContract $user, ProductModelContract $product)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-delete');
    }

    public function viewVendor(UserModelContract $user, ProductModelContract $product)
    {
        return $user->hasRole('admin') || $user->hasPermission('products-can-view-vendor');
    }
}
