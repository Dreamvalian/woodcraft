<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CartService
{
    public function addToCart(int $productId, int $quantity, ?int $userId = null): array
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            return [
                'success' => false,
                'message' => 'Sorry, we don\'t have enough stock.'
            ];
        }

        $sessionId = session()->get('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::random(40);
            session()->put('cart_session_id', $sessionId);
        }

        $cartItem = Cart::where('product_id', $productId)
            ->where(function ($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'session_id' => $sessionId
            ]);
        }

        // Clear cart cache
        $this->clearCartCache($userId, $sessionId);

        return [
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cartCount' => $this->getCartCount($userId, $sessionId)
        ];
    }

    public function removeFromCart(int $cartItemId, ?int $userId = null): array
    {
        $cartItem = Cart::where('id', $cartItemId)
            ->where(function ($query) use ($userId) {
                $query->where('session_id', session()->get('cart_session_id'));
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->firstOrFail();

        $cartItem->delete();

        // Clear cart cache
        $this->clearCartCache($userId, session()->get('cart_session_id'));

        return [
            'success' => true,
            'message' => 'Product removed from cart successfully.',
            'cartCount' => $this->getCartCount($userId, session()->get('cart_session_id'))
        ];
    }

    public function updateCartQuantity(int $cartItemId, int $quantity, ?int $userId = null): array
    {
        $cartItem = Cart::where('id', $cartItemId)
            ->where(function ($query) use ($userId) {
                $query->where('session_id', session()->get('cart_session_id'));
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })
            ->firstOrFail();

        if ($cartItem->product->stock < $quantity) {
            return [
                'success' => false,
                'message' => 'Sorry, we don\'t have enough stock.'
            ];
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        // Clear cart cache
        $this->clearCartCache($userId, session()->get('cart_session_id'));

        return [
            'success' => true,
            'message' => 'Cart updated successfully.',
            'cartCount' => $this->getCartCount($userId, session()->get('cart_session_id'))
        ];
    }

    private function getCartCount(?int $userId, string $sessionId): int
    {
        $cacheKey = "cart_count:{$userId}:{$sessionId}";
        
        return Cache::remember($cacheKey, 3600, function () use ($userId, $sessionId) {
            return Cart::where(function ($query) use ($userId, $sessionId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })->sum('quantity');
        });
    }

    private function clearCartCache(?int $userId, string $sessionId): void
    {
        Cache::forget("cart_count:{$userId}:{$sessionId}");
    }
} 