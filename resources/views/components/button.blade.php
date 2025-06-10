@props(['type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2']) }}>
    {{ $slot }}
</button>