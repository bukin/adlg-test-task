<?php

namespace Bukin\ProductsPackage\Vendors\Domain\Entity;

use OwenIt\Auditing\Contracts\Auditable;

interface VendorModelContract extends Auditable
{
    const ENTITY_TYPE = 'products_package_vendor';

    const ENTITY_DESCRIPTION = 'Products vendor';
}
