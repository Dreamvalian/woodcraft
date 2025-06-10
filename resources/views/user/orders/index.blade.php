@extends('layouts.app')

@section('content')
	<div class="bg-white font-sans">
		<!-- Orders Header Section -->
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

				<h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Your Orders</h4>
				<h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Order History</h1>
				<p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
					Track and manage all your orders in one place. View order details, track shipments, and manage your
					purchases.
				</p>
			</div>
		</div>

		<!-- Orders List Section -->
		<div class="relative px-6 md:px-24 py-12">
			{{-- Background Wood Grain Pattern --}}
			<div class="absolute inset-0 opacity-[0.02] pointer-events-none">
				<svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
					<pattern id="wood-grain-orders" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
						<path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
						<path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
						<path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
					</pattern>
					<rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-orders)" />
				</svg>
			</div>

			@if($orders->isEmpty())
				<div class="bg-white rounded-lg shadow-lg p-8 text-center relative">
					{{-- Hand-drawn frame decoration --}}
					<div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
					<div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
					{{-- Decorative corner elements --}}
					<div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
					<div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
					<div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
					<div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>

					<p class="text-gray-600 text-lg mb-6">You haven't placed any orders yet.</p>
					<a href="{{ route('shops.index') }}"
						class="relative bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2 inline-block">
						Start Shopping
					</a>
				</div>
			@else
				<div class="space-y-6">
					@foreach($orders as $order)
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
								<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
									<div>
										<h3 class="text-xl font-light text-[#2C3E50]">Order #{{ $order->id }}</h3>
										<p class="text-gray-600 mt-1">{{ $order->placed_at->format('F d, Y \a\t h:i A') }}</p>
									</div>
									<div class="mt-4 md:mt-0">
										<span class="px-3 py-1 rounded-full text-sm font-semibold
																															@if($order->status === 'completed') bg-green-100 text-green-800
																															@elseif($order->status === 'cancelled') bg-red-100 text-red-800
																																@else bg-yellow-100 text-yellow-800
																															@endif">
											{{ ucfirst($order->status) }}
										</span>
									</div>
								</div>

								<div class="flex flex-col md:flex-row justify-between items-start md:items-center">
									<div class="text-gray-600">
										<p class="font-light">Total: <span
												class="font-medium text-[#2C3E50]">${{ number_format($order->total, 2) }}</span></p>
									</div>
									<a href="{{ route('orders.show', $order) }}"
										class="mt-4 md:mt-0 relative bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-8 py-2 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2 inline-block">
										View Details
									</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<div class="mt-8">
					{{ $orders->links() }}
				</div>
			@endif
		</div>
	</div>
@endsection