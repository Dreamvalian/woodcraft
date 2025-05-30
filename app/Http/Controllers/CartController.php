<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart(Auth::id());
        return view('cart.index', [
            'cart' => $cart->load('items.product'),
            'summary' => $this->cartService->getCartSummary(Auth::id())
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'options' => 'nullable|array'
        ]);

        $result = $this->cartService->addToCart(
            $request->product_id,
            $request->quantity,
            Auth::id(),
            $request->options ?? []
        );

        if ($request->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->cartService->updateQuantity(
            $itemId,
            $request->quantity,
            Auth::id()
        );

        if ($request->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function remove($itemId)
    {
        $result = $this->cartService->removeFromCart($itemId, Auth::id());

        if (request()->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function clear()
    {
        $result = $this->cartService->clearCart(Auth::id());

        if (request()->ajax()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function summary()
    {
        return response()->json($this->cartService->getCartSummary(Auth::id()));
    }
} 