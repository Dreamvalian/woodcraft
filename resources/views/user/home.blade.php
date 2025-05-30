@extends('layouts.app')
@section('content')
<div class="bg-white font-sans">
    <!-- Hero Section -->
    <div class="flex flex-col md:flex-row justify-between items-center px-6 md:px-24 py-16 gap-12 bg-white">
        <div class="md:w-1/2">
            <h4 class="text-sm text-[#E67E22] uppercase mb-3 tracking-widest font-light">Crafting Excellence</h4>
            <h1 class="text-6xl font-light mb-6 leading-tight text-[#2C3E50]">Timeless Wood <br>Artistry</h1>
            <p class="text-gray-600 mb-8 text-lg max-w-md leading-relaxed font-light">
                Kami dengan bangga memperkenalkan brand WoodCraft, sebuah perusahaan yang memproduksi kayu solid dan furnitur unik, serta menjadi solusi eksklusif dari berbagai kebutuhan interior kayu berkualitas.
            </p>
            <button class="bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
                Explore Collection
            </button>
        </div>
        <div class="md:w-1/2">
            <img src="{{ asset('image/wood-1.png') }}" alt="Wood Table" class="w-full h-[500px] object-cover">
        </div>
    </div>

    <!-- Carousel Section -->
    <div class="relative bg-white" id="carousel">
        <!-- Loading Indicator -->
        <div class="absolute inset-0 bg-white/80 flex items-center justify-center z-50" id="carouselLoading">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-[#E67E22]"></div>
        </div>

        <!-- Slide Counter -->
        <div class="absolute top-4 right-4 z-10 bg-black/50 text-white px-3 py-1 rounded-full text-sm font-light">
            <span id="currentSlideNumber">1</span> / <span id="totalSlides">3</span>
    </div>

        <!-- Slides -->
    <div class="relative">
            <div class="slide active">
                <img src="{{ asset('image/forest-wood-craft.jpg') }}" alt="Forest" class="w-full h-[500px] object-cover transition-transform duration-700" loading="lazy">
                <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-start">
                    <div class="px-24 transform translate-y-4 opacity-0 transition-all duration-700 slide-content">
                        <h2 class="text-white text-5xl font-light mb-4">Natural <br>Excellence</h2>
                        <p class="text-white text-lg max-w-xl leading-relaxed font-light">
                WoodCraft memiliki hutan sendiri untuk memastikan kontrol penuh atas kualitas bahan baku yang digunakan dalam semua produk kami.
            </p>
        </div>
    </div>
        </div>

            <div class="slide hidden">
                <img src="{{ asset('image/about-1.jpg') }}" alt="Workshop" class="w-full h-[500px] object-cover transition-transform duration-700" loading="lazy">
                <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-start">
                    <div class="px-24 transform translate-y-4 opacity-0 transition-all duration-700 slide-content">
                        <h2 class="text-white text-5xl font-light mb-4">Crafting <br>Perfection</h2>
                        <p class="text-white text-lg max-w-xl leading-relaxed font-light">
                WoodCraft Workshop adalah ruang kerja para profesional pembuat kayu kami, dirancang untuk membawa hasil terbaik dari keahlian dan detail artistik dalam setiap produk.
            </p>
                    </div>
                </div>
            </div>

            <div class="slide hidden">
                <img src="{{ asset('image/wood-1.png') }}" alt="Testimonials" class="w-full h-[500px] object-cover transition-transform duration-700" loading="lazy">
                <div class="absolute inset-0 bg-black/30 flex flex-col justify-center items-center">
                    <div class="px-24 text-center transform translate-y-4 opacity-0 transition-all duration-700 slide-content">
                        <h2 class="text-white text-5xl font-light mb-4">Client <br>Stories</h2>
                        <p class="text-white text-lg max-w-xl leading-relaxed font-light">
                            "Keindahan kayunya sangat memukau. Ini benar-benar investasi estetika yang berkelas."
                        </p>
                        <p class="text-white mt-6 font-light">Alex Johnson</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <button 
            onclick="prevSlide()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-[#2C3E50] p-3 rounded-full shadow-lg transition duration-300 hover:scale-110 focus:outline-none opacity-0 group-hover:opacity-100"
            aria-label="Previous slide"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button 
            onclick="nextSlide()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-[#2C3E50] p-3 rounded-full shadow-lg transition duration-300 hover:scale-110 focus:outline-none opacity-0 group-hover:opacity-100"
            aria-label="Next slide"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gray-200">
            <div class="h-full bg-[#E67E22] transition-all duration-100" id="progressBar"></div>
        </div>

        <!-- Slide Previews -->
        <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 z-10 flex space-x-2">
            <div class="preview-container">
                <img src="{{ asset('image/forest-wood-craft.jpg') }}" alt="Preview 1" class="w-16 h-16 object-cover rounded cursor-pointer opacity-50 hover:opacity-100 transition-opacity duration-300" onclick="goToSlide(0)">
            </div>
            <div class="preview-container">
                <img src="{{ asset('image/about-1.jpg') }}" alt="Preview 2" class="w-16 h-16 object-cover rounded cursor-pointer opacity-50 hover:opacity-100 transition-opacity duration-300" onclick="goToSlide(1)">
            </div>
            <div class="preview-container">
                <img src="{{ asset('image/wood-1.png') }}" alt="Preview 3" class="w-16 h-16 object-cover rounded cursor-pointer opacity-50 hover:opacity-100 transition-opacity duration-300" onclick="goToSlide(2)">
            </div>
        </div>

        <!-- Progress Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-10 flex space-x-2">
            <button 
                onclick="goToSlide(0)"
                class="w-4 h-2 rounded-full bg-[#E67E22] transition duration-300 focus:outline-none"
                aria-label="Go to slide 1"
            ></button>
            <button 
                onclick="goToSlide(1)"
                class="w-2 h-2 rounded-full bg-gray-300 hover:bg-gray-400 transition duration-300 focus:outline-none"
                aria-label="Go to slide 2"
            ></button>
            <button 
                onclick="goToSlide(2)"
                class="w-2 h-2 rounded-full bg-gray-300 hover:bg-gray-400 transition duration-300 focus:outline-none"
                aria-label="Go to slide 3"
            ></button>
        </div>

        <!-- Play/Pause Button -->
        <button 
            onclick="toggleAutoRotate()"
            class="absolute bottom-4 right-4 z-10 bg-white/80 hover:bg-white text-[#2C3E50] p-2 rounded-full shadow-lg transition duration-300 hover:scale-110 focus:outline-none"
            aria-label="Pause auto-rotation"
            id="playPauseButton"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>

    <script>
        let currentSlide = 0;
        let autoRotateInterval;
        let touchStartX = 0;
        let touchEndX = 0;
        let isAutoRotating = true;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.absolute.bottom-4 button');
        const previews = document.querySelectorAll('.preview-container img');
        const carousel = document.getElementById('carousel');
        const progressBar = document.getElementById('progressBar');
        const playPauseButton = document.getElementById('playPauseButton');
        const loadingIndicator = document.getElementById('carouselLoading');
        const currentSlideNumber = document.getElementById('currentSlideNumber');
        const totalSlides = document.getElementById('totalSlides');

        // Update total slides count
        totalSlides.textContent = slides.length;

        // Preload images
        function preloadImages() {
            const images = document.querySelectorAll('.slide img, .preview-container img');
            let loadedImages = 0;
            
            images.forEach(img => {
                if (img.complete) {
                    loadedImages++;
                    if (loadedImages === images.length) {
                        hideLoadingIndicator();
                    }
                } else {
                    img.addEventListener('load', () => {
                        loadedImages++;
                        if (loadedImages === images.length) {
                            hideLoadingIndicator();
                        }
                    });
                }
            });
        }

        function hideLoadingIndicator() {
            loadingIndicator.style.opacity = '0';
            setTimeout(() => {
                loadingIndicator.style.display = 'none';
            }, 300);
        }

        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => {
                slide.classList.add('hidden');
                slide.classList.remove('active');
                const content = slide.querySelector('.slide-content');
                content.style.transform = 'translateY(1rem)';
                content.style.opacity = '0';
                const img = slide.querySelector('img');
                img.style.transform = 'scale(1)';
            });
            
            // Show selected slide
            slides[index].classList.remove('hidden');
            slides[index].classList.add('active');
            
            // Animate content
            const activeContent = slides[index].querySelector('.slide-content');
            setTimeout(() => {
                activeContent.style.transform = 'translateY(0)';
                activeContent.style.opacity = '1';
            }, 100);

            // Zoom effect
            const activeImg = slides[index].querySelector('img');
            setTimeout(() => {
                activeImg.style.transform = 'scale(1.1)';
            }, 100);
            
            // Update indicators and previews
            indicators.forEach((indicator, i) => {
                if (i === index) {
                    indicator.classList.add('w-4', 'bg-[#E67E22]');
                    indicator.classList.remove('w-2', 'bg-gray-300');
                } else {
                    indicator.classList.remove('w-4', 'bg-[#E67E22]');
                    indicator.classList.add('w-2', 'bg-gray-300');
                }
            });

            previews.forEach((preview, i) => {
                if (i === index) {
                    preview.classList.remove('opacity-50');
                    preview.classList.add('opacity-100');
                } else {
                    preview.classList.add('opacity-50');
                    preview.classList.remove('opacity-100');
                }
            });
            
            // Update slide counter
            currentSlideNumber.textContent = index + 1;
            
            currentSlide = index;
            resetProgressBar();
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            showSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        function startAutoRotate() {
            stopAutoRotate();
            isAutoRotating = true;
            updatePlayPauseButton();
            autoRotateInterval = setInterval(() => {
                nextSlide();
            }, 5000);
        }

        function stopAutoRotate() {
            if (autoRotateInterval) {
                clearInterval(autoRotateInterval);
            }
            isAutoRotating = false;
            updatePlayPauseButton();
        }

        function toggleAutoRotate() {
            if (isAutoRotating) {
                stopAutoRotate();
            } else {
                startAutoRotate();
            }
        }

        function updatePlayPauseButton() {
            const icon = playPauseButton.querySelector('svg');
            if (isAutoRotating) {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />';
                playPauseButton.setAttribute('aria-label', 'Pause auto-rotation');
            } else {
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
                playPauseButton.setAttribute('aria-label', 'Start auto-rotation');
            }
        }

        function resetProgressBar() {
            progressBar.style.width = '0%';
            progressBar.style.transition = 'none';
            setTimeout(() => {
                progressBar.style.transition = 'width 5s linear';
                progressBar.style.width = '100%';
            }, 50);
        }

        // Touch events for mobile swipe
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        carousel.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        // Pause auto-rotation on hover
        carousel.addEventListener('mouseenter', stopAutoRotate);
        carousel.addEventListener('mouseleave', () => {
            if (isAutoRotating) {
                startAutoRotate();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            } else if (e.key === ' ') {
                toggleAutoRotate();
            } else if (e.key >= '1' && e.key <= '3') {
                goToSlide(parseInt(e.key) - 1);
            }
        });

        // Show navigation arrows on hover
        carousel.addEventListener('mouseenter', () => {
            const arrows = carousel.querySelectorAll('button[aria-label*="slide"]');
            arrows.forEach(arrow => arrow.classList.remove('opacity-0'));
        });

        carousel.addEventListener('mouseleave', () => {
            const arrows = carousel.querySelectorAll('button[aria-label*="slide"]');
            arrows.forEach(arrow => arrow.classList.add('opacity-0'));
        });

        // Initialize
        preloadImages();
        startAutoRotate();
        resetProgressBar();
    </script>

    <style>
        .slide {
            transition: opacity 0.5s ease-in-out;
        }
        .slide.active {
            opacity: 1;
        }
        .slide.hidden {
            opacity: 0;
            display: none;
        }
        #carousel {
            overflow: hidden;
        }
        #carousel button {
            transition: all 0.3s ease;
        }
        #carousel button:hover {
            transform: scale(1.1);
        }
        #carousel button:focus {
            outline: 2px solid #E67E22;
            outline-offset: 2px;
        }
        #carouselLoading {
            transition: opacity 0.3s ease;
        }
        .slide-content {
            will-change: transform, opacity;
        }
        .preview-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .preview-container::after {
            content: '';
            position: absolute;
            inset: 0;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }
        .preview-container:hover::after {
            border-color: #E67E22;
        }
    </style>

    <!-- Featured Products Section -->
    <div class="bg-white py-16 px-6 md:px-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h4 class="text-sm text-[#E67E22] uppercase tracking-widest font-light mb-3">Our Collection</h4>
                <h2 class="text-4xl font-light text-[#2C3E50]">Featured Products</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product Card 1 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-4 h-[400px]">
                        <img src="{{ asset('image/product-1.jpg') }}" alt="Wooden Table" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    <h3 class="text-xl font-light text-[#2C3E50] mb-2">Solid Oak Dining Table</h3>
                    <p class="text-gray-600 text-sm mb-4 font-light">Handcrafted from premium oak wood, perfect for family gatherings.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[#E67E22] font-light">$1,299</span>
                        <button class="text-[#2C3E50] hover:text-[#E67E22] transition-all duration-300 font-light focus:outline-none focus:text-[#E67E22]">View Details →</button>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-4 h-[400px]">
                        <img src="{{ asset('image/product-1.jpg') }}" alt="Wooden Chair" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    <h3 class="text-xl font-light text-[#2C3E50] mb-2">Modern Walnut Chair</h3>
                    <p class="text-gray-600 text-sm mb-4 font-light">Contemporary design meets traditional craftsmanship.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[#E67E22] font-light">$499</span>
                        <button class="text-[#2C3E50] hover:text-[#E67E22] transition-all duration-300 font-light focus:outline-none focus:text-[#E67E22]">View Details →</button>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="group">
                    <div class="relative overflow-hidden mb-4 h-[400px]">
                        <img src="{{ asset('image/product-3.jpg') }}" alt="Wooden Cabinet" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    <h3 class="text-xl font-light text-[#2C3E50] mb-2">Teak Storage Cabinet</h3>
                    <p class="text-gray-600 text-sm mb-4 font-light">Elegant storage solution with premium teak wood finish.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-[#E67E22] font-light">$899</span>
                        <button class="text-[#2C3E50] hover:text-[#E67E22] transition-all duration-300 font-light focus:outline-none focus:text-[#E67E22]">View Details →</button>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <button class="bg-transparent border-2 border-[#2C3E50] text-[#2C3E50] uppercase tracking-wider px-12 py-4 hover:bg-[#2C3E50] hover:text-white transition-all duration-300 font-light focus:outline-none focus:ring-2 focus:ring-[#2C3E50] focus:ring-offset-2">
                    View All Products
                </button>
            </div>
        </div>
    </div>

    <!-- Client Stories Section -->
    <div class="bg-[#FAF9F7] py-16 px-6 md:px-24">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-light text-[#2C3E50] tracking-wide mb-12 text-center">Client Stories</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 hover:shadow-lg transition-all duration-300">
                    <p class="text-lg text-gray-600 leading-relaxed font-light">"Saya sangat puas dengan kualitas produk dan pelayanan mereka. Mereka benar-benar mengerti seni kayu!"</p>
                    <p class="mt-6 text-[#2C3E50] font-light">John Doe</p>
                </div>
                <div class="bg-white p-8 hover:shadow-lg transition-all duration-300">
                    <p class="text-lg text-gray-600 leading-relaxed font-light">"Desain yang minimalis dan artistik membuat ruang saya terasa lebih hidup dan eksklusif."</p>
                    <p class="mt-6 text-[#2C3E50] font-light">Jane Smith</p>
                </div>
                <div class="bg-white p-8 hover:shadow-lg transition-all duration-300">
                    <p class="text-lg text-gray-600 leading-relaxed font-light">"Keindahan kayunya sangat memukau. Ini benar-benar investasi estetika yang berkelas."</p>
                    <p class="mt-6 text-[#2C3E50] font-light">Alex Johnson</p>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection
<link href="{{ asset('css/cart.css') }}" rel="stylesheet">
<script src="{{ asset('js/cart.js') }}" defer></script>
<div class="alerts-container"></div>