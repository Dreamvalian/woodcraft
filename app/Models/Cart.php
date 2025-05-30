<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected $appends = [
        'total',
        'formatted_total',
        'item_count',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Accessors
    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getItemCountAttribute()
    {
        return $this->items->sum('quantity');
    }

    // Methods
    public static function getOrCreateCart($userId = null)
    {
        $sessionId = session()->getId();
        
        return static::firstOrCreate(
            [
                'user_id' => $userId,
                'session_id' => $sessionId,
                'status' => 'active'
            ]
        );
    }

    public function addItem($productId, $quantity = 1, $options = [])
    {
        $product = Product::findOrFail($productId);
        
        // Validate quantity
        if ($quantity < $product->min_order_quantity) {
            throw new \Exception('Quantity cannot be less than minimum order quantity.');
        }

        if ($quantity > $product->max_order_quantity) {
            throw new \Exception('Quantity cannot exceed maximum order quantity.');
        }

        if ($quantity > $product->stock) {
            throw new \Exception('Not enough stock available.');
        }

        // Check if product already exists in cart
        $existingItem = $this->items()
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            
            if ($newQuantity > $product->max_order_quantity) {
                throw new \Exception('Total quantity cannot exceed maximum order quantity.');
            }

            if ($newQuantity > $product->stock) {
                throw new \Exception('Not enough stock available.');
            }

            $existingItem->update(['quantity' => $newQuantity]);
            return $existingItem;
        }

        // Create new cart item
        return $this->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product->price,
            'options' => $options,
        ]);
    }

    public function updateItem($itemId, $quantity)
    {
        $item = $this->items()->findOrFail($itemId);
        return $item->updateQuantity($quantity);
    }

    public function removeItem($itemId)
    {
        return $this->items()->where('id', $itemId)->delete();
    }

    public function clear()
    {
        return $this->items()->delete();
    }

    public function mergeGuestCart($guestCart)
    {
        if (!$guestCart) {
            return;
        }

        foreach ($guestCart->items as $item) {
            try {
                $this->addItem($item->product_id, $item->quantity, $item->options);
            } catch (\Exception $e) {
                // Log error or handle it appropriately
                continue;
            }
        }

        $guestCart->delete();
    }

    public function isEmpty()
    {
        return $this->items->isEmpty();
    }

    public function hasStock()
    {
        foreach ($this->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return false;
            }
        }
        return true;
    }
} 