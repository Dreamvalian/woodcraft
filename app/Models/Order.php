<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total',
        'shipping_address_id',
        'billing_address_id',
        'payment_method',
        'payment_status',
        'shipping_method',
        'shipping_cost',
        'notes',
        'placed_at',
        'paid_at',
        'payment_transaction_id',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
        'paid_at' => 'datetime',
        'total' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format($this->total - $this->shipping_cost, 2);
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total, 2);
    }

    public function getFormattedShippingCostAttribute(): string
    {
        return '$' . number_format($this->shipping_cost, 2);
    }
}