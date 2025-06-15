@extends('layouts.app')

@section('content')
  <div class="bg-white font-sans">
    <!-- Hero Section -->
    <div class="relative flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
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

    <div class="md:w-1/2 relative">
      {{-- Decorative corner elements --}}
      <div class="absolute -top-4 -left-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>
      <div class="absolute -bottom-4 -right-4 w-8 h-8 opacity-10">
      <svg viewBox="0 0 100 100" class="w-full h-full">
        <path d="M0,0 L100,0 L0,100" stroke="currentColor" fill="none" stroke-width="2" />
        <path d="M20,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
        <path d="M40,0 L100,0" stroke="currentColor" fill="none" stroke-width="1" />
      </svg>
      </div>

      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Our Story</h4>
      <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Crafting Excellence <br>Since 2023</h1>
      <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
      Our work and client trust are tangible proof of our dedication. We are committed to creating unique, elegant,
      and durable wooden products.
      </p>
    </div>
    <div class="md:w-1/2 relative">
      <div class="relative">
      <img src="{{ asset('image/workshop.png') }}" alt="WoodCraft Workshop" class="w-full h-[500px] object-cover">
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

    <!-- Values Section -->
    <section class="relative bg-white py-16 px-6 md:px-24">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain-values" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-values)" />
      </svg>
    </div>

    <div class="max-w-7xl mx-auto relative">
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

      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light text-center">Our Values</h4>
      <h2 class="text-3xl font-light mb-12 text-[#2C3E50] text-center">What Sets Us Apart</h2>

      <div class="grid md:grid-cols-2 gap-12 items-center">
      {{-- Value Cards --}}
      <div class="relative bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        {{-- Hand-drawn circle decoration --}}
        <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
        {{-- Wood grain texture --}}
        <div class="absolute inset-0 opacity-5">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.5" />
        </svg>
        </div>
        <div class="flex items-start space-x-6">
        <i class="fas fa-check-circle text-4xl text-[#E67E22]"></i>
        <div>
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Transparency & Quality</h3>
          <p class="text-gray-600 leading-relaxed font-light">
          Klien kami merasakan transparansi produk dan keunggulan lokal dari kayu yang kami gunakan.
          Mereka juga mencari konsistensi dalam proses, mulai dari pengerjaan mesin hingga pengetahuan
          bahan lokal, perawatan, keterampilan, dan kepercayaan yang terjaga.
          </p>
        </div>
        </div>
      </div>

      {{-- Repeat similar structure for other value cards --}}
      <div class="relative bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute inset-0 opacity-5">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.5" />
        </svg>
        </div>
        <div class="flex items-start space-x-6">
        <i class="fas fa-hammer text-4xl text-[#E67E22]"></i>
        <div>
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Masterful Craftsmanship</h3>
          <p class="text-gray-600 leading-relaxed font-light">
          Setiap produk kami adalah hasil dari keahlian tangan terampil dan perhatian terhadap detail.
          Pengrajin kami menggabungkan teknik tradisional dengan inovasi modern untuk menciptakan
          karya yang tak tertandingi.
          </p>
        </div>
        </div>
      </div>

      <div class="relative bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute inset-0 opacity-5">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.5" />
        </svg>
        </div>
        <div class="flex items-start space-x-6">
        <i class="fas fa-leaf text-4xl text-[#E67E22]"></i>
        <div>
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Sustainable Practices</h3>
          <p class="text-gray-600 leading-relaxed font-light">
          Kami berkomitmen untuk menggunakan kayu yang dipanen secara bertanggung jawab dan menerapkan
          praktik ramah lingkungan dalam setiap tahap produksi, memastikan warisan yang berkelanjutan
          untuk generasi mendatang.
          </p>
        </div>
        </div>
      </div>

      <div class="relative bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <div class="absolute -left-4 -top-4 w-8 h-8 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute -left-3 -top-3 w-6 h-6 border-2 border-[#E67E22] rounded-full"></div>
        <div class="absolute inset-0 opacity-5">
        <svg viewBox="0 0 100 100" class="w-full h-full">
          <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.5" />
          <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.5" />
        </svg>
        </div>
        <div class="flex items-start space-x-6">
        <i class="fas fa-users text-4xl text-[#E67E22]"></i>
        <div>
          <h3 class="text-xl font-light text-[#2C3E50] mb-3">Personalized Experience</h3>
          <p class="text-gray-600 leading-relaxed font-light">
          Kami bekerja erat dengan setiap klien untuk memahami visi mereka, memberikan solusi yang
          disesuaikan dengan kebutuhan spesifik dan memastikan kepuasan total dalam setiap proyek.
          </p>
        </div>
        </div>
      </div>
      </div>
    </div>
    </section>

    <!-- Workshop Image Section -->
    <section class="relative">
    <div class="relative">
      <img src="{{ asset('image/workshop.png') }}" alt="Workshop" class="w-full h-[600px] object-cover">
      {{-- Hand-drawn frame decoration --}}
      <div class="absolute inset-0 border-2 border-[#E67E22]/30 rounded-lg transform rotate-1"></div>
      <div class="absolute inset-0 border-2 border-[#E67E22]/20 rounded-lg transform -rotate-1"></div>
      {{-- Decorative corner elements --}}
      <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-[#E67E22]/30"></div>
      <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-[#E67E22]/30"></div>
    </div>
    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
      <div class="max-w-2xl mx-auto px-6 text-center">
      <p class="text-white text-xl leading-relaxed font-light">
        Ketika kami mulai berkolaborasi dengan Anda, Anda langsung masuk ke dalam proses yang berakar pada
        hasrat pribadi dan wawasan global.
      </p>
      <p class="text-white/80 mt-6 font-light">WoodCraft © 2023</p>
      </div>
    </div>
    </section>

    <!-- About Section -->
    <section class="relative bg-white py-20 px-6 md:px-24">
    {{-- Background Wood Grain Pattern --}}
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none">
      <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
      <pattern id="wood-grain-about" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
        <path d="M0,20 Q25,15 50,20 T100,20" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,40 Q25,35 50,40 T100,40" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,60 Q25,55 50,60 T100,60" stroke="currentColor" fill="none" stroke-width="0.3" />
        <path d="M0,80 Q25,75 50,80 T100,80" stroke="currentColor" fill="none" stroke-width="0.3" />
      </pattern>
      <rect x="0" y="0" width="100" height="100" fill="url(#wood-grain-about)" />
      </svg>
    </div>

    <div class="max-w-4xl mx-auto relative">
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

      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">About Us</h4>
      <h2 class="text-3xl font-light mb-8 text-[#2C3E50]">Wood Craft</h2>
      <div class="space-y-6">
      <p class="text-gray-600 leading-relaxed font-light">
        Welcome to Wood Craft! We are a company dedicated to creating beautiful and high-quality wood craftsmanship.
        With years of experience in this industry, we take pride in creating unique, elegant, and durable wooden
        products.
      </p>
      <p class="text-gray-600 leading-relaxed font-light">
        We believe that wood is not just a structural material that provides strength and longevity, but also a medium
        for artistic expression. With our craftsmen's deep understanding of wood types, grains, and finishes, we
        ensure that every product we create meets the highest standards of craftsmanship.
      </p>
      <p class="text-gray-600 leading-relaxed font-light">
        Perjalanan kami dibentuk oleh komitmen terhadap keberlanjutan, menggunakan bahan-bahan yang dipilih
        secara bertanggung jawab dan praktik yang meminimalkan dampak lingkungan. Dari konsep hingga kreasi,
        kami memastikan hasil yang sesuai dengan harapan klien kami, menggabungkan keahlian modern dan
        keterampilan tradisional.
      </p>
      </div>
    </div>
    </section>
  </div>
@endsection