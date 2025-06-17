<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class OrderController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$orders = auth()->user()->orders()
			->with(['items.product', 'shippingAddress', 'billingAddress'])
			->latest('placed_at')
			->paginate(10);

		return view('user.orders.index', compact('orders'));
	}

	public function show(Order $order)
	{
		// Ensure the user can only view their own orders
		if ($order->user_id !== auth()->id()) {
			abort(403);
		}

		$order->load(['items.product', 'shippingAddress', 'billingAddress']);

		return view('user.orders.show', compact('order'));
	}

	public function cancel(Order $order)
	{
		// Ensure the user can only cancel their own orders
		if ($order->user_id !== auth()->id()) {
			abort(403);
		}

		// Only allow cancellation of pending or processing orders
		if (!in_array($order->status, ['pending', 'processing'])) {
			return back()->with('error', 'This order cannot be cancelled.');
		}

		$order->update([
			'status' => 'cancelled',
			'notes' => $order->notes . "\nOrder cancelled by customer on " . now()->format('Y-m-d H:i:s')
		]);

		return redirect()->route('orders.show', $order)
			->with('success', 'Order has been cancelled successfully.');
	}

	public function track(Order $order)
	{
		$this->authorize('view', $order);

		$order->load(['orderItems.product']);

		return view('orders.track', compact('order'));
	}

	public function downloadInvoice(Order $order)
	{
		$this->authorize('view', $order);

		$order->load(['orderItems.product', 'user']);

		// Generate PDF invoice
		$pdf = PDF::loadView('orders.invoice', compact('order'));

		return $pdf->download("invoice-{$order->order_number}.pdf");
	}
}