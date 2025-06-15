<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
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
			'full_name' => 'required|string|max:255',
			'phone' => 'required|string|max:20',
			'address_line1' => 'required|string|max:255',
			'address_line2' => 'nullable|string|max:255',
			'city' => 'required|string|max:100',
			'state' => 'required|string|max:100',
			'postal_code' => 'required|string|max:20',
			'country' => 'required|string|max:100',
			'shipping_method' => 'required|in:standard,express,overnight',
			'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet',
		]);

		$cart = Cart::where('user_id', auth()->id())->first();
		if (!$cart || $cart->items->isEmpty()) {
			return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
		}

		// Create shipping address
		$shippingAddress = Address::create([
			'user_id' => auth()->id(),
			'full_name' => $request->full_name,
			'phone' => $request->phone,
			'address_line1' => $request->address_line1,
			'address_line2' => $request->address_line2,
			'city' => $request->city,
			'state' => $request->state,
			'postal_code' => $request->postal_code,
			'country' => $request->country,
			'type' => 'shipping'
		]);

		// Create billing address (same as shipping for now)
		$billingAddress = Address::create([
			'user_id' => auth()->id(),
			'full_name' => $request->full_name,
			'phone' => $request->phone,
			'address_line1' => $request->address_line1,
			'address_line2' => $request->address_line2,
			'city' => $request->city,
			'state' => $request->state,
			'postal_code' => $request->postal_code,
			'country' => $request->country,
			'type' => 'billing'
		]);

		// Calculate shipping cost based on method
		$shippingCost = match ($request->shipping_method) {
			'standard' => config('shipping.standard_cost', 10.00),
			'express' => config('shipping.express_cost', 20.00),
			'overnight' => config('shipping.overnight_cost', 30.00),
			default => 0
		};

		// Create order
		$order = Order::create([
			'user_id' => auth()->id(),
			'order_number' => 'ORD-' . strtoupper(uniqid()),
			'status' => 'pending',
			'total' => $cart->subtotal + $shippingCost,
			'shipping_address_id' => $shippingAddress->id,
			'billing_address_id' => $billingAddress->id,
			'payment_method' => $request->payment_method,
			'payment_status' => 'pending',
			'shipping_method' => $request->shipping_method,
			'shipping_cost' => $shippingCost,
			'placed_at' => now(),
		]);

		// Create order items
		foreach ($cart->items as $item) {
			OrderItem::create([
				'order_id' => $order->id,
				'product_id' => $item->product_id,
				'quantity' => $item->quantity,
				'price' => $item->product->price,
				'total' => $item->subtotal,
				'options' => json_encode($item->options ?? [])
			]);
		}

		// Clear the cart
		$cart->items()->delete();
		$cart->delete();

		// Redirect to success page
		return redirect()->route('checkout.success', $order);
	}

	public function success(Order $order)
	{
		if ($order->user_id !== auth()->id()) {
			abort(403);
		}

		$order->load(['items.product', 'shippingAddress', 'billingAddress']);

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
			'formatted_total' => '$' . number_format($total, 2)
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
