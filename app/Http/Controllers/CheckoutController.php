<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\NotificationService;

class CheckoutController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Address::where('user_id', auth()->id())->get();

        // Define shipping costs
        $standardShippingCost = 5.00;
        $expressShippingCost = 10.00;
        $overnightShippingCost = 20.00;

        return view('checkout.index', compact(
            'cart',
            'addresses',
            'standardShippingCost',
            'expressShippingCost',
            'overnightShippingCost'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
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

            // Calculate shipping cost based on method
            $shippingCost = $this->calculateShippingCost($request->shipping_method);

            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'shipping_address_id' => $request->address_id,
                'billing_address_id' => $request->address_id, // Using shipping address as billing address
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'subtotal' => $cart->subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $cart->subtotal + $shippingCost,
                'status' => 'pending',
                'payment_status' => 'pending',
                'placed_at' => now(),
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $item->quantity * $item->product->price,
                    'options' => $item->options ?? null,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create notification for order creation
            $this->notificationService->create(
                auth()->id(),
                'order_created',
                $this->notificationService->getOrderNotificationData($order)
            );

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    public function saveAddress(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:shipping,billing',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        $address = Address::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        if ($validated['is_default']) {
            Address::where('user_id', auth()->id())
                ->where('id', '!=', $address->id)
                ->where('type', $validated['type'])
                ->update(['is_default' => false]);
        }

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function calculateShipping(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_method' => 'required|in:standard,express,overnight',
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 400);
        }

        $shippingCost = $this->calculateShippingCost($validated['shipping_method']);
        $total = $cart->subtotal + $shippingCost;

        return response()->json([
            'success' => true,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.')
        ]);
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
