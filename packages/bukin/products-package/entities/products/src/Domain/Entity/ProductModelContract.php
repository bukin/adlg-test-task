<?php

namespace Bukin\ProductsPackage\Products\Domain\Entity;

use OwenIt\Auditing\Contracts\Auditable;

interface ProductModelContract extends Auditable
{
    const ENTITY_TYPE = 'products_package_product';

    const ENTITY_DESCRIPTION = 'Product';
}
