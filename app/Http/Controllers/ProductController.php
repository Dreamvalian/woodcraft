<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartQuantityRequest;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    protected $cartService;
    protected const CACHE_TTL = 3600; // 1 hour
    protected const RATE_LIMIT_ATTEMPTS = 5;
    protected const RATE_LIMIT_DECAY = 60; // 1 minute

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('cache.headers:public;max_age=3600;etag')->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $cacheKey = 'products_' . md5($request->fullUrl());
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($request) {
            $query = Product::with(['category', 'reviews'])
                          ->withAvg('reviews', 'rating')
                          ->withCount('reviews');

            // Apply filters using scopes
            $this->applyFilters($query, $request);
            
            // Apply sorting
            $this->applySorting($query, $request);

            $products = $query->paginate(12)->withQueryString();
            
            // Get categories and materials for filters
            $categories = Category::withCount('products')->get();
            $materials = Product::distinct()->pluck('material')->filter();

            return view('products.index', compact('products', 'categories', 'materials'));
        });
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user', 'images']);
        
        // Get related products
        $relatedProducts = $this->getRelatedProducts($product);
        
        // Update recently viewed
        $this->updateRecentlyViewed($product);

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function addToCart(AddToCartRequest $request)
    {
        try {
            $this->checkRateLimit();

            $result = $this->cartService->addToCart(
                $request->product_id,
                $request->quantity,
                auth()->id()
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Add to cart failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart. Please try again.'
            ], 500);
        }
    }

    public function removeFromCart($id)
    {
        try {
            $result = $this->cartService->removeFromCart($id, auth()->id());
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Remove from cart failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart. Please try again.'
            ], 500);
        }
    }

    public function updateCartQuantity(UpdateCartQuantityRequest $request, $id)
    {
        try {
            $result = $this->cartService->updateCartQuantity(
                $id,
                $request->quantity,
                auth()->id()
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Update cart quantity failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart quantity. Please try again.'
            ], 500);
        }
    }

    public function quickView(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => Str::limit($product->description, 100),
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'formatted_price' => $product->formatted_price,
            'formatted_sale_price' => $product->formatted_sale_price,
            'discount_percentage' => $product->discount_percentage,
            'image_url' => $product->image_url,
            'min_order_quantity' => $product->min_order_quantity,
            'max_order_quantity' => $product->max_order_quantity,
            'stock' => $product->stock,
            'average_rating' => $product->average_rating,
            'total_reviews' => $product->total_reviews
        ]);
    }

    protected function applyFilters(Builder $query, Request $request): void
    {
        // Search
        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->get('category'));
        }

        // Price range filter
        if ($request->filled(['min_price', 'max_price'])) {
            $query->byPriceRange(
                $request->get('min_price'),
                $request->get('max_price')
            );
        }

        // Material filter
        if ($request->filled('material')) {
            $query->byMaterial($request->get('material'));
        }

        // Availability filter
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Active products only
        $query->active();
    }

    protected function applySorting(Builder $query, Request $request): void
    {
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }
    }

    protected function getRelatedProducts(Product $product)
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    protected function updateRecentlyViewed(Product $product): void
    {
        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Remove the current product if it exists
        $recentlyViewed = array_diff($recentlyViewed, [$product->id]);
        
        // Add the current product to the beginning
        array_unshift($recentlyViewed, $product->id);
        
        // Keep only the last 4 products
        $recentlyViewed = array_slice($recentlyViewed, 0, 4);
        
        session()->put('recently_viewed', $recentlyViewed);
    }

    protected function checkRateLimit(): void
    {
        $key = 'add-to-cart:' . (auth()->id() ?? request()->ip());
        
        if (RateLimiter::tooManyAttempts($key, self::RATE_LIMIT_ATTEMPTS)) {
            throw new \Exception('Too many attempts. Please try again later.');
        }
        
        RateLimiter::hit($key, self::RATE_LIMIT_DECAY);
    }
}
