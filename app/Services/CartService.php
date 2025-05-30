<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function getCart($userId = null)
    {
        return Cart::getOrCreateCart($userId);
    }

    public function addToCart($productId, $quantity, $userId = null, $options = [])
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart($userId);
            $item = $cart->addItem($productId, $quantity, $options);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart' => $cart->load('items.product'),
                'item' => $item
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add to cart failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function updateQuantity($itemId, $quantity, $userId = null)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart($userId);
            $item = $cart->updateItem($itemId, $quantity);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Cart updated successfully.',
                'cart' => $cart->load('items.product'),
                'item' => $item
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update cart quantity failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function removeFromCart($itemId, $userId = null)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart($userId);
            $cart->removeItem($itemId);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Item removed from cart successfully.',
                'cart' => $cart->load('items.product')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Remove from cart failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to remove item from cart.'
            ];
        }
    }

    public function clearCart($userId = null)
    {
        try {
            DB::beginTransaction();

            $cart = $this->getCart($userId);
            $cart->clear();

            DB::commit();

            return [
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'cart' => $cart
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Clear cart failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to clear cart.'
            ];
        }
    }

    public function mergeGuestCart($userId)
    {
        try {
            DB::beginTransaction();

            $guestCart = Cart::where('session_id', session()->getId())
                           ->whereNull('user_id')
                           ->first();

            if ($guestCart) {
                $userCart = $this->getCart($userId);
                $userCart->mergeGuestCart($guestCart);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Guest cart merged successfully.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Merge guest cart failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to merge guest cart.'
            ];
        }
    }

    public function getCartSummary($userId = null)
    {
        $cart = $this->getCart($userId);
        
        return [
            'item_count' => $cart->item_count,
            'total' => $cart->total,
            'formatted_total' => $cart->formatted_total,
            'items' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                    'formatted_subtotal' => $item->formatted_subtotal,
                    'image_url' => $item->product->image_url,
                ];
            })
        ];
    }
} 