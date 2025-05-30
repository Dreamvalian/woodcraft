<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Category;

class ProductController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Show all products
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews']);

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->get('category')) {
            $query->where('category_id', $request->get('category'));
        }

        // Price range filter
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Material filter
        if ($request->has('material')) {
            $query->where('material', $request->get('material'));
        }

        // Availability filter
        if ($request->has('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sorting
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
                $query->withCount('reviews')
                      ->orderBy('reviews_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $materials = Product::distinct()->pluck('material')->filter();

        return view('products.index', compact('products', 'categories', 'materials'));
    }

    // Show product details
    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user', 'productImages']);
        
        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Get recently viewed products
        $recentlyViewed = session()->get('recently_viewed', []);
        if (!in_array($product->id, $recentlyViewed)) {
            array_unshift($recentlyViewed, $product->id);
            $recentlyViewed = array_slice($recentlyViewed, 0, 4);
            session()->put('recently_viewed', $recentlyViewed);
        }

        return view('products.show', compact('product', 'relatedProducts'));
    }

    // Add to cart
    public function addToCart(AddToCartRequest $request)
    {
        // Rate limiting
        $key = 'add-to-cart:' . (auth()->id() ?? request()->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many attempts. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key);

        $result = $this->cartService->addToCart(
            $request->product_id,
            $request->quantity,
            auth()->id()
        );

        return response()->json($result);
    }

    // Remove from cart
    public function removeFromCart($id)
    {
        $result = $this->cartService->removeFromCart($id, auth()->id());
        return response()->json($result);
    }

    // Update cart quantity
    public function updateCartQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $result = $this->cartService->updateCartQuantity(
            $id,
            $request->quantity,
            auth()->id()
        );

        return response()->json($result);
    }

    public function quickView(Product $product)
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'formatted_price' => $product->formatted_price,
            'image_url' => $product->image_url,
            'min_order_quantity' => $product->min_order_quantity,
            'max_order_quantity' => $product->max_order_quantity,
            'stock' => $product->stock
        ]);
    }
}
