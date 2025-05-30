@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8">Terms of Service</h1>

        <div class="prose prose-lg max-w-none">
            <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <div class="space-y-8">
                {{-- Agreement to Terms --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Agreement to Terms</h2>
                    <p class="text-gray-600">By accessing or using Woodcraft's website and services, you agree to be bound by these Terms of Service. If you disagree with any part of these terms, you may not access our services.</p>
                </section>

                {{-- Use of Services --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Use of Services</h2>
                    <div class="space-y-4">
                        <p class="text-gray-600">You agree to use our services only for lawful purposes and in accordance with these Terms. You agree not to:</p>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Use our services in any way that violates any applicable laws or regulations</li>
                            <li>Attempt to gain unauthorized access to any part of our services</li>
                            <li>Interfere with or disrupt the operation of our services</li>
                            <li>Use our services to transmit any harmful code or material</li>
                        </ul>
                    </div>
                </section>

                {{-- User Accounts --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">User Accounts</h2>
                    <div class="space-y-4">
                        <p class="text-gray-600">When you create an account with us, you must provide accurate and complete information. You are responsible for:</p>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Maintaining the security of your account</li>
                            <li>All activities that occur under your account</li>
                            <li>Notifying us immediately of any unauthorized use</li>
                        </ul>
                    </div>
                </section>

                {{-- Product Information --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Product Information</h2>
                    <div class="space-y-4">
                        <p class="text-gray-600">We strive to display our products as accurately as possible. However, we do not guarantee that:</p>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Product colors will be exactly as shown on your screen</li>
                            <li>Product descriptions are completely accurate</li>
                            <li>Products will be available at all times</li>
                        </ul>
                    </div>
                </section>

                {{-- Pricing and Payment --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Pricing and Payment</h2>
                    <div class="space-y-4">
                        <p class="text-gray-600">All prices are subject to change without notice. We reserve the right to:</p>
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Modify or discontinue any product or service</li>
                            <li>Refuse any order you place with us</li>
                            <li>Limit quantities of products or services</li>
                        </ul>
                    </div>
                </section>

                {{-- Shipping and Delivery --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Shipping and Delivery</h2>
                    <p class="text-gray-600">Shipping times and costs are estimates only. We are not responsible for:</p>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Delays in shipping or delivery</li>
                        <li>Lost or damaged packages</li>
                        <li>Customs duties or import taxes</li>
                    </ul>
                </section>

                {{-- Returns and Refunds --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Returns and Refunds</h2>
                    <p class="text-gray-600">Our return policy is as follows:</p>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Items must be returned within 30 days of delivery</li>
                        <li>Items must be unused and in original packaging</li>
                        <li>Custom or personalized items are not eligible for returns</li>
                        <li>Refunds will be processed within 5-7 business days</li>
                    </ul>
                </section>

                {{-- Intellectual Property --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Intellectual Property</h2>
                    <p class="text-gray-600">All content on our website, including but not limited to:</p>
                    <ul class="list-disc list-inside text-gray-600">
                        <li>Text, graphics, logos, images</li>
                        <li>Product designs and descriptions</li>
                        <li>Software and code</li>
                        <li>Is the property of Woodcraft and is protected by intellectual property laws.</li>
                    </ul>
                </section>

                {{-- Limitation of Liability --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Limitation of Liability</h2>
                    <p class="text-gray-600">In no event shall Woodcraft be liable for any indirect, incidental, special, consequential, or punitive damages arising out of or relating to your use of our services.</p>
                </section>

                {{-- Changes to Terms --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Changes to Terms</h2>
                    <p class="text-gray-600">We reserve the right to modify these terms at any time. We will notify users of any material changes by posting the new Terms on this page.</p>
                </section>

                {{-- Contact Information --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Contact Information</h2>
                    <p class="text-gray-600">If you have any questions about these Terms, please contact us at:</p>
                    <div class="mt-2 text-gray-600">
                        <p>Email: legal@woodcraft.com</p>
                        <p>Phone: (555) 123-4567</p>
                        <p>Address: 123 Woodcraft Lane, Artisan City, AC 12345</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection 