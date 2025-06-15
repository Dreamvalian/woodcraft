<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'options',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'options' => 'array',
    ];

    protected $appends = [
        'subtotal',
        'formatted_subtotal',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedSubtotalAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    // Methods
    public function updateQuantity($quantity)
    {
        if ($quantity < $this->product->min_order_quantity) {
            throw new \Exception('Quantity cannot be less than minimum order quantity.');
        }

        if ($quantity > $this->product->max_order_quantity) {
            throw new \Exception('Quantity cannot exceed maximum order quantity.');
        }

        if ($quantity > $this->product->stock) {
            throw new \Exception('Not enough stock available.');
        }

        $this->update(['quantity' => $quantity]);
        return $this;
    }
}