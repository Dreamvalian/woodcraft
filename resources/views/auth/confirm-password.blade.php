@extends('layouts.app')

@section('title', 'Confirm Password - WoodCraft')

@section('content')
<div class="min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('image/forest-wood-craft.jpg') }}')">
    <div class="flex items-center justify-center min-h-screen bg-black/40 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl p-6 border border-white/20">
            <div class="text-center mb-6">
                <h4 class="text-sm text-[#E67E22] uppercase mb-2 tracking-widest font-light">Security Check</h4>
                <h2 class="text-2xl font-light text-[#2C3E50] mb-1">Confirm Your Password</h2>
                <p class="text-gray-600 font-light text-sm">For your security, please confirm your password before continuing.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-3 rounded-lg" role="alert">
                    <div class="flex">
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

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-light text-[#2C3E50] mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 bg-white/50 backdrop-blur-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:border-transparent transition duration-200">
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-[#2C3E50] hover:bg-[#E67E22] text-white font-light rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-[#E67E22] focus:ring-offset-2 transition duration-300">
                    Confirm Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

