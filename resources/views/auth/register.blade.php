@extends('layouts.auth')

@section('title', 'Register - WoodCraft')

@section('content')
  <div class="min-h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('image/forest-wood-craft.jpg') }}')">
    <div class="flex items-center justify-center min-h-screen bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-5xl bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-6 border border-white/20">
      <div class="text-center mb-6">
      <h4 class="text-sm text-[#E67E22] uppercase mb-2 tracking-widest font-light">Join Our Community</h4>
      <h2 class="text-2xl font-light text-[#2C3E50] mb-1">Create Your Account</h2>
      <p class="text-gray-600 font-light text-sm">Start your woodcraft journey with us</p>
      </div>

      @if ($errors->any())
      <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-3 rounded-lg">
      <div class="flex">
      <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
        clip-rule="evenodd" />
      </svg>
      </div>
      <div class="ml-3">
      <ul class="list-disc pl-5 text-sm text-red-700">
        @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
      </ul>
      </div>
      </div>
      </div>
    @endif

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column - Personal Information -->
        <div class="space-y-4">
        <h3 class="text-base font-light text-[#2C3E50] mb-2">Personal Information</h3>
        <div>
          <label for="name" class="block text-sm font-light text-[#2C3E50] mb-1">Full Name</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        <div>
          <label for="username" class="block text-sm font-light text-[#2C3E50] mb-1">Username</label>
          <input type="text" id="username" name="username" value="{{ old('username') }}" required
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        <div>
          <label for="phone" class="block text-sm font-light text-[#2C3E50] mb-1">Phone Number</label>
          <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        <div>
          <label for="address" class="block text-sm font-light text-[#2C3E50] mb-1">Address</label>
          <textarea id="address" name="address" required rows="2"
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">{{ old('address') }}</textarea>
        </div>
        </div>

        <!-- Right Column - Account Details -->
        <div class="space-y-4">
        <h3 class="text-base font-light text-[#2C3E50] mb-2">Account Details</h3>
        <div>
          <label for="email" class="block text-sm font-light text-[#2C3E50] mb-1">Email
          Address</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        <div>
          <label for="password" class="block text-sm font-light text-[#2C3E50] mb-1">Password</label>
          <input type="password" id="password" name="password" required
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        <div>
          <label for="password_confirmation" class="block text-sm font-light text-[#2C3E50] mb-1">Confirm
          Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required
          class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
        </div>
        </div>
      </div>

      <!-- Terms and Submit Button - Full Width -->
      <div class="space-y-4">
        <div class="flex items-center">
        <input type="checkbox" name="terms" id="terms" required
          class="h-4 w-4 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 rounded">
        <label for="terms" class="ml-2 block text-sm font-light text-gray-600">
          I agree to the <a href="{{ route('terms') }}"
          class="text-[#E67E22] hover:text-[#2C3E50] transition duration-300">Terms of Service</a>
          and <a href="{{ route('privacy') }}"
          class="text-[#E67E22] hover:text-[#2C3E50] transition duration-300">Privacy
          Policy</a>
        </label>
        </div>
        <div>
        <x-button class="w-full justify-center">
          Create Account
        </x-button>
        </div>
      </div>
      </form>
      <div class="mt-6 text-center text-sm font-light text-gray-600">
      Already have an account?
      <a href="{{ route('login') }}"
        class="text-[#E67E22] hover:text-[#2C3E50] font-medium transition duration-300">Sign In</a>
      </div>
    </div>
    </div>
  </div>
@endsection