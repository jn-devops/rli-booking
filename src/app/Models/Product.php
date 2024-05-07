<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Data\ProductData;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Product
 *
 * @property int     $id
 * @property string  $sku
 * @property string  $type
 * @property string  $name
 * @property int     $processing_fee
 * @property string  $description
 * @property string  $category
 * @property int     $status
 * @property int     $unit_type
 * @property string  $brand
 * @property int     $price
 * @property string  $location
 * @property int     $floor_area
 * @property int     $lot_area
 * @property array   $url_links
 * @property array   $inventory
 * @property HasMany $inventories
 *
 * @method   int     getKey()
 */
class Product extends Model implements AttributableData
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['sku',  'type', 'name', 'processing_fee', 'category', 'status', 'unit_type', 'brand', 'price', 'location', 'floor_area', 'lot_area', 'inventory'];

    protected $appends  = ['type','category', 'status', 'unit_type', 'brand', 'price', 'location', 'floor_area', 'lot_area', 'url_links', 'inventory'];

    public function toData(): array
    {
        return ProductData::fromModel($this)->toArray();
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function getTypeAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('type');
    }

    public function setTypeAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('type', $value);

        return $this;
    }

    public function getCategoryAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('category');
    }

    public function setCategoryAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('category', $value);

        return $this;
    }

    public function getStatusAttribute(): ?bool
    {
        return (int) $this->getAttribute('meta')->get('status');
    }

    public function setStatusAttribute(int $value): static
    {
        $this->getAttribute('meta')->set('status', $value);

        return $this;
    }

    public function getUnitTypeAttribute(): string
    {
        return $this->getAttribute('meta')->get('unit_type');
    }

    public function setUnitTypeAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('unit_type', $value);

        return $this;
    }

    public function getBrandAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('brand');
    }

    public function setBrandAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('brand', $value);

        return $this;
    }

    public function getPriceAttribute(): ?int
    {
        return (int) $this->getAttribute('meta')->get('price');
    }

    public function setPriceAttribute(int $value): static
    {
        $this->getAttribute('meta')->set('price', $value);

        return $this;
    }

    public function getLocationAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('location');
    }

    public function setLocationAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('location', $value);

        return $this;
    }

    public function getFloorAreaAttribute(): ?int
    {
        return (int) $this->getAttribute('meta')->get('floor_area');
    }

    public function setFloorAreaAttribute(int $value): static
    {
        $this->getAttribute('meta')->set('floor_area', $value);

        return $this;
    }

    public function getLotAreaAttribute(): ?int
    {
        return (int) $this->getAttribute('meta')->get('lot_area');
    }

    public function setLotAreaAttribute(int $value): static
    {
        $this->getAttribute('meta')->set('lot_area', $value);

        return $this;
    }

    public function getUrlLinksAttribute(): ?array
    {
        return (array) $this->getAttribute('meta')->get('url_links');
    }

    public function setUrlLinksAttribute(array $value): static
    {
        $this->getAttribute('meta')->set('url_links', $value);

        return $this;
    }

    public function getInventoryAttribute(): ?array
    {
        return (array) $this->getAttribute('meta')->get('inventory');
    }

    public function setInventoryAttribute(array $value): static
    {
        $this->getAttribute('meta')->set('inventory', $value);

        return $this;
    }
}
