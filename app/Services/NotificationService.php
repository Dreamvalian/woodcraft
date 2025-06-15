<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
  public function create($userId, $type, $data)
  {
    return Notification::create([
      'user_id' => $userId,
      'type' => $type,
      'data' => $data
    ]);
  }

  public function getUnreadNotifications($userId): Collection
  {
    return Notification::where('user_id', $userId)
      ->unread()
      ->latest()
      ->get();
  }

  public function getAllNotifications($userId): Collection
  {
    return Notification::where('user_id', $userId)
      ->latest()
      ->get();
  }

  public function markAsRead($notificationId): Notification
  {
    $notification = Notification::findOrFail($notificationId);
    $notification->markAsRead();
    return $notification;
  }

  public function markAllAsRead($userId): int
  {
    return Notification::where('user_id', $userId)
      ->unread()
      ->update(['read_at' => now()]);
  }

  public function delete($notificationId): bool
  {
    return Notification::findOrFail($notificationId)->delete();
  }

  public function deleteAll($userId): int
  {
    return Notification::where('user_id', $userId)->delete();
  }

  public function getOrderNotificationData($order): array
  {
    return [
      'order_id' => $order->id,
      'order_number' => $order->order_number,
      'total' => $order->formatted_total,
      'status' => $order->status,
      'created_at' => $order->created_at->format('Y-m-d H:i:s')
    ];
  }

  public function getUnreadCount($userId): int
  {
    return Notification::where('user_id', $userId)
      ->unread()
      ->count();
  }

  public function getNotificationTypes(): array
  {
    return [
      'order_created' => 'New Order',
      'order_status_updated' => 'Order Status Updated',
      'payment_received' => 'Payment Received',
      'shipping_updated' => 'Shipping Update',
      'product_back_in_stock' => 'Product Back in Stock',
      'price_drop' => 'Price Drop Alert',
      'review_request' => 'Review Request',
      'wishlist_item_on_sale' => 'Wishlist Item on Sale'
    ];
  }
}