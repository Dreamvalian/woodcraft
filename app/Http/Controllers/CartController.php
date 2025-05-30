<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Cart::with(['product.category', 'product.productImages'])
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCost = $this->calculateShippingCost($cartItems);
        $total = $subtotal + $shippingCost;

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:' . $product->min_order_quantity . '|max:' . min($product->stock, $product->max_order_quantity ?? 99)
        ]);

        // Check if product is in stock
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:' . $cart->product->min_order_quantity . '|max:' . min($cart->product->stock, $cart->product->max_order_quantity ?? 99)
        ]);

        // Check if product is in stock
        if ($cart->product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }

    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate stock availability
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Not enough stock available for {$item->product->name}.");
            }
        }

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $this->calculateTotal($cartItems),
                'shipping_address' => $request->shipping_address,
                'shipping_phone' => $request->shipping_phone,
                'shipping_name' => $request->shipping_name,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $this->calculateShippingCost($cartItems),
                'payment_method' => $request->payment_method,
                'notes' => $request->notes
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->product->price * $item->quantity
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    protected function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    protected function calculateShippingCost($cartItems)
    {
        // Implement your shipping cost calculation logic here
        // This is a simple example
        $totalWeight = $cartItems->sum(function ($item) {
            return $item->product->weight * $item->quantity;
        });

        return max(5, $totalWeight * 2); // Minimum $5, $2 per kg
    }
} 