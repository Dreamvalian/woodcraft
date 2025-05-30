<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang boleh diisi (biar aman)
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'sku',
        'image',
        'model',
        'category_id',
        'features',
        'is_active',
        'weight',
        'dimensions',
        'material',
        'min_order_quantity',
        'max_order_quantity',
        'care_instructions',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'min_order_quantity' => 'integer',
        'max_order_quantity' => 'integer',
        'dimensions' => 'array',
    ];

    protected $appends = [
        'image_url',
        'formatted_price',
        'formatted_sale_price',
        'discount_percentage',
        'is_on_sale',
        'average_rating',
        'total_reviews',
    ];

    // Boot method for automatic slug generation
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Get the image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.jpg');
    }

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? 'Rp ' . number_format($this->sale_price, 0, ',', '.') : null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function discounts()
    {
        return $this->hasMany(ProductDiscount::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
                    ->whereColumn('sale_price', '<', 'price');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByMaterial($query, $material)
    {
        return $query->where('material', $material);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('material', 'like', "%{$search}%");
        });
    }

    // Methods
    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function hasEnoughStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    public function updateStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

    public function restoreStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }
}
