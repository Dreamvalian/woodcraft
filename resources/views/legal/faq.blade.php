@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8">Frequently Asked Questions</h1>

        <div class="space-y-6">
            {{-- Shipping & Delivery --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping & Delivery</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900">How long does shipping take?</h3>
                        <p class="mt-2 text-gray-600">Standard shipping typically takes 3-5 business days within the continental US. International shipping may take 7-14 business days depending on the destination.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Do you offer international shipping?</h3>
                        <p class="mt-2 text-gray-600">Yes, we ship to most countries worldwide. Shipping costs and delivery times vary by location.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">How much does shipping cost?</h3>
                        <p class="mt-2 text-gray-600">Shipping costs are calculated based on your location and the weight of your order. You can view shipping costs in your cart before checkout.</p>
                    </div>
                </div>
            </div>

            {{-- Orders & Returns --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Orders & Returns</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900">What is your return policy?</h3>
                        <p class="mt-2 text-gray-600">We accept returns within 30 days of delivery. Items must be unused and in original packaging. Custom or personalized items are not eligible for returns.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">How do I track my order?</h3>
                        <p class="mt-2 text-gray-600">Once your order ships, you'll receive a tracking number via email. You can also track your order status in your account dashboard.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Can I modify or cancel my order?</h3>
                        <p class="mt-2 text-gray-600">Orders can be modified or cancelled within 24 hours of placement. Please contact our customer service team for assistance.</p>
                    </div>
                </div>
            </div>

            {{-- Products & Materials --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Products & Materials</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900">What materials do you use?</h3>
                        <p class="mt-2 text-gray-600">We use high-quality, sustainably sourced wood and materials. Each product description includes detailed information about the materials used.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Are your products handmade?</h3>
                        <p class="mt-2 text-gray-600">Yes, all our products are handcrafted by skilled artisans using traditional woodworking techniques.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">How do I care for my wooden products?</h3>
                        <p class="mt-2 text-gray-600">We recommend regular dusting and occasional treatment with food-safe mineral oil for cutting boards and wooden utensils. Detailed care instructions are included with each product.</p>
                    </div>
                </div>
            </div>

            {{-- Payment & Security --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Payment & Security</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-medium text-gray-900">What payment methods do you accept?</h3>
                        <p class="mt-2 text-gray-600">We accept all major credit cards, PayPal, and Apple Pay. All payments are processed securely through our payment partners.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Is my payment information secure?</h3>
                        <p class="mt-2 text-gray-600">Yes, we use industry-standard SSL encryption to protect your payment information. We never store your full credit card details on our servers.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Do you offer gift cards?</h3>
                        <p class="mt-2 text-gray-600">Yes, we offer digital gift cards that can be purchased and sent via email. Gift cards never expire and can be used for any purchase on our website.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 