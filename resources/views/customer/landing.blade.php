@extends('layouts.main')
@section('content')
    {{-- ===== HERO SECTION ===== --}}
    <section id="hero" class="w-full pt-[81px]">
        <div class="w-full px-8 bg-fuchsia-50 relative overflow-hidden flex items-center" style="height: calc(100vh - 81px); min-height: 600px;">
            {{-- Decorative blobs --}}
            <div class="size-64 absolute left-[32px] top-[128px] bg-yellow-400/20 rounded-full blur-[32px]"></div>
            <div class="size-96 absolute left-[288px] bottom-0 bg-orange-50/40 rounded-full blur-[32px]"></div>
            <div class="w-[523px] h-96 absolute right-[83px] top-[292px] opacity-50 bg-gradient-to-br from-yellow-400/30 to-lime-400/30 rounded-full blur-[32px]"></div>

            <div class="max-w-[1280px] w-full mx-auto relative flex justify-between items-center z-10">
                {{-- Left Content --}}
                <div class="flex flex-col ml-[61px]">
                    {{-- Hero headline --}}
                    <div class="w-[557px] mb-7">
                        <span class="text-zinc-700 text-6xl font-black font-['Nunito_Sans'] leading-[72px]">Taste the Rainbow.<br/></span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-red-500 via-yellow-400 via-green-500 via-blue-500 to-purple-500 text-6xl font-black font-['Nunito_Sans'] leading-[72px]">Segar & Colorful!</span>
                    </div>

                    {{-- Hero description --}}
                    <div class="w-[672px] max-w-[672px] mb-8">
                        <div class="text-stone-700 text-lg font-medium font-['Nunito_Sans'] leading-7">Segarkan harimu dengan jus cold-pressed 100% organik kami. Tanpa<br/>tambahan gula, hanya energi murni yang semarak dalam botol. Mari<br/>berjus ria!</div>
                    </div>

                    {{-- Location search box --}}
                    <div class="w-[554px] rounded-2xl overflow-hidden shadow-xl border border-white/50 bg-white/60 backdrop-blur-md">
                        {{-- Tab bar --}}
                        <div class="w-[554px] h-14 bg-white/40 flex items-center px-4 gap-2 border-b border-white/40" id="order-type-tabs">
                            <button type="button" class="tab-btn active bg-orange-500/10 px-4 py-2 rounded flex items-center gap-2 cursor-pointer transition-colors" data-tab="delivery">
                                <i data-lucide="truck" class="w-4 h-4 text-orange-500 tab-icon"></i>
                                <span class="text-orange-500 text-sm font-bold font-['Nunito_Sans'] tab-text">Delivery</span>
                            </button>
                            <button type="button" class="tab-btn px-4 py-2 hover:bg-neutral-50 rounded flex items-center gap-2 cursor-pointer transition-colors" data-tab="pickup">
                                <i data-lucide="store" class="w-4 h-4 text-neutral-500 tab-icon"></i>
                                <span class="text-neutral-500 text-sm font-medium font-['Nunito_Sans'] tab-text">Pickup</span>
                            </button>
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const tabs = document.querySelectorAll('#order-type-tabs .tab-btn');
                                const input = document.getElementById('location-input');
                                
                                tabs.forEach(tab => {
                                    tab.addEventListener('click', () => {
                                        tabs.forEach(t => {
                                            t.classList.remove('bg-orange-500/10', 'active');
                                            t.classList.add('hover:bg-neutral-50');
                                            t.querySelector('.tab-icon').classList.remove('text-orange-500');
                                            t.querySelector('.tab-icon').classList.add('text-neutral-500');
                                            t.querySelector('.tab-text').classList.remove('text-orange-500', 'font-bold');
                                            t.querySelector('.tab-text').classList.add('text-neutral-500', 'font-medium');
                                        });

                                        // Set active tab
                                        tab.classList.remove('hover:bg-neutral-50');
                                        tab.classList.add('bg-orange-500/10', 'active');
                                        tab.querySelector('.tab-icon').classList.remove('text-neutral-500');
                                        tab.querySelector('.tab-icon').classList.add('text-orange-500');
                                        tab.querySelector('.tab-text').classList.remove('text-neutral-500', 'font-medium');
                                        tab.querySelector('.tab-text').classList.add('text-orange-500', 'font-bold');
                                        
                                        // Change placeholder based on selection
                                        if (input) {
                                            if (tab.dataset.tab === 'pickup') {
                                                input.placeholder = "Pilih toko terdekat...";
                                            } else {
                                                input.placeholder = "Ketik lokasimu";
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                        {{-- Search input row --}}
                        <div class="w-[554px] h-16 flex items-center px-4 gap-3 bg-white/20">
                            <i data-lucide="map-pin" class="w-5 h-5 text-red-500 flex-shrink-0 drop-shadow-sm"></i>
                            <input type="text" id="location-input" placeholder="Ketik lokasimu"
                                   class="flex-1 h-10 bg-white/80 rounded-xl px-4 text-sm font-semibold font-['Nunito_Sans'] text-zinc-800 placeholder-zinc-500 outline-none focus:ring-2 focus:ring-orange-500/50 transition-all border border-white/60 shadow-inner">
                            <button class="w-32 h-10 bg-gradient-to-br from-red-400 to-orange-600 rounded flex items-center justify-center hover:opacity-90 transition-all active:scale-95 shadow-sm shadow-orange-500/30">
                                <span class="text-white text-sm font-bold font-['Nunito_Sans']">Cari</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Hero image --}}
                <div class="mr-[83px] animate-float">
                    <img class="w-[426px] h-[348px] object-contain" src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding Mascot">
                </div>
            </div>
        </div>
    </section>

    {{-- ===== QUICK ACTION BUTTONS ===== --}}
    <section class="w-full pt-12 pb-6 overflow-hidden">
        <div class="max-w-[1280px] mx-auto flex flex-wrap justify-center items-start gap-4 px-8">
            {{-- Racik Sendiri --}}
            <a href="#mixologist" class="px-6 py-3.5 bg-lime-200 rounded-full flex justify-start items-center gap-3 hover:bg-lime-300 transition-all active:scale-95">
                <i data-lucide="flask-conical" class="w-4 h-4 text-lime-600"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-zinc-700 text-sm font-normal font-['Nunito_Sans'] leading-4">Racik Sendiri</span>
                    <span class="opacity-70 text-zinc-700 text-[10px] font-normal font-['Nunito_Sans'] leading-4">Build & Kalori</span>
                </div>
            </a>
            {{-- Langganan --}}
            <a href="#langganan" class="px-6 py-3.5 bg-red-200 rounded-full flex justify-start items-center gap-3 hover:bg-red-300 transition-all active:scale-95">
                <i data-lucide="calendar-check" class="w-4 h-4 text-amber-800"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-zinc-700 text-sm font-normal font-['Nunito_Sans'] leading-4">Langganan</span>
                    <span class="opacity-70 text-zinc-700 text-[10px] font-normal font-['Nunito_Sans'] leading-4">Mingguan/Bulanan</span>
                </div>
            </a>
            {{-- Poin & Hadiah --}}
            <a href="#hadiah" class="px-6 py-3.5 bg-orange-400 rounded-full flex justify-start items-center gap-3 hover:bg-orange-500 transition-all active:scale-95">
                <i data-lucide="gift" class="w-5 h-5 text-white"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-white text-sm font-normal font-['Nunito_Sans'] leading-4">Poin & Hadiah</span>
                    <span class="opacity-80 text-white text-[10px] font-normal font-['Nunito_Sans'] leading-4">Loyalty Reward</span>
                </div>
            </a>
            {{-- Favorit --}}
            <a href="#menu" class="px-6 py-3 bg-fuchsia-50 rounded-full outline outline-2 outline-offset-[-2px] outline-amber-600 flex justify-start items-center gap-3 hover:bg-fuchsia-100 transition-all active:scale-95">
                <i data-lucide="heart" class="w-5 h-5 text-amber-800"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-amber-800 text-sm font-normal font-['Nunito_Sans'] leading-4">Favorit</span>
                    <span class="text-stone-700 text-[10px] font-normal font-['Nunito_Sans'] leading-4">Pilihan Kamu</span>
                </div>
            </a>
        </div>
    </section>

    {{-- ===== MENU LENGKAP ===== --}}
    <section id="menu" class="w-full">
        <div class="max-w-[1280px] mx-auto px-8 py-16">
            {{-- Title --}}
            <div class="pb-12 flex flex-col justify-start items-center">
                <h2 class="text-center text-zinc-900 text-5xl font-extrabold font-['Nunito_Sans'] leading-[48px]">Menu Terlaris</h2>
                <p class="text-stone-500 text-base font-medium font-['Nunito_Sans'] mt-4">Jus paling favorit pilihan pelanggan setia kami.</p>
            </div>

        {{-- Product Grid --}}
        <div class="max-w-[1280px] mx-auto px-8 pb-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Product 1: Sunshine Citrus --}}
            <div class="product-item stagger-item bg-white rounded-2xl relative card-hover group shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)]" data-cat="terlaris">
                <div class="p-3">
                    <div class="h-48 bg-orange-50 rounded-xl flex flex-col justify-center items-start overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('images/sunshine_citrus.png') }}" alt="Sunshine Citrus" loading="lazy">
                    </div>
                </div>
                <div class="px-3 pb-2 flex justify-between items-start">
                    <span class="text-zinc-900 text-xl font-bold font-['Nunito_Sans'] leading-6">Sunshine Citrus</span>
                    <span class="px-2 py-1 bg-lime-100 rounded-full text-lime-600 text-xs font-bold font-['Nunito_Sans'] uppercase leading-3 tracking-wide">TERLARIS</span>
                </div>
                <div class="px-3 pb-4">
                    <span class="text-zinc-400 text-xs font-normal font-['Nunito_Sans'] leading-4">Jeruk, Wortel, Nanas, Jahe. Kaya vitamin C untuk<br/>energi harimu.</span>
                </div>
                <div class="px-3 pb-4 flex justify-between items-center">
                    <span class="text-amber-800 text-xl font-extrabold font-['Nunito_Sans'] leading-5">Rp 45.000</span>
                    <button onclick="addToCart('Sunshine Citrus')" class="size-10 relative bg-amber-800 rounded-full flex justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 active:scale-90 transition-all">
                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            </div>

            {{-- Product 2: Green Machine --}}
            <div class="product-item stagger-item bg-white rounded-2xl relative card-hover group shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)]" data-cat="detox">
                <div class="p-3">
                    <div class="h-48 bg-lime-100 rounded-xl flex flex-col justify-center items-start overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('images/green_machine.png') }}" alt="Green Machine" loading="lazy">
                    </div>
                </div>
                <div class="px-3 pb-2 flex justify-between items-start">
                    <span class="text-zinc-900 text-xl font-bold font-['Nunito_Sans'] leading-6">Green Machine</span>
                    <span class="px-2 py-1 bg-lime-100 rounded-full text-lime-600 text-xs font-bold font-['Nunito_Sans'] uppercase leading-3 tracking-wide">DETOX</span>
                </div>
                <div class="px-3 pb-4">
                    <span class="text-zinc-400 text-xs font-normal font-['Nunito_Sans'] leading-4">Bayam, Kale, Apel Hijau, Seledri, Lemon.<br/>Pembersih alami tubuh.</span>
                </div>
                <div class="px-3 pb-4 flex justify-between items-center">
                    <span class="text-amber-800 text-xl font-extrabold font-['Nunito_Sans'] leading-5">Rp 50.000</span>
                    <button onclick="addToCart('Green Machine')" class="size-10 relative bg-amber-800 rounded-full flex justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 active:scale-90 transition-all">
                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            </div>

            {{-- Product 3: Berry Blast --}}
            <div class="product-item stagger-item bg-white rounded-2xl relative card-hover group shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)]" data-cat="smoothies">
                <div class="p-3">
                    <div class="h-48 bg-blue-100 rounded-xl flex flex-col justify-center items-start overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('images/berry_blast.png') }}" alt="Berry Blast" loading="lazy">
                    </div>
                </div>
                <div class="px-3 pb-2 flex justify-start items-start">
                    <span class="text-zinc-900 text-xl font-bold font-['Nunito_Sans'] leading-6">Berry Blast</span>
                </div>
                <div class="px-3 pb-4">
                    <span class="text-zinc-400 text-xs font-normal font-['Nunito_Sans'] leading-4">Stroberi, Blueberry, Raspberry, Apel.<br/>Antioksidan tinggi.</span>
                </div>
                <div class="px-3 pb-4 flex justify-between items-center">
                    <span class="text-amber-800 text-xl font-extrabold font-['Nunito_Sans'] leading-5">Rp 55.000</span>
                    <button onclick="addToCart('Berry Blast')" class="size-10 relative bg-amber-800 rounded-full flex justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 active:scale-90 transition-all">
                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            </div>

            {{-- Product 4: Tropical Twist --}}
            <div class="product-item stagger-item bg-white rounded-2xl relative card-hover group shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)]" data-cat="pure">
                <div class="p-3">
                    <div class="h-48 bg-yellow-400/20 rounded-xl flex flex-col justify-center items-start overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('images/tropical_twist.png') }}" alt="Tropical Twist" loading="lazy">
                    </div>
                </div>
                <div class="px-3 pb-2 flex justify-start items-start">
                    <span class="text-zinc-900 text-xl font-bold font-['Nunito_Sans'] leading-6">Tropical Twist</span>
                </div>
                <div class="px-3 pb-4">
                    <span class="text-zinc-400 text-xs font-normal font-['Nunito_Sans'] leading-4">Mangga, Nanas, Markisa, Air Kelapa. Kesegaran<br/>tropis murni.</span>
                </div>
                <div class="px-3 pb-4 flex justify-between items-center">
                    <span class="text-amber-800 text-xl font-extrabold font-['Nunito_Sans'] leading-5">Rp 48.000</span>
                    <button onclick="addToCart('Tropical Twist')" class="size-10 relative bg-amber-800 rounded-full flex justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 active:scale-90 transition-all">
                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Lihat Semua Menu Button --}}
        <div class="w-full pb-16 flex justify-center mt-[-20px]">
            <a href="{{ route('menu') }}" class="px-8 py-3.5 bg-amber-800 rounded-full text-white text-base font-bold font-['Nunito_Sans'] shadow-[0px_4px_16px_rgba(225,125,25,0.35)] hover:shadow-lg active:scale-95 transition-all flex justify-center items-center gap-2 group">
                Lihat Semua Menu
                <i data-lucide="arrow-right" class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>

    {{-- ===== BE YOUR OWN MIXOLOGIST ===== --}}
    <section id="mixologist" class="w-full">
        <div class="max-w-[1280px] mx-auto px-32 pt-24 pb-16 bg-orange-50 rounded-[48px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] overflow-hidden relative">
            {{-- Decorative blob --}}
            <div class="size-96 absolute right-[32px] top-[176px] opacity-5 bg-amber-800 rounded-full blur-[32px]"></div>

            <div class="w-full max-w-[1024px] flex flex-col lg:flex-row justify-between items-center gap-12">
                {{-- Image --}}
                <div class="flex-1 flex justify-center items-start">
                    <img class="w-80 max-w-[488px] shadow-[0px_20px_13px_0px_rgba(0,0,0,0.03),0px_8px_5px_0px_rgba(0,0,0,0.08)] animate-bounce-slow" src="{{ asset('images/logo_maskot.png') }}" alt="Mixologist">
                </div>

                {{-- Content --}}
                <div class="flex-1 relative">
                    <div class="w-full max-w-[512px]">
                        <h2 class="text-amber-600 text-5xl font-black font-['Nunito_Sans'] leading-[52.80px]">Be Your Own<br/>Mixologist!</h2>
                    </div>
                    <div class="w-full max-w-[512px] mt-6">
                        <p class="text-zinc-700 text-sm font-medium font-['Nunito_Sans'] leading-6">Pilih buah favoritmu dan buat racikan unikmu sendiri. Bebas kreasi, rasa<br/>terjamin, sehat pastinya!</p>
                    </div>
                    <button class="mt-8 px-8 py-4 bg-amber-800 rounded-full inline-flex justify-start items-center gap-2 shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito_Sans'] leading-6">Mulai Racik</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-white"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== LANGGANAN JUS MINGGUAN ===== --}}
    <section id="langganan" class="w-full py-20 bg-violet-50">
        <div class="max-w-[1280px] mx-auto px-8">
            {{-- Title --}}
            <div class="flex flex-col justify-start items-center gap-3.5 mb-16">
                <h2 class="text-center text-zinc-900 text-5xl font-extrabold font-['Nunito_Sans'] leading-[48px]">Langganan Jus Mingguan</h2>
                <div class="w-[672px] max-w-full">
                    <p class="text-center text-stone-700 text-sm font-medium font-['Nunito_Sans'] leading-6">Lebih hemat, lebih sehat. Jus segar diantar otomatis ke pintu Anda setiap pagi.</p>
                </div>
            </div>

            {{-- Pricing Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto relative">

                {{-- Starter --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-yellow-400 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover">
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito_Sans'] leading-6">Starter</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito_Sans'] leading-9">Rp 250rb</span>
                        <span class="text-zinc-400 text-sm font-normal font-['Nunito_Sans'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4 pb-10">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">3 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Bebas Pilih Varian</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 bg-amber-800 rounded-full flex flex-col justify-center items-center hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito_Sans'] leading-6">Mulai Langganan</span>
                    </button>
                </div>

                {{-- Healthy (Popular) --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-lime-400 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover relative md:-translate-y-2">
                    {{-- PALING POPULER badge --}}
                    <div class="absolute left-1/2 -translate-x-1/2 -top-3 px-4 py-1 bg-lime-400 rounded-full z-10">
                        <span class="text-white text-xs font-bold font-['Nunito_Sans'] uppercase leading-3 tracking-wide">PALING POPULER</span>
                    </div>
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito_Sans'] leading-6">Healthy</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito_Sans'] leading-9">Rp 450rb</span>
                        <span class="text-zinc-400 text-sm font-normal font-['Nunito_Sans'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">6 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Bebas Pilih Varian</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Botol Kaca Eksklusif</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 relative bg-amber-800 rounded-full flex flex-col justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito_Sans'] leading-6">Mulai Langganan</span>
                    </button>
                </div>

                {{-- Ultimate --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-pink-500 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover">
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito_Sans'] leading-6">Ultimate</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito_Sans'] leading-9">Rp 800rb</span>
                        <span class="text-zinc-400 text-sm font-normal font-['Nunito_Sans'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">12 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Konsultasi Nutrisi</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Botol Kaca Eksklusif</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito_Sans'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 bg-amber-800 rounded-full flex flex-col justify-center items-center hover:bg-amber-900 transition-all active:scale-95 animate-pulse-glow">
                        <span class="text-center text-white text-base font-normal font-['Nunito_Sans'] leading-6">Mulai Langganan</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KUMPULKAN POIN & TUKAR HADIAH ===== --}}
    <section id="hadiah" class="w-full px-8 py-20 bg-white overflow-hidden">
        <div class="max-w-[1280px] mx-auto flex flex-col lg:flex-row justify-start items-center gap-12">
            {{-- Left â€” Image --}}
            <div class="flex-1 px-24 relative">
                <div class="w-[584px] h-96 absolute left-0 top-0 bg-gray-500/10 rounded-full blur-[32px]"></div>
                <img class="w-full h-96 max-w-96 relative object-contain animate-bounce-slow" src="{{ asset('images/logo_maskot.png') }}" alt="Rewards">
            </div>

            {{-- Right â€” Content --}}
            <div class="flex-1 flex flex-col justify-start items-start gap-8">
                <div class="self-stretch">
                    <h2 class="text-zinc-900 text-5xl font-extrabold font-['Nunito_Sans'] leading-[48px]">Kumpulkan Poin &amp; Tukar<br/>Hadiah</h2>
                </div>
                <div class="self-stretch">
                    <p class="text-stone-700 text-sm font-medium font-['Nunito_Sans'] leading-6">Setiap tegukan berharga! Tukarkan poinmu dengan merchandise lucu atau jus gratis.</p>
                </div>

                {{-- Reward icons --}}
                <div class="self-stretch pt-px flex justify-center items-start gap-4">
                    <div class="flex-1 p-4 bg-violet-50 rounded-2xl outline outline-1 outline-offset-[-1px] outline-gray-200 flex flex-col justify-start items-center gap-2">
                        <span class="text-center text-zinc-700 text-3xl leading-9">ðŸ¥¤</span>
                        <span class="text-center text-zinc-700 text-sm font-normal font-['Nunito_Sans'] leading-5">Tumbler Pelangi</span>
                    </div>
                    <div class="flex-1 p-4 bg-violet-50 rounded-2xl outline outline-1 outline-offset-[-1px] outline-gray-200 flex flex-col justify-start items-center gap-2">
                        <span class="text-center text-zinc-700 text-3xl leading-9">ðŸŽ‹</span>
                        <span class="text-center text-zinc-700 text-sm font-normal font-['Nunito_Sans'] leading-5">Sedotan Bambu Set</span>
                    </div>
                    <div class="flex-1 p-4 bg-violet-50 rounded-2xl outline outline-1 outline-offset-[-1px] outline-gray-200 flex flex-col justify-start items-center gap-2">
                        <span class="text-center text-zinc-700 text-3xl leading-9">ðŸŽŸï¸</span>
                        <span class="text-center text-zinc-700 text-sm font-normal font-['Nunito_Sans'] leading-5">Voucher Diskon</span>
                    </div>
                </div>

                <button class="px-8 py-4 bg-lime-800 rounded-full inline-flex justify-center items-center shadow-[0px_4px_6px_-4px_rgba(0,0,0,0.10)] shadow-lg hover:bg-lime-900 transition-all active:scale-95 animate-pulse-glow">
                    <span class="text-center text-white text-base font-normal font-['Nunito_Sans'] leading-6">Cek Rewards Saya</span>
                </button>
            </div>
        </div>
    </section>

    {{-- ===== TESTIMONIALS ===== --}}
    <section class="w-full py-24 bg-orange-50/50 relative overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-8">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-zinc-900 text-4xl font-extrabold font-['Nunito_Sans'] text-center">Apa Kata Mereka?</h2>
                <p class="text-stone-500 text-base font-medium font-['Nunito_Sans'] mt-4 text-center">Ribuan pelanggan telah membuktikan kesegaran Juice Kidding.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Testi 1 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-zinc-100 card-hover flex flex-col gap-4">
                    <div class="flex gap-1 text-yellow-400">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-zinc-600 font-medium font-['Nunito_Sans'] italic leading-relaxed flex-1">"Jus cold-pressed terbaik yang pernah saya coba. Teksturnya kental dan rasa buah aslinya sangat terasa. Auto langganan mingguan!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-rose-200 rounded-full flex items-center justify-center text-rose-700 font-bold text-xl">S</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito_Sans']">Sarah L.</h4>
                            <span class="text-zinc-400 text-sm font-['Nunito_Sans']">Pecinta Detox</span>
                        </div>
                    </div>
                </div>

                {{-- Testi 2 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-zinc-100 card-hover flex flex-col gap-4 translate-y-4">
                    <div class="flex gap-1 text-yellow-400">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-zinc-600 font-medium font-['Nunito_Sans'] italic leading-relaxed flex-1">"Sangat praktis untuk dibawa ke gym. Energi langsung naik setelah minum yang varian merah. Pengirimannya juga selalu on time!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl">D</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito_Sans']">Dimas R.</h4>
                            <span class="text-zinc-400 text-sm font-['Nunito_Sans']">Fitness Enthusiast</span>
                        </div>
                    </div>
                </div>

                {{-- Testi 3 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-zinc-100 card-hover flex flex-col gap-4">
                    <div class="flex gap-1 text-yellow-400">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-zinc-300"></i>
                    </div>
                    <p class="text-zinc-600 font-medium font-['Nunito_Sans'] italic leading-relaxed flex-1">"Anak-anak saya yang susah makan sayur jadi suka minum jus ini karena rasanya enak dan manis alami. Botolnya juga lucu!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-purple-700 font-bold text-xl">M</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito_Sans']">Mila A.</h4>
                            <span class="text-zinc-400 text-sm font-['Nunito_Sans']">Ibu Rumah Tangga</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
