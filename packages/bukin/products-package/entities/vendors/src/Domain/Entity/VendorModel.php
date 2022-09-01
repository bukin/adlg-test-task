<?php

namespace Bukin\ProductsPackage\Vendors\Domain\Entity;

use Bukin\ProductsPackage\Products\Domain\Entity\ProductModelContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\AdminPanel\Base\Models\Traits\HasUuidPrimaryKey;
use OwenIt\Auditing\Auditable;

class VendorModel extends Model implements VendorModelContract
{
    use Auditable;
    use HasFactory;
    use HasUuidPrimaryKey;
    use SoftDeletes;

    protected bool $auditTimestamps = true;

    protected $table = 'products_package_vendors';

    protected $fillable = [
        'name',
        'code',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function products(): HasMany
    {
        $productModel = resolve(ProductModelContract::class);

        return $this->hasMany(get_class($productModel), 'vendor_id', 'id');
    }

    protected static function newFactory(): VendorFactory
    {
        return VendorFactory::new();
    }
}
