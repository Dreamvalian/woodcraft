@extends('layouts.app')

@section('content')
  <div class="min-h-screen bg-[#f9f9f9] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
    <h2 class="text-4xl font-light text-[#2C3E50] tracking-tight mb-8">All Orders</h2>
    <div class="bg-white rounded-2xl shadow p-8">
      <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($orders as $order)
        <tr>
        <td class="px-6 py-4 whitespace-nowrap font-light text-[#2C3E50]">{{ $order->order_number }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#7f8c8d]">
        {{ $order->created_at->format('M d, Y H:i') }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#2C3E50]">{{ $order->user->name ?? '-' }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#7f8c8d]">{{ $order->items->count() }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#2C3E50]">{{ $order->formatted_total }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
        <span
          class="px-3 py-1 text-sm rounded-full font-light {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : ($order->status === 'approved' ? 'bg-blue-100 text-blue-800' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
          {{ ucfirst($order->status) }}
        </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right">
        <a href="{{ route('admin.orders.show', $order) }}"
          class="inline-block px-4 py-2 bg-[#2C3E50] text-white rounded hover:bg-[#E67E22] transition-all font-light text-sm mr-2">View</a>
        @if($order->status === 'pending')
        <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <button type="submit"
        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-all font-light text-sm">Approve</button>
        </form>
      @endif
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>
      <div class="mt-8">
      {{ $orders->links() }}
      </div>
    </div>
    </div>
  </div>
@endsection