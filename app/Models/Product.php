<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use BelongsToTenant, HasFactory, HasTranslations, SoftDeletes;

    public array $translatable = ['name_translations', 'description_translations'];

    protected $fillable = [
        'company_id',
        'name_translations',
        'description_translations',
        'sku',
        'barcode',
        'category',
        'type',
        'sale_price',
        'cost_price',
        'min_stock',
        'is_active',
        'unit',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'name_translations' => 'array',
            'description_translations' => 'array',
            'is_active' => 'boolean',
            'sale_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
        ];
    }

    /** Convenience accessor for the current locale name */
    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->name_translations[$locale]
            ?? $this->name_translations['en']
            ?? '';
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function salesOrderItems(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
