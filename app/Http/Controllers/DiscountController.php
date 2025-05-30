<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $discounts = ProductDiscount::with(['product'])
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->where('ends_at', '>=', now())
                    ->orWhereNull('ends_at');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('discounts.index', compact('discounts'));
    }

    public function apply(Request $request, Product $product)
    {
        $this->authorize('manage', ProductDiscount::class);

        $validated = $request->validate([
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Deactivate any existing active discounts for this product
            ProductDiscount::where('product_id', $product->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);

            // Create new discount
            $discount = $product->discounts()->create($validated);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Discount applied successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while applying the discount.');
        }
    }

    public function remove(ProductDiscount $discount)
    {
        $this->authorize('manage', $discount);

        $discount->update(['is_active' => false]);

        return redirect()->back()
            ->with('success', 'Discount removed successfully.');
    }

    public function update(Request $request, ProductDiscount $discount)
    {
        $this->authorize('manage', $discount);

        $validated = $request->validate([
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $discount->update($validated);

        return redirect()->back()
            ->with('success', 'Discount updated successfully.');
    }

    public function calculateDiscount(Product $product, $quantity = 1)
    {
        $discount = $product->activeDiscount;

        if (!$discount) {
            return 0;
        }

        $subtotal = $product->price * $quantity;

        if ($discount->min_purchase && $subtotal < $discount->min_purchase) {
            return 0;
        }

        $discountAmount = $discount->discount_type === 'percentage'
            ? ($subtotal * $discount->discount_value / 100)
            : $discount->discount_value;

        if ($discount->max_discount) {
            $discountAmount = min($discountAmount, $discount->max_discount);
        }

        return $discountAmount;
    }
} 