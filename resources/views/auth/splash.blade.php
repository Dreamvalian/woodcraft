@extends('layouts.auth')

@section('title', 'Welcome - WoodCraft')

@section('content')
  <div class="min-h-screen bg-cover bg-center relative overflow-hidden"
    style="background-image: url('{{ asset('image/forest-wood-craft.jpg') }}'); background-color: rgba(0,0,0,0.4); background-blend-mode: multiply;">
    <!-- Decorative Pattern Overlay -->
    <div class="absolute inset-0 bg-[#2C3E50]/20 backdrop-blur-[2px]">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\" 60\" height=\"60\"
      viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg
      fill=\"%23E67E22\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36
      34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6
      4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Main Content -->
    <div class="relative min-h-screen flex items-center justify-center">
    <div class="w-full max-w-4xl mx-auto px-4">
      <!-- Logo and Title -->
      <div class="text-center mb-12">
      <img src="{{ asset('image/logo2.svg') }}" alt="WoodCraft Logo" class="h-24 mx-auto mb-6 animate-fade-in">
      <h1 class="text-5xl font-light text-white mb-4 tracking-wider">WoodCraft</h1>
      <p class="text-xl text-white/90 font-light">Where Artistry Meets Nature</p>
      </div>

      <!-- Decorative Elements -->
      <div class="flex justify-center space-x-8 mb-12">
      <div class="w-16 h-16 border-2 border-[#E67E22]/30 rounded-lg transform rotate-45 animate-float"></div>
      <div class="w-16 h-16 border-2 border-[#E67E22]/30 rounded-lg transform -rotate-45 animate-float-delayed"></div>
      <div class="w-16 h-16 border-2 border-[#E67E22]/30 rounded-lg transform rotate-45 animate-float"></div>
      </div>

      <!-- Enter Button -->
      <div class="text-center">
      <a href="{{ route('login') }}"
        class="inline-block px-8 py-3 border-2 border-[#E67E22] text-[#E67E22] bg-transparent rounded-md hover:bg-[#E67E22] hover:text-white transition-all font-light uppercase tracking-wider">
        Enter Workshop
      </a>
      </div>

      <!-- Decorative Bottom Pattern -->
      <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/20 to-transparent"></div>
    </div>
    </div>
  </div>

  @push('styles')
    <style>
    @keyframes float {

    0%,
    100% {
      transform: translateY(0) rotate(45deg);
    }

    50% {
      transform: translateY(-10px) rotate(45deg);
    }
    }

    @keyframes float-delayed {

    0%,
    100% {
      transform: translateY(0) rotate(-45deg);
    }

    50% {
      transform: translateY(-10px) rotate(-45deg);
    }
    }

    .animate-float {
    animation: float 3s ease-in-out infinite;
    }

    .animate-float-delayed {
    animation: float-delayed 3s ease-in-out infinite;
    animation-delay: 1.5s;
    }

    .animate-fade-in {
    animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
    }
    </style>
  @endpush
@endsection