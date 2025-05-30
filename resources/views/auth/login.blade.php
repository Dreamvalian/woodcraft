@extends('layouts.auth')

@section('title', 'Login - WoodCraft')

@section('content')
<div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('image/forest-wood-craft.jpg') }}')">
    <div class="flex items-center justify-center min-h-screen bg-black/40 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20">
            <div class="text-center mb-8">
                <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Welcome Back</h4>
                <h2 class="text-3xl font-light text-[#2C3E50] mb-2">Sign In to Your Account</h2>
                <p class="text-gray-600 font-light">Continue your woodcraft journey</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
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

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-light text-[#2C3E50] mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
                </div>
                <div>
                    <label for="password" class="block text-sm font-light text-[#2C3E50] mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-[#E67E22] focus:ring-[#E67E22] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm font-light text-gray-600">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-light text-[#E67E22] hover:text-[#2C3E50] transition duration-300">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-[#2C3E50] hover:bg-[#E67E22] text-white font-light rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:ring-offset-2 transition duration-300">Sign In</button>
            </form>
            <div class="mt-8 text-center text-sm font-light text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#E67E22] hover:text-[#2C3E50] font-medium transition duration-300">Create Account</a>
            </div>
        </div>
    </div>
</div>
@endsection
