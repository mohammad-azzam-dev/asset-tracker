<?php

namespace App\Models;

use App\Casts\EncryptedCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'stock_type',
        'purchase_price',
        'quantity',
        'unit',
        'purchase_date',
        'notes',
    ];

    protected $casts = [
        'stock_type_data' => EncryptedCast::class,
        'purchase_price_data' => EncryptedCast::class,
        'quantity_data' => EncryptedCast::class,
        'unit_data' => EncryptedCast::class,
        'purchase_date_data' => EncryptedCast::class,
        'notes_data' => EncryptedCast::class,
    ];

    // Accessor for stock_type - reads from encrypted column
    public function getStockTypeAttribute(): ?string
    {
        return $this->stock_type_data;
    }

    // Mutator for stock_type - writes to encrypted column
    public function setStockTypeAttribute($value): void
    {
        $this->attributes['stock_type_data'] = $value ? app(EncryptedCast::class)->set($this, 'stock_type_data', $value, $this->attributes) : null;
    }

    // Accessor for purchase_price
    public function getPurchasePriceAttribute(): ?float
    {
        return $this->purchase_price_data ? (float) $this->purchase_price_data : null;
    }

    // Mutator for purchase_price
    public function setPurchasePriceAttribute($value): void
    {
        $this->attributes['purchase_price_data'] = $value !== null ? app(EncryptedCast::class)->set($this, 'purchase_price_data', $value, $this->attributes) : null;
    }

    // Accessor for quantity
    public function getQuantityAttribute(): ?float
    {
        return $this->quantity_data ? (float) $this->quantity_data : null;
    }

    // Mutator for quantity
    public function setQuantityAttribute($value): void
    {
        $this->attributes['quantity_data'] = $value !== null ? app(EncryptedCast::class)->set($this, 'quantity_data', $value, $this->attributes) : null;
    }

    // Accessor for unit
    public function getUnitAttribute(): ?string
    {
        return $this->unit_data;
    }

    // Mutator for unit
    public function setUnitAttribute($value): void
    {
        $this->attributes['unit_data'] = $value ? app(EncryptedCast::class)->set($this, 'unit_data', $value, $this->attributes) : null;
    }

    // Accessor for purchase_date
    public function getPurchaseDateAttribute(): ?\Carbon\Carbon
    {
        return $this->purchase_date_data ? \Carbon\Carbon::parse($this->purchase_date_data) : null;
    }

    // Mutator for purchase_date
    public function setPurchaseDateAttribute($value): void
    {
        $dateValue = $value instanceof \Carbon\Carbon ? $value->format('Y-m-d') : $value;
        $this->attributes['purchase_date_data'] = $dateValue ? app(EncryptedCast::class)->set($this, 'purchase_date_data', $dateValue, $this->attributes) : null;
    }

    // Accessor for notes
    public function getNotesAttribute(): ?string
    {
        return $this->notes_data;
    }

    // Mutator for notes
    public function setNotesAttribute($value): void
    {
        $this->attributes['notes_data'] = $value ? app(EncryptedCast::class)->set($this, 'notes_data', $value, $this->attributes) : null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalValueAttribute(): float
    {
        return ($this->purchase_price ?? 0) * ($this->quantity ?? 0);
    }
}
