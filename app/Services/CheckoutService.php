<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function validateCart($userId)
    {
        $cart = $this->cartService->getCart($userId);
        
        if ($cart->isEmpty()) {
            throw new \Exception('Your cart is empty.');
        }

        if (!$cart->hasStock()) {
            throw new \Exception('Some items in your cart are out of stock.');
        }

        return true;
    }

    public function createOrder($userId, $data)
    {
        try {
            DB::beginTransaction();

            // Validate cart
            $this->validateCart($userId);

            // Get cart
            $cart = $this->cartService->getCart($userId);

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'total' => $cart->total,
                'shipping_address_id' => $data['shipping_address_id'],
                'billing_address_id' => $data['billing_address_id'] ?? $data['shipping_address_id'],
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'shipping_method' => $data['shipping_method'],
                'shipping_cost' => $data['shipping_cost'],
                'notes' => $data['notes'] ?? null,
                'placed_at' => now(),
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->subtotal,
                    'options' => $item->options,
                ]);

                // Update product stock
                $item->product->updateStock($item->quantity);
            }

            // Clear cart
            $this->cartService->clearCart($userId);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Order created successfully.',
                'order' => $order->load(['items.product', 'shippingAddress', 'billingAddress'])
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create order failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function processPayment($order, $paymentData)
    {
        try {
            DB::beginTransaction();

            // Mock payment processing
            $paymentSuccess = true; // In real implementation, integrate with payment gateway

            if ($paymentSuccess) {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'payment_transaction_id' => 'MOCK-' . Str::random(10),
                    'paid_at' => now(),
                ]);

                DB::commit();

                return [
                    'success' => true,
                    'message' => 'Payment processed successfully.',
                    'order' => $order->fresh()
                ];
            }

            throw new \Exception('Payment processing failed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Process payment failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function calculateShippingCost($address, $items)
    {
        // Mock shipping calculation
        // In real implementation, integrate with shipping provider
        $baseCost = 10.00;
        $weightCost = collect($items)->sum(function ($item) {
            return $item->product->weight * $item->quantity;
        }) * 0.5;

        return $baseCost + $weightCost;
    }

    public function getOrderSummary($userId)
    {
        $cart = $this->cartService->getCart($userId);
        $cartSummary = $this->cartService->getCartSummary($userId);

        return [
            'subtotal' => $cart->total,
            'formatted_subtotal' => $cart->formatted_total,
            'shipping_cost' => 0, // Will be calculated when shipping address is selected
            'total' => $cart->total,
            'formatted_total' => $cart->formatted_total,
            'items' => $cartSummary['items'],
        ];
    }
} 