@extends('layouts.app')

@section('title', 'Forgot Password - WoodCraft')

@section('content')
<div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('image/forest-wood-craft.jpg') }}')">
    <div class="flex items-center justify-center min-h-screen bg-black/40 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-6 border border-white/20">
            <div class="text-center mb-6">
                <h4 class="text-sm text-[#E67E22] uppercase mb-2 tracking-widest font-light">Reset Password</h4>
                <h2 class="text-2xl font-light text-[#2C3E50] mb-1">Forgot Your Password?</h2>
                <p class="text-gray-600 font-light text-sm">Enter your email address and we'll send you a link to reset your password</p>
            </div>

            @if (session('status'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
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

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-light text-[#2C3E50] mb-1">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#2C3E50] hover:bg-[#E67E22] text-white font-light rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:ring-offset-2 transition duration-300">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-6 text-center text-sm font-light text-gray-600">
                Remember your password?
                <a href="{{ route('login') }}" class="text-[#E67E22] hover:text-[#2C3E50] font-medium transition duration-300">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection 