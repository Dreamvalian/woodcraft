<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Product $product)
    {
        // Check if user has purchased the product
        $hasPurchased = $product->orders()
            ->whereHas('orderItems', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->exists();

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = $product->reviews()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this product.');
        }

        $review = $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => $hasPurchased,
            'is_approved' => !config('reviews.require_approval', false)
        ]);

        // Update product average rating
        $product->update([
            'average_rating' => $product->reviews()->avg('rating')
        ]);

        return redirect()->back()
            ->with('success', 'Review submitted successfully.' . 
                (!$review->is_approved ? ' It will be visible after approval.' : ''));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => !config('reviews.require_approval', false)
        ]);

        // Update product average rating
        $review->product->update([
            'average_rating' => $review->product->reviews()->avg('rating')
        ]);

        return redirect()->back()
            ->with('success', 'Review updated successfully.' . 
                (!$review->is_approved ? ' It will be visible after approval.' : ''));
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $product = $review->product;
        $review->delete();

        // Update product average rating
        $product->update([
            'average_rating' => $product->reviews()->avg('rating')
        ]);

        return redirect()->back()
            ->with('success', 'Review deleted successfully.');
    }

    public function approve(Review $review)
    {
        $this->authorize('moderate', Review::class);

        $review->update(['is_approved' => true]);

        return redirect()->back()
            ->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $this->authorize('moderate', Review::class);

        $review->update(['is_approved' => false]);

        return redirect()->back()
            ->with('success', 'Review rejected successfully.');
    }
} 