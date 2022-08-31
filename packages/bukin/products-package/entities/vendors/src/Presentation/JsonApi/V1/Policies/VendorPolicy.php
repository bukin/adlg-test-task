<?php

namespace Bukin\ProductsPackage\Vendors\Presentation\JsonApi\V1\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use InetStudio\ACL\Users\Contracts\Models\UserModelContract;
use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;

class VendorPolicy
{
    use HandlesAuthorization;

    public function viewAny(?UserModelContract $user)
    {
        return true;
    }

    public function view(?UserModelContract $user, VendorModelContract $vendor)
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

    public function delete(?UserModelContract $user, VendorModelContract $vendor)
    {
        return true;
    }

    public function viewProducts(?UserModelContract $user, VendorModelContract $vendor)
    {
        return true;
    }
}
