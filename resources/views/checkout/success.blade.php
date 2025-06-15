@extends('layouts.app')

@section('content')
	<div class="bg-white font-sans">
		<!-- Success Header Section -->
		<div class="relative flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
			{{-- Background Wood Grain Pattern --}}
			<div class="absolute inset-0 opacity-[0.02] pointer-events-none">
				<svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
					<pattern id="wood-grain" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
						<path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
						<path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
					</pattern>
					<rect x="0" y="0" width="100" height="100" fill="url(#wood-grain)" />
				</svg>
			</div>

			<div class="md:w-1/2 relative">
				{{-- Decorative corner elements --}}
				<div class="absolute -top-4 -left-4 w-8 h-8 opacity-10">
					<svg viewBox="0 0 100 100" class="w-full h-full">
						<path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
						<path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
						<path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
					</svg>
				</div>
				<div class="absolute -bottom-4 -right-4 w-8 h-8 opacity-10">
					<svg viewBox="0 0 100 100" class="w-full h-full">
						<path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
						<path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
						<path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
					</svg>
				</div>

				<div class="flex items-center space-x-4 mb-6">
					<a href="{{ route('orders.index') }}"
						class="text-[#2C3E50] hover:text-[#E67E22] transition-colors duration-300">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
						</svg>
					</a>
					<h4 class="text-sm text-[#E67E22] uppercase tracking-widest font-light">Order Confirmation</h4>
				</div>

				<div class="text-center md:text-left">
					<div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
						<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
						</svg>
					</div>
					<h1 class="text-4xl md:text-5xl font-light mb-4 text-[#2C3E50]">Order Placed Successfully!</h1>
					<p class="text-gray-600 text-lg mb-2">Thank you for your purchase.</p>
					<p class="text-gray-600">Order Number: <span
							class="font-medium text-[#2C3E50]">{{ $order->order_number }}</span></p>
				</div>
			</div>
		</div>

		<!-- Order Details Section -->
		<div class="relative px-6 md:px-24 py-12">
			{{-- Background Wood Grain Pattern --}}
			<div class="absolute inset-0 opacity-[0.02] pointer-events-none">
				<svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
					<pattern id="wood-grain-details" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
						<path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
						<path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
					</pattern>
					<rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-details)" />
				</svg>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Order Items -->
				<div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
					{{-- Hand-drawn frame decoration --}}
					<div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
					<div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
					{{-- Decorative corner elements --}}
					<div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
					<div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
					<div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
					<div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

					<div class="p-6">
						<h2 class="text-xl font-light text-[#2C3E50] mb-6">Order Items</h2>
						<div class="space-y-6">
							@foreach($order->items as $item)
								<div class="flex items-center space-x-4">
									@if($item->product->image_url)
										<div class="relative w-20 h-20">
											<img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
												class="w-full h-full object-cover rounded">
											{{-- Hand-drawn frame decoration --}}
											<div class="absolute inset-0 border border-[#E67E22]/30 rounded transform rotate-1"></div>
											<div class="absolute inset-0 border border-[#E67E22]/20 rounded transform -rotate-1"></div>
										</div>
									@endif
									<div class="flex-1">
										<h3 class="text-sm font-medium text-[#2C3E50]">{{ $item->product->name }}</h3>
										<p class="text-sm text-gray-500 font-light">Quantity: {{ $item->quantity }}</p>
										<p class="text-sm text-gray-900 font-light">${{ number_format($item->price, 2) }} each</p>
									</div>
									<div class="text-right">
										<p class="text-sm font-medium text-[#2C3E50]">${{ number_format($item->price * $item->quantity, 2) }}
										</p>
									</div>
								</div>
							@endforeach
						</div>

						<div class="mt-6 pt-6 border-t border-gray-200">
							<div class="flex justify-between text-lg font-light">
								<span class="text-[#2C3E50]">Total</span>
								<span class="text-[#2C3E50]">${{ number_format($order->total, 2) }}</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Order Information -->
				<div class="space-y-8">
					<!-- Shipping Information -->
					<div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
						{{-- Hand-drawn frame decoration --}}
						<div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
						<div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
						{{-- Decorative corner elements --}}
						<div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
						<div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
						<div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
						<div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

						<div class="p-6">
							<h2 class="text-xl font-light text-[#2C3E50] mb-6">Shipping Information</h2>
							<div class="space-y-4">
								<div>
									<h3 class="text-sm font-medium text-gray-500">Shipping Address</h3>
									<div class="mt-2 text-sm text-gray-900 font-light">
										<p>{{ $order->shippingAddress->full_name }}</p>
										<p>{{ $order->shippingAddress->address_line1 }}</p>
										@if($order->shippingAddress->address_line2)
											<p>{{ $order->shippingAddress->address_line2 }}</p>
										@endif
										<p>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}
											{{ $order->shippingAddress->postal_code }}
										</p>
										<p>{{ $order->shippingAddress->country }}</p>
										<p>{{ $order->shippingAddress->phone }}</p>
									</div>
								</div>
								<div>
									<h3 class="text-sm font-medium text-gray-500">Shipping Method</h3>
									<p class="mt-2 text-sm text-gray-900 font-light">{{ ucfirst($order->shipping_method) }} Shipping</p>
								</div>
							</div>
						</div>
					</div>

					<!-- Payment Information -->
					<div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
						{{-- Hand-drawn frame decoration --}}
						<div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
						<div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
						{{-- Decorative corner elements --}}
						<div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
						<div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
						<div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
						<div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

						<div class="p-6">
							<h2 class="text-xl font-light text-[#2C3E50] mb-6">Payment Information</h2>
							<div class="space-y-4">
								<div>
									<h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
									<p class="mt-2 text-sm text-gray-900 font-light">{{ ucfirst($order->payment_method) }}</p>
								</div>
								<div>
									<h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
									<p class="mt-2 text-sm text-gray-900 font-light">{{ ucfirst($order->payment_status) }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Action Buttons -->
			<div class="mt-12 flex justify-center space-x-4">
				<a href="{{ route('orders.show', $order) }}"
					class="relative bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
					View Order Details
				</a>
				<a href="{{ route('home') }}"
					class="relative bg-transparent border-2 border-[#E67E22] text-[#E67E22] uppercase tracking-wider px-12 py-4 hover:bg-[#E67E22] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:ring-offset-2">
					Continue Shopping
				</a>
			</div>
		</div>
	</div>
@endsection