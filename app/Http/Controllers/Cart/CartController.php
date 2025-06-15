<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the shopping cart contents.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->with(['items.product'])
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'status' => 'active'
            ]);
        }

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:' . $product->min_order_quantity,
                'max:' . min($product->max_order_quantity, $product->stock)
            ]
        ]);

        try {
            DB::beginTransaction();

            // Get or create cart
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();

            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => Auth::id(),
                    'session_id' => session()->getId(),
                    'status' => 'active'
                ]);
            }

            // Check if product already exists in cart
            $cartItem = $cart->items()
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // Update quantity if product exists
                $newQuantity = $cartItem->quantity + $request->quantity;

                if ($newQuantity > $product->stock) {
                    throw new \Exception('Not enough stock available. Only ' . $product->stock . ' items left.');
                }

                if ($newQuantity > $product->max_order_quantity) {
                    throw new \Exception('Maximum order quantity is ' . $product->max_order_quantity . ' items.');
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $product->price
                ]);
            } else {
                // Add new item if product doesn't exist
                if ($request->quantity > $product->stock) {
                    throw new \Exception('Not enough stock available. Only ' . $product->stock . ' items left.');
                }

                if ($request->quantity < $product->min_order_quantity) {
                    throw new \Exception('Minimum order quantity is ' . $product->min_order_quantity . ' items.');
                }

                if ($request->quantity > $product->max_order_quantity) {
                    throw new \Exception('Maximum order quantity is ' . $product->max_order_quantity . ' items.');
                }

                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                    'options' => []
                ]);
            }

            DB::commit();

            return back()->with('success', 'Item added to cart successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update product quantity in the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->firstOrFail();

            $cartItem = $cart->items()->findOrFail($itemId);
            $product = $cartItem->product;

            if ($request->quantity > $product->stock) {
                throw new \Exception('Not enough stock available. Only ' . $product->stock . ' items left.');
            }

            if ($request->quantity > 0) {
                if ($request->quantity < $product->min_order_quantity) {
                    throw new \Exception('Minimum order quantity is ' . $product->min_order_quantity . ' items.');
                }

                if ($request->quantity > $product->max_order_quantity) {
                    throw new \Exception('Maximum order quantity is ' . $product->max_order_quantity . ' items.');
                }

                $cartItem->update([
                    'quantity' => $request->quantity,
                    'price' => $product->price
                ]);
            } else {
                $cartItem->delete();
            }

            DB::commit();

            return back()->with('success', 'Cart updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove a specific product from the cart.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($itemId)
    {
        try {
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->firstOrFail();

            $cartItem = $cart->items()->findOrFail($itemId);
            $cartItem->delete();

            return back()->with('success', 'Item removed from cart successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove item from cart.');
        }
    }

    /**
     * Clear all items from the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        try {
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->firstOrFail();

            $cart->items()->delete();
            $cart->delete();

            return back()->with('success', 'Cart cleared successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear cart.');
        }
    }
}