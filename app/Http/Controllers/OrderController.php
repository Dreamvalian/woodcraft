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
        $orders = Order::with(['orderItems.product', 'orderItems.product.productImages'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['orderItems.product', 'orderItems.product.productImages', 'user']);

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()
                ->with('error', 'This order cannot be cancelled.');
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded'
            ]);

            // Restore product stock
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while cancelling the order. Please try again.');
        }
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