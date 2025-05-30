@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8">Privacy Policy</h1>

        <div class="prose prose-lg max-w-none">
            <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

            <div class="space-y-8">
                {{-- Introduction --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Introduction</h2>
                    <p class="text-gray-600">At Woodcraft, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or make a purchase.</p>
                </section>

                {{-- Information We Collect --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Information We Collect</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xl font-medium mb-2">Personal Information</h3>
                            <p class="text-gray-600">We collect personal information that you voluntarily provide to us when you:</p>
                            <ul class="list-disc list-inside text-gray-600 mt-2">
                                <li>Create an account</li>
                                <li>Make a purchase</li>
                                <li>Sign up for our newsletter</li>
                                <li>Contact our customer service</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-xl font-medium mb-2">Automatically Collected Information</h3>
                            <p class="text-gray-600">When you visit our website, we automatically collect certain information about your device, including:</p>
                            <ul class="list-disc list-inside text-gray-600 mt-2">
                                <li>IP address</li>
                                <li>Browser type</li>
                                <li>Operating system</li>
                                <li>Pages visited</li>
                                <li>Time and date of visits</li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- How We Use Your Information --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">How We Use Your Information</h2>
                    <p class="text-gray-600">We use the information we collect to:</p>
                    <ul class="list-disc list-inside text-gray-600 mt-2">
                        <li>Process your orders and payments</li>
                        <li>Communicate with you about your orders</li>
                        <li>Send you marketing communications (with your consent)</li>
                        <li>Improve our website and services</li>
                        <li>Prevent fraud and enhance security</li>
                    </ul>
                </section>

                {{-- Information Sharing --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Information Sharing</h2>
                    <p class="text-gray-600">We may share your information with:</p>
                    <ul class="list-disc list-inside text-gray-600 mt-2">
                        <li>Service providers who assist in our operations</li>
                        <li>Payment processors for secure transactions</li>
                        <li>Shipping partners to deliver your orders</li>
                        <li>Law enforcement when required by law</li>
                    </ul>
                </section>

                {{-- Your Rights --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Your Rights</h2>
                    <p class="text-gray-600">You have the right to:</p>
                    <ul class="list-disc list-inside text-gray-600 mt-2">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of marketing communications</li>
                        <li>File a complaint with supervisory authorities</li>
                    </ul>
                </section>

                {{-- Contact Us --}}
                <section>
                    <h2 class="text-2xl font-semibold mb-4">Contact Us</h2>
                    <p class="text-gray-600">If you have any questions about this Privacy Policy, please contact us at:</p>
                    <div class="mt-2 text-gray-600">
                        <p>Email: privacy@woodcraft.com</p>
                        <p>Phone: (555) 123-4567</p>
                        <p>Address: 123 Woodcraft Lane, Artisan City, AC 12345</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection 