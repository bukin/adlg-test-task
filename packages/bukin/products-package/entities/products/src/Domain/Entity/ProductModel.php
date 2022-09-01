<?php

namespace Bukin\ProductsPackage\Products\Domain\Entity;

use Bukin\ProductsPackage\Vendors\Domain\Entity\VendorModelContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\AdminPanel\Base\Models\Traits\HasUuidPrimaryKey;
use OwenIt\Auditing\Auditable;

class ProductModel extends Model implements ProductModelContract
{
    use Auditable;
    use HasFactory;
    use HasUuidPrimaryKey;
    use SoftDeletes;

    protected bool $auditTimestamps = true;

    protected $table = 'products_package_products';

    protected $fillable = [
        'name',
        'vendor_id'
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

    public function vendor(): BelongsTo
    {
        $vendorModel = resolve(VendorModelContract::class);

        return $this->belongsTo(get_class($vendorModel), 'vendor_id', 'id');
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
