<?php

namespace App\Http\Controllers; // Keep this namespace if your file is at app/Http/Controllers/CartController.php

use App\Models\Product; // Assuming 'Shop' should be 'Product' based on previous context
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Added for better error logging

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $total = 0;

        // Fetch products that are actually in the cart from the database
        // This prevents issues if product details change or if a product is deleted
        $productIds = array_keys($cart);
        $productsInCart = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $productId => $quantity) {
            $product = $productsInCart->get($productId);

            if ($product) { // Ensure product still exists in DB
                // Use the effective_price if available, otherwise just price
                $itemPrice = method_exists($product, 'getEffectivePriceAttribute') ? $product->effective_price : $product->price;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $itemPrice * $quantity
                ];
                $total += $itemPrice * $quantity;
            } else {
                // If product no longer exists, remove it from session cart
                unset($cart[$productId]);
                Session::put('cart', $cart); // Update session immediately
                Log::warning("Product ID {$productId} found in session cart but not in database. Removed from cart.");
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Changed to product_id, shops table to products table
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id); // Changed to Product model

        // Check stock based on *current* quantity in cart + new quantity
        $cart = Session::get('cart', []);
        $currentCartQuantity = $cart[$product->id] ?? 0;
        $requestedQuantity = $request->quantity;
        $newTotalQuantity = $currentCartQuantity + $requestedQuantity;

        if ($product->stock < $newTotalQuantity) {
            return back()->with('error', 'Not enough stock available for the requested quantity. Current stock: ' . $product->stock);
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id] = $newTotalQuantity; // Update to new total
        } else {
            $cart[$product->id] = $requestedQuantity;
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Item added to cart successfully.');
    }

    /**
     * Update product quantity in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id', // Changed to product_id
            'quantity' => 'required|integer|min:0' // 0 quantity will remove the item
        ]);

        $product = Product::findOrFail($request->product_id); // Changed to Product model
        $cart = Session::get('cart', []);

        if ($request->quantity > $product->stock) { // Check against product's total stock
            return back()->with('error', 'Not enough stock available for this quantity. Max allowed: ' . $product->stock);
        }

        if ($request->quantity > 0) {
            $cart[$product->id] = $request->quantity;
        } else {
            // Quantity is 0, so remove the item
            unset($cart[$product->id]);
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a specific product from the cart.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($productId) // Changed parameter name to productId
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) { // Use productId directly
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return back()->with('success', 'Item removed from cart successfully.');
        }

        return back()->with('error', 'Item not found in cart.'); // More specific error
    }

    /**
     * Clear all items from the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    }
}