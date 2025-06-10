@extends('layouts.app')

@section('content')
  <div class="bg-white font-sans">
    {{-- Hero Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
    <div class="md:w-1/2">
      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Artisan's Journey</h4>
      <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">The Art of <br>Woodcraft</h1>
      <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
      Where craftsmanship meets passion, and every piece tells a story of dedication and artistry.
      Our master artisans transform raw materials into timeless treasures through traditional techniques
      and modern precision.
      </p>
      <a href="#timeline"
      class="bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2 inline-block">
      Explore Process
      </a>
    </div>
    <div class="md:w-1/2">
      <img src="{{ asset('image/handcraft-1.jpg') }}" alt="Artisan's Workbench" class="w-full h-[500px] object-cover">
    </div>
    </div>

    {{-- Workbench Section --}}
    <div class="px-6 md:px-24 py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
      <div class="space-y-8">
        <h2 class="text-4xl font-light text-[#2C3E50]">Our Workbench</h2>
        <p class="text-gray-600 text-lg leading-relaxed font-light">
        Each piece begins its journey at our master craftsmen's workbench. Here, traditional techniques meet modern
        precision,
        creating furniture that stands the test of time. Our artisans spend countless hours perfecting every detail,
        ensuring that each creation meets our exacting standards.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Traditional Tools</h3>
          <p class="text-gray-600 font-light">Hand-selected tools passed down through generations, preserving the
          art of traditional woodworking.</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Modern Precision</h3>
          <p class="text-gray-600 font-light">State-of-the-art equipment ensuring perfect measurements and flawless
          execution.</p>
        </div>
        </div>
      </div>
      <div class="relative">
        <img src="{{ asset('image/crafting-tool.jpg') }}" alt="Crafting Tools"
        class="w-full h-[600px] object-cover rounded-lg">
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
      </div>
      </div>
    </div>
    </div>

    {{-- Making-Of Timeline --}}
    <div class="px-6 md:px-24 py-16 bg-white" id="timeline">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain)" />
      </svg>
    </div>

    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-16 relative">
      {{-- Decorative wood grain texture --}}
      <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 w-32 h-32 opacity-5">
        <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,50 Q25,40 50,50 T100,50" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M0,40 Q25,30 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M0,60 Q25,50 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="1" />
        </svg>
      </div>
      {{-- Decorative corner elements --}}
      <div class="absolute -top-4 -left-4 w-8 h-8 opacity-10">
        <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        </svg>
      </div>
      <div class="absolute -top-4 -right-4 w-8 h-8 opacity-10">
        <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        </svg>
      </div>
      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Our Process</h4>
      <h2 class="text-4xl font-light text-[#2C3E50]">The Making-Of Timeline</h2>
      {{-- Hand-drawn underline --}}
      <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-24 h-1">
        <svg viewBox="0 0 100 10" class="w-full h-full">
        <path d="M0,5 Q25,0 50,5 T100,5" stroke="#E67E22" fill="none" stroke-width="2" />
        </svg>
      </div>
      </div>

      <div class="relative">
      {{-- Organic Timeline Line with wood grain texture --}}
      <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px">
        <div class="h-full bg-gradient-to-b from-[#E67E22]/20 via-[#E67E22]/40 to-[#E67E22]/20"></div>
        <div class="absolute inset-0 opacity-10">
        <svg viewBox="0 0 10 100" class="w-full h-full">
          <path d="M5,0 Q7,10 5,20 T5,40 T5,60 T5,80 T5,100" stroke="currentColor" fill="none" stroke-width="1" />
        </svg>
        </div>
        {{-- Decorative knots --}}
        <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 w-4 h-4">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <circle cx="50" cy="50" r="40" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M30,50 Q50,30 70,50 T30,50" stroke="currentColor" fill="none" stroke-width="2" />
        </svg>
        </div>
        <div class="absolute top-3/4 left-1/2 transform -translate-x-1/2 w-4 h-4">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <circle cx="50" cy="50" r="40" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M30,50 Q50,30 70,50 T30,50" stroke="currentColor" fill="none" stroke-width="2" />
        </svg>
        </div>
      </div>

      <div class="space-y-32">
        {{-- Step 1 --}}
        <div class="relative">
        {{-- Decorative wood grain corner --}}
        <div class="absolute -left-8 -top-8 w-16 h-16 opacity-5">
          <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,0 L100,0 L100,100" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        {{-- Hand-drawn arrow --}}
        <div class="absolute -right-8 top-1/2 transform -translate-y-1/2 w-16 h-16 opacity-20">
          <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,50 L80,50 M60,30 L80,50 L60,70" stroke="currentColor" fill="none" stroke-width="2" />
          </svg>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="order-2 md:order-1">
          <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
            {{-- Hand-drawn circle decoration --}}
            <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
            <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
            {{-- Hand-drawn squiggle --}}
            <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 w-8 h-8 opacity-30">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,50 Q25,30 50,50 T100,50" stroke="#E67E22" fill="none" stroke-width="2" />
            </svg>
            </div>
            {{-- Wood grain texture --}}
            <div class="absolute inset-0 opacity-5">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.5" />
              <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.5" />
              <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.5" />
            </svg>
            </div>

            <span class="text-[#E67E22] text-sm uppercase tracking-widest font-light">Step 01</span>
            <h3 class="text-2xl font-light text-[#2C3E50] mt-2 mb-4">Material Selection</h3>
            <p class="text-gray-600 font-light leading-relaxed">
            Carefully selecting the finest woods, considering grain patterns and natural characteristics.
            Each piece of wood is chosen for its unique beauty and durability.
            </p>
          </div>
          </div>
          <div class="order-1 md:order-2 relative">
          <div class="relative">
            <img src="{{ asset('image/timeline-1.jpg') }}" alt="Material Selection"
            class="w-full h-[400px] object-cover rounded-lg">
            {{-- Hand-drawn frame decoration --}}
            <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
            <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
            {{-- Decorative corner elements --}}
            <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
            {{-- Hand-drawn pin --}}
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-8 h-8">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <circle cx="50" cy="50" r="40" stroke="#E67E22" fill="none" stroke-width="2" />
              <path d="M50,10 L50,90" stroke="#E67E22" fill="none" stroke-width="2" />
              <path d="M10,50 L90,50" stroke="#E67E22" fill="none" stroke-width="2" />
            </svg>
            </div>
          </div>
          </div>
        </div>
        </div>

        {{-- Step 2 --}}
        <div class="relative">
        {{-- Decorative wood grain corner --}}
        <div class="absolute -right-8 -top-8 w-16 h-16 opacity-5">
          <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M0,20 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          <path d="M0,40 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="relative">
          <div class="relative">
            <img src="{{ asset('image/timeline-2.jpg') }}" alt="Design & Planning"
            class="w-full h-[400px] object-cover rounded-lg">
            {{-- Hand-drawn frame decoration --}}
            <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform -rotate-1"></div>
            <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform rotate-1"></div>
            {{-- Decorative corner elements --}}
            <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
          </div>
          </div>
          <div>
          <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
            {{-- Hand-drawn circle decoration --}}
            <div class="absolute -right-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
            <div class="absolute -right-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
            {{-- Hand-drawn squiggle --}}
            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 w-8 h-8 opacity-30">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,50 Q25,70 50,50 T100,50" stroke="#E67E22" fill="none" stroke-width="2" />
            </svg>
            </div>

            <span class="text-[#E67E22] text-sm uppercase tracking-widest font-light">Step 02</span>
            <h3 class="text-2xl font-light text-[#2C3E50] mt-2 mb-4">Design & Planning</h3>
            <p class="text-gray-600 font-light leading-relaxed">
            Meticulous planning and detailed design work to ensure perfect proportions.
            Every curve and angle is carefully considered to create harmony and balance.
            </p>
          </div>
          </div>
        </div>
        </div>

        {{-- Step 3 --}}
        <div class="relative">
        {{-- Decorative wood grain corner --}}
        <div class="absolute -left-8 -top-8 w-16 h-16 opacity-5">
          <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,0 L100,0 L100,100" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="order-2 md:order-1">
          <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
            {{-- Hand-drawn circle decoration --}}
            <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
            <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
            {{-- Hand-drawn squiggle --}}
            <div class="absolute -right-4 top-1/2 transform -translate-y-1/2 w-8 h-8 opacity-30">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,50 Q25,30 50,50 T100,50" stroke="#E67E22" fill="none" stroke-width="2" />
            </svg>
            </div>

            <span class="text-[#E67E22] text-sm uppercase tracking-widest font-light">Step 03</span>
            <h3 class="text-2xl font-light text-[#2C3E50] mt-2 mb-4">Crafting Process</h3>
            <p class="text-gray-600 font-light leading-relaxed">
            Skilled hands transform raw materials into works of art through traditional techniques.
            Each cut and joint is executed with precision and care.
            </p>
          </div>
          </div>
          <div class="order-1 md:order-2 relative">
          <div class="relative">
            <img src="{{ asset('image/timeline-3.jpg') }}" alt="Crafting Process"
            class="w-full h-[400px] object-cover rounded-lg">
            {{-- Hand-drawn frame decoration --}}
            <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
            <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
            {{-- Decorative corner elements --}}
            <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
          </div>
          </div>
        </div>
        </div>

        {{-- Step 4 --}}
        <div class="relative">
        {{-- Decorative wood grain corner --}}
        <div class="absolute -right-8 -top-8 w-16 h-16 opacity-5">
          <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
          <path d="M0,20 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          <path d="M0,40 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
          </svg>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <div class="relative">
          <div class="relative">
            <img src="{{ asset('image/timeline-4.jpg') }}" alt="Finishing Touches"
            class="w-full h-[400px] object-cover rounded-lg">
            {{-- Hand-drawn frame decoration --}}
            <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform -rotate-1"></div>
            <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform rotate-1"></div>
            {{-- Decorative corner elements --}}
            <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
            <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
          </div>
          </div>
          <div>
          <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
            {{-- Hand-drawn circle decoration --}}
            <div class="absolute -right-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
            <div class="absolute -right-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
            {{-- Hand-drawn squiggle --}}
            <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 w-8 h-8 opacity-30">
            <svg viewBox="0 0 100 100" class="w-full h-full">
              <path d="M0,50 Q25,70 50,50 T100,50" stroke="#E67E22" fill="none" stroke-width="2" />
            </svg>
            </div>

            <span class="text-[#E67E22] text-sm uppercase tracking-widest font-light">Step 04</span>
            <h3 class="text-2xl font-light text-[#2C3E50] mt-2 mb-4">Finishing Touches</h3>
            <p class="text-gray-600 font-light leading-relaxed">
            Applying traditional finishes that enhance the natural beauty of the wood.
            Each piece is carefully polished to perfection, revealing its unique character.
            </p>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>

    {{-- Call to Action --}}
    <div class="px-6 md:px-24 py-16 bg-[#2C3E50] text-white">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-4xl font-light mb-6">Experience the Craft</h2>
      <p class="text-xl font-light text-gray-300 mb-8 max-w-2xl mx-auto">
      Visit our workshop to witness the artistry firsthand and discover the story behind each piece.
      </p>
      <a href="{{ route('contact') }}"
      class="bg-transparent border-2 border-white text-white uppercase tracking-wider px-12 py-4 hover:bg-white hover:text-[#2C3E50] transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 inline-block">
      Schedule a Visit
      </a>
    </div>
    </div>
  </div>
@endsection