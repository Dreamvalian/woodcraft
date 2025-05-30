@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center" style="height: 400px; background-image: url('{{ asset('image/background-forest.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 to-black/30 flex items-center justify-center">
        <div class="text-center text-white">
            <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Get in Touch</h4>
            <h1 class="text-4xl md:text-5xl font-light mb-4">Let's Create Something <br>Beautiful Together</h1>
            <p class="text-base md:text-lg font-light">We'd love to hear from you</p>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="bg-white py-16 px-6 md:px-24">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-[#f9f9f9] p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-light text-[#2C3E50] mb-6">Send us a Message</h2>
                <p class="text-gray-600 mb-8 font-light">We're here to help and answer any questions you might have.</p>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-light text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light"
                            placeholder="Your full name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-light text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 font-light"
                            placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-light text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-[#E67E22] transition duration-200 resize-none font-light"
                            placeholder="Write your message..."></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white font-light py-3 rounded-md transition duration-200 uppercase tracking-wider">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-light text-[#2C3E50] mb-6">Contact Information</h2>
                    <p class="text-gray-600 mb-8 font-light">Feel free to reach out to us through any of these channels.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-[#2C3E50] p-3 rounded-full">
                            <span class="text-white text-xl">📍</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-light text-[#2C3E50] mb-1">Our Location</h3>
                            <p class="text-gray-600 font-light">Jl. PH. Mustopa No. 23, Bandung, 40124, Indonesia.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-[#2C3E50] p-3 rounded-full">
                            <span class="text-white text-xl">✉️</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-light text-[#2C3E50] mb-1">Email Us</h3>
                            <p class="text-gray-600 font-light">woodcraft@contact.co.id</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-[#2C3E50] p-3 rounded-full">
                            <span class="text-white text-xl">📞</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-light text-[#2C3E50] mb-1">Call Us</h3>
                            <p class="text-gray-600 font-light">0812-3456-6789</p>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-light text-[#2C3E50] mb-4">Business Hours</h3>
                    <div class="space-y-2">
                        <p class="text-gray-600 font-light">Monday - Friday: 9:00 AM - 6:00 PM</p>
                        <p class="text-gray-600 font-light">Saturday: 10:00 AM - 4:00 PM</p>
                        <p class="text-gray-600 font-light">Sunday: Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
