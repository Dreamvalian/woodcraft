@extends('layouts.app')

@section('content')
  <div class="bg-white font-sans">
    <!-- Hero Section -->
    <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
    <div class="md:w-1/2">
      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Our Story</h4>
      <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Crafting Excellence <br>Since 2023</h1>
      <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
      Hasil karya kami dan kepercayaan klien adalah bukti nyata kami. Kami berdedikasi untuk menciptakan
      produk kayu yang unik, elegan, dan tahan lama.
      </p>
    </div>
    <div class="md:w-1/2">
      <img src="{{ asset('image/workshop.png') }}" alt="WoodCraft Workshop" class="w-full h-[500px] object-cover">
    </div>
    </div>

    <!-- Values Section -->
    <section class="bg-white py-16 px-6 md:px-24">
    <div class="max-w-7xl mx-auto">
      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light text-center">Our Values</h4>
      <h2 class="text-3xl font-light mb-12 text-[#2C3E50] text-center">What Sets Us Apart</h2>

      <div class="grid md:grid-cols-2 gap-12 items-center">
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
    </section>

    <!-- Workshop Image Section -->
    <section class="relative">
    <img src="{{ asset('image/workshop.png') }}" alt="Workshop" class="w-full h-[600px] object-cover">
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
    <section class="bg-white py-20 px-6 md:px-24">
    <div class="max-w-4xl mx-auto">
      <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">About Us</h4>
      <h2 class="text-3xl font-light mb-8 text-[#2C3E50]">Wood Craft</h2>
      <div class="space-y-6">
      <p class="text-gray-600 leading-relaxed font-light">
        Selamat datang di Wood Craft! Kami adalah perusahaan yang didedikasikan untuk seni kerajinan kayu
        yang indah dan berkualitas. Dengan pengalaman bertahun-tahun di industri ini, kami dengan bangga
        menciptakan produk kayu yang unik, elegan, dan tahan lama.
      </p>
      <p class="text-gray-600 leading-relaxed font-light">
        Kami percaya bahwa kayu bukan hanya bahan struktural yang memberikan kekuatan dan umur panjang,
        tetapi juga media ekspresi artistik. Dengan pemahaman mendalam para pengrajin kami terhadap jenis,
        serat, dan finishing kayu, kami menjamin bahwa setiap produk yang kami hasilkan memenuhi standar
        tertinggi dalam kerajinan tangan.
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