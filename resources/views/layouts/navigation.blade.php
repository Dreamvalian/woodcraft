<nav class="bg-[#2D1E1E] text-white py-4 px-6 flex justify-between items-center">
    <div class="flex items-center gap-2">
        <img src="{{ asset('image/logo2.svg') }}" alt="WoodCraft Logo" class="w-8">
        <span class="text-xl font-bold">WoodCraft</span>
    </div>

    <div class="flex items-center space-x-6">
        <a href="/products" class="hover:underline">Our Product</a>
        <a href="/about" class="hover:underline">About</a>
        <a href="/contact" class="hover:underline">Contact Us</a>

        @auth
            <a href="/profile" class="hover:underline">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:underline">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('register') }}" class="hover:underline">Register</a>
        @endauth
    </div>
</nav>
