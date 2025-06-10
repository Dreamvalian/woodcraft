<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Address::where('user_id', auth()->id())->get();

        return view('checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|in:standard,express,overnight',
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'shipping_address_id' => $request->shipping_address_id,
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'subtotal' => $cart->subtotal,
                'shipping_cost' => $this->calculateShippingCost($request->shipping_method),
                'total' => $cart->subtotal + $this->calculateShippingCost($request->shipping_method),
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    private function calculateShippingCost($method)
    {
        $cost = 0;

        switch ($method) {
            case 'standard':
                $cost = 5.00;
                break;
            case 'express':
                $cost = 10.00;
                break;
            case 'overnight':
                $cost = 20.00;
                break;
            default:
                $cost = 5.00;
                break;
        }

        return $cost;
    }
}
