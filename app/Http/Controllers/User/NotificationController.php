<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = $this->notificationService->getAllNotifications(auth()->id());
        $unreadCount = $this->notificationService->getUnreadCount(auth()->id());
        $notificationTypes = $this->notificationService->getNotificationTypes();

        return view('components.notifications', compact('notifications', 'unreadCount', 'notificationTypes'));
    }

    public function markAsRead($id)
    {
        try {
            $notification = $this->notificationService->markAsRead($id);
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => $this->notificationService->getUnreadCount(auth()->id())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $count = $this->notificationService->markAllAsRead(auth()->id());
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->notificationService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully',
                'unread_count' => $this->notificationService->getUnreadCount(auth()->id())
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 500);
        }
    }

    public function deleteAll()
    {
        try {
            $count = $this->notificationService->deleteAll(auth()->id());
            return response()->json([
                'success' => true,
                'message' => 'All notifications deleted successfully',
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete all notifications'
            ], 500);
        }
    }
}