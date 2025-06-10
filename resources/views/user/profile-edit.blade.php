@extends('layouts.app')

@section('title', 'Edit Profile - WoodCraft')

@section('content')
  <div class="bg-white font-sans">
    <!-- Profile Edit Header -->
    <div class="relative bg-[#2C3E50] text-white py-16">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain-profile-edit" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-profile-edit)" />
      </svg>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative">
      <div class="flex items-center gap-6">
      <div class="relative">
        <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center">
        <i class="fas fa-user text-4xl text-white/80"></i>
        </div>
        {{-- Decorative corner elements --}}
        <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
        <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
      </div>
      <div>
        <h1 class="text-3xl font-light mb-2">Edit Profile</h1>
        <p class="text-white/80">Update your personal information</p>
      </div>
      </div>
    </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 py-12">
    <div class="max-w-2xl mx-auto">
      <div class="bg-white rounded-xl shadow-sm border-2 border-[#2C3E50]/30 p-8">
      <div class="relative">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Full Name -->
        <div>
          <label for="name" class="block text-sm font-light text-gray-600 mb-1">Full Name</label>
          <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light"
          required>
          @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
        </div>

        <!-- Email Address -->
        <div>
          <label for="email" class="block text-sm font-light text-gray-600 mb-1">Email Address</label>
          <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light"
          required>
          @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
        </div>

        <!-- Phone Number -->
        <div>
          <label for="phone" class="block text-sm font-light text-gray-600 mb-1">Phone Number</label>
          <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}"
          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light">
          @error('phone')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
        </div>

        <!-- Address -->
        <div>
          <label for="address" class="block text-sm font-light text-gray-600 mb-1">Address</label>
          <textarea name="address" id="address" rows="3"
          class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light">{{ auth()->user()->address }}</textarea>
          @error('address')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
        </div>

        <!-- Password Section -->
        <div class="pt-6 border-t border-gray-200">
          <h3 class="text-lg font-light text-[#2C3E50] mb-4">Change Password</h3>
          <div class="space-y-4">
          <!-- Current Password -->
          <div>
            <label for="current_password" class="block text-sm font-light text-gray-600 mb-1">Current
            Password</label>
            <input type="password" name="current_password" id="current_password"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light">
            @error('current_password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
          </div>

          <!-- New Password -->
          <div>
            <label for="password" class="block text-sm font-light text-gray-600 mb-1">New Password</label>
            <input type="password" name="password" id="password"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light">
            @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
          </div>

          <!-- Confirm New Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-light text-gray-600 mb-1">Confirm New
            Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#2C3E50] focus:ring-2 focus:ring-[#2C3E50] focus:ring-opacity-50 transition duration-300 font-light">
          </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
          <a href="{{ route('profile') }}"
          class="relative inline-flex items-center gap-2 px-6 py-3 bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
          Cancel
          </a>
          <button type="submit"
          class="relative inline-flex items-center gap-2 px-6 py-3 bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
          Save Changes
          </button>
        </div>
        </form>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection