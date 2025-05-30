<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderStatusUpdated;
use App\Notifications\ProductBackInStock;
use App\Notifications\PriceDropAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        auth()->user()->notifications()->where('id', $id)->markAsRead();
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function delete($id)
    {
        auth()->user()->notifications()->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Notification deleted.');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return redirect()->back()->with('success', 'All notifications cleared.');
    }

    // Admin methods for sending notifications
    public function notifyOrderStatus(Order $order)
    {
        $this->authorize('manage', Order::class);

        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->back()
            ->with('success', 'Order status notification sent successfully.');
    }

    public function notifyBackInStock(Product $product)
    {
        $this->authorize('manage', Product::class);

        // Get users who have this product in their wishlist
        $users = User::whereHas('wishlist', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->get();

        Notification::send($users, new ProductBackInStock($product));

        return redirect()->back()
            ->with('success', 'Back in stock notifications sent successfully.');
    }

    public function notifyPriceDrop(Product $product, $oldPrice)
    {
        $this->authorize('manage', Product::class);

        // Get users who have this product in their wishlist
        $users = User::whereHas('wishlist', function ($query) use ($product) {
            $query->where('product_id', $product->id);
        })->get();

        Notification::send($users, new PriceDropAlert($product, $oldPrice));

        return redirect()->back()
            ->with('success', 'Price drop notifications sent successfully.');
    }

    public function preferences()
    {
        $preferences = auth()->user()->notification_preferences ?? [
            'order_updates' => true,
            'price_drops' => true,
            'back_in_stock' => true,
            'promotions' => true
        ];

        return view('notifications.preferences', compact('preferences'));
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'order_updates' => 'boolean',
            'price_drops' => 'boolean',
            'back_in_stock' => 'boolean',
            'promotions' => 'boolean'
        ]);

        auth()->user()->update([
            'notification_preferences' => $validated
        ]);

        return redirect()->back()
            ->with('success', 'Notification preferences updated successfully.');
    }
} 