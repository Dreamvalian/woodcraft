<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlistItems = Wishlist::with(['product.category', 'product.productImages'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Product $product)
    {
        // Check if product is already in wishlist
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('info', 'Product is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id
        ]);

        return redirect()->back()
            ->with('success', 'Product added to wishlist successfully.');
    }

    public function remove(Wishlist $wishlist)
    {
        $this->authorize('delete', $wishlist);
        
        $wishlist->delete();

        return redirect()->back()
            ->with('success', 'Product removed from wishlist successfully.');
    }

    public function moveToCart(Wishlist $wishlist)
    {
        $this->authorize('delete', $wishlist);

        // Add to cart
        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $wishlist->product_id
            ],
            [
                'quantity' => 1
            ]
        );

        // Remove from wishlist
        $wishlist->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Product moved to cart successfully.');
    }

    public function clear()
    {
        Wishlist::where('user_id', auth()->id())->delete();

        return redirect()->back()
            ->with('success', 'Wishlist cleared successfully.');
    }
} 