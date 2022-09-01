<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1\Policies;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Illuminate\Auth\Access\HandlesAuthorization;
use InetStudio\ACL\Users\Contracts\Models\UserModelContract;

class VendorPolicy
{
    use HandlesAuthorization;

    public function viewAny(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-view-any');
    }

    public function view(UserModelContract $user, VendorModelContract $vendor)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-view');
    }

    public function create(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-create');
    }

    public function update(UserModelContract $user)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-update');
    }

    public function delete(UserModelContract $user, VendorModelContract $vendor)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-delete');
    }

    public function viewProducts(UserModelContract $user, VendorModelContract $vendor)
    {
        return $user->hasRole('admin') || $user->hasPermission('vendors-can-view-products');
    }
}
