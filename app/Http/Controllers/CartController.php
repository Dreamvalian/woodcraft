<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $shopId => $quantity) {
            $shop = Shop::find($shopId);
            if ($shop) {
                $items[] = [
                    'shop' => $shop,
                    'quantity' => $quantity,
                    'subtotal' => $shop->price * $quantity
                ];
                $total += $shop->price * $quantity;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $shop = Shop::findOrFail($request->shop_id);
        
        if ($shop->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = Session::get('cart', []);
        
        if (isset($cart[$shop->id])) {
            $cart[$shop->id] += $request->quantity;
        } else {
            $cart[$shop->id] = $request->quantity;
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Item added to cart successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $shop = Shop::findOrFail($request->shop_id);
        $cart = Session::get('cart', []);

        if ($request->quantity > $shop->stock) {
            return back()->with('error', 'Not enough stock available.');
        }

        if ($request->quantity > 0) {
            $cart[$shop->id] = $request->quantity;
        } else {
            unset($cart[$shop->id]);
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove($shopId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$shopId])) {
            unset($cart[$shopId]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart successfully.');
    }

    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    }
} 