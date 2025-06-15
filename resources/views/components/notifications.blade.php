@props(['notifications' => collect(), 'unreadCount' => 0, 'notificationTypes' => []])

<div x-data="notifications()" class="relative">
  <!-- Notification Bell -->
  <button @click="toggleNotifications" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none"
    :class="{'opacity-50 cursor-not-allowed': isLoading}">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
      </path>
    </svg>
    <!-- Unread Badge -->
    <span x-show="unreadCount > 0"
      class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
      x-text="unreadCount"></span>
  </button>

  <!-- Notifications Dropdown -->
  <div x-show="isOpen" @click.away="isOpen = false"
    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">
    <div class="p-4 border-b">
      <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
        <div class="flex space-x-2">
          <button @click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800"
            :disabled="isLoading || notifications.length === 0">
            <span x-show="!isLoading">Mark all as read</span>
            <span x-show="isLoading" class="inline-block animate-spin">⟳</span>
          </button>
          <button @click="deleteAll" class="text-sm text-red-600 hover:text-red-800"
            :disabled="isLoading || notifications.length === 0">
            <span x-show="!isLoading">Clear all</span>
            <span x-show="isLoading" class="inline-block animate-spin">⟳</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Error Message -->
    <div x-show="error" class="p-4 bg-red-50 text-red-600 text-sm">
      <p x-text="error"></p>
    </div>

    <div class="max-h-96 overflow-y-auto">
      <template x-if="notifications.length === 0">
        <div class="p-4 text-center text-gray-500">
          No notifications
        </div>
      </template>

      <template x-for="notification in notifications" :key="notification.id">
        <div :class="{'bg-blue-50': !notification.read_at}" class="p-4 border-b hover:bg-gray-50">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-sm font-medium text-gray-900" x-text="getNotificationTitle(notification)"></p>
              <p class="text-sm text-gray-500" x-text="getNotificationMessage(notification)"></p>
              <p class="text-xs text-gray-400 mt-1" x-text="formatDate(notification.created_at)"></p>
            </div>
            <div class="flex space-x-2">
              <button @click="markAsRead(notification.id)" x-show="!notification.read_at"
                class="text-sm text-blue-600 hover:text-blue-800" :disabled="isLoading">
                <span x-show="!isLoading">Mark as read</span>
                <span x-show="isLoading" class="inline-block animate-spin">⟳</span>
              </button>
              <button @click="deleteNotification(notification.id)" class="text-sm text-red-600 hover:text-red-800"
                :disabled="isLoading">
                <span x-show="!isLoading">Delete</span>
                <span x-show="isLoading" class="inline-block animate-spin">⟳</span>
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    function notifications() {
    return {
      isOpen: false,
      isLoading: false,
      error: null,
      notifications: @json($notifications),
      unreadCount: @json($unreadCount),
      notificationTypes: @json($notificationTypes),

      toggleNotifications() {
      this.isOpen = !this.isOpen;
      this.error = null;
      },

      getNotificationTitle(notification) {
      return this.notificationTypes[notification.type] || 'Notification';
      },

      getNotificationMessage(notification) {
      switch (notification.type) {
        case 'order_created':
        return `Order #${notification.data.order_number} has been placed successfully.`;
        case 'order_status_updated':
        return `Order #${notification.data.order_number} status has been updated to ${notification.data.status}.`;
        case 'payment_received':
        return `Payment received for Order #${notification.data.order_number}.`;
        case 'shipping_updated':
        return `Shipping status updated for Order #${notification.data.order_number}.`;
        case 'product_back_in_stock':
        return `${notification.data.product_name} is back in stock!`;
        case 'price_drop':
        return `Price dropped for ${notification.data.product_name}!`;
        case 'review_request':
        return `Please review your purchase of ${notification.data.product_name}.`;
        case 'wishlist_item_on_sale':
        return `${notification.data.product_name} from your wishlist is now on sale!`;
        default:
        return 'You have a new notification.';
      }
      },

      formatDate(date) {
      return new Date(date).toLocaleString();
      },

      async handleRequest(url, method) {
      this.isLoading = true;
      this.error = null;

      try {
        const response = await fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
        });

        if (!response.ok) {
        throw new Error('Network response was not ok');
        }

        const data = await response.json();
        if (!data.success) {
        throw new Error(data.message || 'Operation failed');
        }

        return data;
      } catch (error) {
        this.error = error.message || 'An error occurred. Please try again.';
        throw error;
      } finally {
        this.isLoading = false;
      }
      },

      async markAsRead(notificationId) {
      try {
        const data = await this.handleRequest(`/notifications/${notificationId}/mark-as-read`, 'POST');
        const notification = this.notifications.find(n => n.id === notificationId);
        if (notification) {
        notification.read_at = new Date().toISOString();
        this.unreadCount = data.unread_count;
        }
      } catch (error) {
        console.error('Error marking notification as read:', error);
      }
      },

      async markAllAsRead() {
      try {
        const data = await this.handleRequest('/notifications/mark-all-as-read', 'POST');
        this.notifications.forEach(notification => {
        notification.read_at = new Date().toISOString();
        });
        this.unreadCount = 0;
      } catch (error) {
        console.error('Error marking all notifications as read:', error);
      }
      },

      async deleteNotification(notificationId) {
      try {
        const data = await this.handleRequest(`/notifications/${notificationId}`, 'DELETE');
        this.notifications = this.notifications.filter(n => n.id !== notificationId);
        this.unreadCount = data.unread_count;
      } catch (error) {
        console.error('Error deleting notification:', error);
      }
      },

      async deleteAll() {
      try {
        await this.handleRequest('/notifications', 'DELETE');
        this.notifications = [];
        this.unreadCount = 0;
      } catch (error) {
        console.error('Error deleting all notifications:', error);
      }
      }
    }
    }
  </script>
@endpush