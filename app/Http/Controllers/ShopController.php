<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Cart;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartQuantityRequest;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
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
        $cacheKey = 'shops_' . md5($request->fullUrl());

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($request) {
            $query = Shop::query();

            // Apply filters using scopes
            $this->applyFilters($query, $request);

            // Apply sorting
            $this->applySorting($query, $request);

            /** @var \Illuminate\Pagination\LengthAwarePaginator $query */
            $shops = $query->paginate(12)->withQueryString();
            $materials = Shop::distinct()->pluck('material')->filter();

            // Only return data, not a view or closure!
            return [
                'shops' => $shops,
                'materials' => $materials,
            ];
        });

        // Now return the view with the cached data
        return view('shops.index', $data);
    }

    public function show(Shop $shop)
    {
        $shop->load(['images']);

        // Get related shops
        $relatedShops = $this->getRelatedShops($shop);

        // Update recently viewed
        $this->updateRecentlyViewed($shop);

        return view('shops.show', compact('shop', 'relatedShops'));
    }

    public function addToCart(AddToCartRequest $request)
    {
        try {
            $this->checkRateLimit();

            $result = $this->cartService->addToCart(
                $request->shop_id,
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
            $result = $this->cartService->updateQuantity(
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

    public function quickView(Shop $shop)
    {
        return response()->json([
            'id' => $shop->id,
            'name' => $shop->name,
            'description' => Str::limit($shop->description, 100),
            'price' => $shop->price,
            'formatted_price' => $shop->formatted_price,
            'image_url' => $shop->image_url,
            'stock' => $shop->stock
        ]);
    }

    protected function applyFilters(Builder $query, Request $request): void
    {
        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Price range filter
        if ($request->filled(['min_price', 'max_price'])) {
            $query->whereBetween('price', [
                $request->get('min_price'),
                $request->get('max_price')
            ]);
        }

        // Material filter
        if ($request->filled('material')) {
            $query->where('material', $request->get('material'));
        }

        // Availability filter
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Active shops only
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
            default:
                $query->latest();
                break;
        }
    }

    protected function getRelatedShops(Shop $shop)
    {
        return Shop::where('id', '!=', $shop->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
    }

    protected function updateRecentlyViewed(Shop $shop): void
    {
        $recentlyViewed = session()->get('recently_viewed', []);

        // Remove the current shop if it exists
        $recentlyViewed = array_diff($recentlyViewed, [$shop->id]);

        // Add the current shop to the beginning
        array_unshift($recentlyViewed, $shop->id);

        // Keep only the last 4 shops
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
