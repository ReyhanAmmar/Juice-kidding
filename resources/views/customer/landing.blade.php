@extends('layouts.main')

@section('head')
<style>
    html { scroll-behavior: smooth; }
    
    @keyframes float-slow {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
    @keyframes float-medium {
        0%, 100% { transform: translateY(0) rotate(0deg) scale(1); }
        50% { transform: translateY(-15px) rotate(-5deg) scale(1.05); }
    }
    @keyframes float-fast {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(10deg); }
    }
    @keyframes blob-spin {
        0% { transform: rotate(0deg) scale(1); }
        50% { transform: rotate(180deg) scale(1.1); }
        100% { transform: rotate(360deg) scale(1); }
    }
    @keyframes text-reveal {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes pop-in {
        0% { opacity: 0; transform: scale(0.8); }
        70% { transform: scale(1.05); }
        100% { opacity: 1; transform: scale(1); }
    }
    .animate-float-slow { animation: float-slow 6s ease-in-out infinite; }
    .animate-float-medium { animation: float-medium 4s ease-in-out infinite; }
    .animate-float-fast { animation: float-fast 3s ease-in-out infinite; }
    .animate-blob { animation: blob-spin 20s linear infinite; }
    .animate-reveal { animation: text-reveal 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    .animate-pop { animation: pop-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; opacity: 0; }
    
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }
    
    .text-gradient {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 50%, #FFA83D 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection

@section('content')
    {{-- ===== HERO SECTION ===== --}}
    <section class="relative pt-[120px] pb-16 lg:pt-[140px] lg:pb-24 overflow-hidden bg-[#FFFDF9]">
        {{-- Decorative Background Blobs --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-orange-200/40 to-yellow-200/40 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gradient-to-tr from-rose-200/40 to-orange-100/40 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob translate-x-[-20%] translate-y-[20%] pointer-events-none" style="animation-direction: reverse;"></div>

        <div class="max-w-[1280px] mx-auto px-6 sm:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                
                {{-- Left Column: Text & CTA --}}
                <div class="max-w-2xl text-center lg:text-left mx-auto lg:mx-0">
                    @auth
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-100/80 backdrop-blur-sm text-orange-600 font-bold text-sm font-['Nunito'] mb-6 animate-reveal">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Halo, {{ Auth::user()->nama_lengkap }}! 👋
                    </div>
                    @endauth
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-zinc-900 leading-[1.1] mb-6 tracking-tight" style="font-family: 'Nunito', sans-serif;">
                        <span class="block animate-reveal delay-100">Taste the <span class="text-gradient">Rainbow.</span></span>
                        <span class="block animate-reveal delay-200 text-4xl md:text-5xl mt-2">Segar & Colorful!</span>
                    </h1>
                    
                    <p class="text-base md:text-lg text-zinc-500 mb-8 leading-relaxed font-medium max-w-lg mx-auto lg:mx-0 font-['Nunito'] animate-reveal delay-300">
                        Jus cold-pressed 100% organik, tanpa gula tambahan. Energi murni dalam botol — langsung ke pintumu. 🍹✨
                    </p>
                    
                    <div class="animate-reveal delay-400">
                        <a href="#menu" class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-black text-lg rounded-2xl shadow-[0_8px_30px_rgba(249,115,22,0.3)] hover:shadow-[0_8px_40px_rgba(249,115,22,0.4)] transition-all duration-300 hover:-translate-y-1 active:translate-y-0 overflow-hidden">
                            <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                            <span class="relative z-10 font-['Nunito'] tracking-wide">Lihat Menu Favorit</span>
                            <i data-lucide="arrow-down" class="relative z-10 w-5 h-5 group-hover:translate-y-1 transition-transform duration-300"></i>
                        </a>
                    </div>
                </div>
                
                {{-- Right Column: Mascot & Floating Elements --}}
                <div class="relative h-[350px] md:h-[450px] lg:h-[500px] flex items-center justify-center animate-pop delay-200 mt-6 lg:mt-0">
                    {{-- Glowing backdrop for mascot --}}
                    <div class="absolute inset-0 bg-gradient-to-tr from-amber-200/60 to-orange-300/60 rounded-full filter blur-3xl scale-[0.6] animate-pulse"></div>
                    
                    {{-- Main Mascot --}}
                    <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Mascot" class="relative z-10 w-2/3 max-w-[320px] lg:max-w-[400px] drop-shadow-[0_20px_40px_rgba(249,115,22,0.2)] animate-float-medium">
                    
                    {{-- Floating Fruits / Decor --}}
                    <div class="absolute top-[10%] right-[15%] text-4xl lg:text-5xl animate-float-fast delay-100 z-20 drop-shadow-lg">🍊</div>
                    <div class="absolute bottom-[20%] left-[10%] text-5xl lg:text-6xl animate-float-slow delay-300 z-20 drop-shadow-lg">🍓</div>
                    <div class="absolute top-[30%] left-[15%] text-3xl lg:text-4xl animate-float-fast delay-500 z-0 opacity-60">🍋</div>
                    <div class="absolute bottom-[15%] right-[20%] text-4xl lg:text-5xl animate-float-medium delay-200 z-20 drop-shadow-lg">🥭</div>
                </div>
                
            </div>
        </div>
    </section>

    {{-- ===== PROMO BANNER CAROUSEL ===== --}}
    @if($banners->count() > 0)
    <section class="w-full py-6 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            <div id="banner-carousel" class="relative overflow-hidden rounded-2xl shadow-lg" style="height: 200px;">
                @foreach($banners as $i => $banner)
                <div class="banner-slide absolute inset-0 transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}" data-index="{{ $i }}">
                    @if($banner->gambar)
                    <img src="{{ asset('storage/'.$banner->gambar) }}" alt="{{ $banner->judul }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center">
                        <h3 class="text-white text-3xl font-black font-['Nunito']">{{ $banner->judul }}</h3>
                    </div>
                    @endif
                    @if($banner->link)
                    <a href="{{ $banner->link }}" class="absolute inset-0"></a>
                    @endif
                </div>
                @endforeach
                {{-- Dots --}}
                @if($banners->count() > 1)
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach($banners as $i => $b)
                    <button class="banner-dot w-2.5 h-2.5 rounded-full transition-all {{ $i === 0 ? 'bg-white scale-110' : 'bg-white/50' }}" data-index="{{ $i }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.banner-slide');
        const dots = document.querySelectorAll('.banner-dot');
        if (slides.length <= 1) return;
        let current = 0;
        function showSlide(n) {
            slides.forEach(s => s.classList.replace('opacity-100', 'opacity-0'));
            dots.forEach(d => { d.classList.remove('bg-white', 'scale-110'); d.classList.add('bg-white/50'); });
            slides[n].classList.replace('opacity-0', 'opacity-100');
            if (dots[n]) { dots[n].classList.add('bg-white', 'scale-110'); dots[n].classList.remove('bg-white/50'); }
            current = n;
        }
        dots.forEach(d => d.addEventListener('click', () => showSlide(parseInt(d.dataset.index))));
        setInterval(() => showSlide((current + 1) % slides.length), 4000);
    });
    </script>
    @endif

    {{-- ===== QUICK ACTION BUTTONS ===== --}}
    <section class="w-full pt-6 pb-12 overflow-hidden border-b border-zinc-100">
        <div class="max-w-[1280px] mx-auto flex flex-wrap justify-center items-start gap-4 px-4 md:px-8">
            @auth
            {{-- Poin Saya --}}
            <a href="{{ route('customer.profil') }}" class="px-6 py-3.5 bg-amber-200 rounded-full flex justify-start items-center gap-3 hover:bg-amber-300 transition-all active:scale-95">
                <span class="text-lg">🪙</span>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-zinc-700 text-sm font-normal font-['Nunito'] leading-4">Poin Saya</span>
                    <span class="opacity-70 text-zinc-700 text-[10px] font-normal font-['Nunito'] leading-4">{{ number_format(Auth::user()->poin ?? 0, 0, ',', '.') }} Poin</span>
                </div>
            </a>
            @endauth
            {{-- Racik Sendiri --}}
            <a href="{{ route('customer.racik') }}" class="px-6 py-3.5 bg-lime-200 rounded-full flex justify-start items-center gap-3 hover:bg-lime-300 transition-all active:scale-95">
                <i data-lucide="flask-conical" class="w-4 h-4 text-lime-600"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-zinc-700 text-sm font-normal font-['Nunito'] leading-4">Racik Sendiri</span>
                    <span class="opacity-70 text-zinc-700 text-[10px] font-normal font-['Nunito'] leading-4">Build & Kalori</span>
                </div>
            </a>
            {{-- Langganan --}}
            <a href="{{ route('langganan.index') }}" class="px-6 py-3.5 bg-red-200 rounded-full flex justify-start items-center gap-3 hover:bg-red-300 transition-all active:scale-95">
                <i data-lucide="calendar-check" class="w-4 h-4 text-amber-800"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-zinc-700 text-sm font-normal font-['Nunito'] leading-4">Langganan</span>
                    <span class="opacity-70 text-zinc-700 text-[10px] font-normal font-['Nunito'] leading-4">Mingguan/Bulanan</span>
                </div>
            </a>

            {{-- Favorit --}}
            <a href="#menu" class="px-6 py-3 bg-fuchsia-50 rounded-full outline outline-2 outline-offset-[-2px] outline-amber-600 flex justify-start items-center gap-3 hover:bg-fuchsia-100 transition-all active:scale-95">
                <i data-lucide="heart" class="w-5 h-5 text-amber-800"></i>
                <div class="flex flex-col justify-start items-start">
                    <span class="text-amber-800 text-sm font-normal font-['Nunito'] leading-4">Favorit</span>
                    <span class="text-stone-700 text-[10px] font-normal font-['Nunito'] leading-4">Pilihan Kamu</span>
                </div>
            </a>
        </div>
    </section>

    {{-- ===== MENU TERLARIS ===== --}}
    <section id="menu" class="w-full">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-16">
            {{-- Title --}}
            <div class="pb-12 flex flex-col justify-start items-center">
                <h2 class="text-center text-zinc-900 text-4xl md:text-5xl font-extrabold font-['Nunito'] leading-[48px]">Menu Terlaris</h2>
                <p class="text-stone-600 text-base font-medium font-['Nunito'] mt-4">Jus paling favorit pilihan pelanggan setia kami.</p>
            </div>

        {{-- Product Horizontal Slider --}}
        <div class="max-w-[1280px] mx-auto px-4 md:px-8 pb-16 relative">
            <div class="flex overflow-x-auto gap-6 snap-x snap-mandatory hide-scrollbar pb-8" style="scrollbar-width: none;">
                @forelse($menuTerlaris as $menu)
                {{-- Dynamic Product Item --}}
                <div class="product-item snap-start shrink-0 w-[280px] bg-white rounded-2xl relative card-hover group shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] flex flex-col" data-cat="{{ strtolower($menu->kategori->nama_kategori ?? 'umum') }}">
                    <div class="p-3">
                        <div class="h-48 bg-orange-50 rounded-xl flex flex-col justify-center items-start overflow-hidden">
                            @if($menu->foto)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/'.$menu->foto) }}" alt="{{ $menu->nama_jus }}" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-orange-100 text-orange-300">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="px-3 pb-2 flex justify-between items-start">
                        <span class="text-zinc-900 text-xl font-bold font-['Nunito'] leading-6 truncate w-full" title="{{ $menu->nama_jus }}">{{ $menu->nama_jus }}</span>
                    </div>
                    <div class="px-3 pb-4">
                        <span class="text-zinc-500 text-xs font-normal font-['Nunito'] leading-4 line-clamp-2" title="{{ $menu->deskripsi }}">{{ $menu->deskripsi ?? 'Minuman jus sehat dan menyegarkan.' }}</span>
                    </div>
                    <div class="px-3 pb-4 flex justify-between items-center mt-auto">
                        <span class="text-amber-800 text-xl font-extrabold font-['Nunito'] leading-5">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        @auth
                        <button onclick="showCustomizationModal({{ $menu->id_menu }})" class="size-10 relative bg-amber-800 rounded-full flex justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 active:scale-90 transition-all cursor-pointer">
                            <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="size-10 relative bg-zinc-200 rounded-full flex justify-center items-center hover:bg-amber-100 hover:text-amber-700 transition-all">
                            <i data-lucide="lock" class="w-4 h-4 text-zinc-500"></i>
                        </a>
                        @endauth
                    </div>
                </div>
                @empty
                <div class="w-full text-center text-zinc-500 py-10 font-medium">
                    Belum ada menu yang tersedia saat ini.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Lihat Semua Menu Button --}}
        <div class="w-full pb-16 flex justify-center mt-[-20px]">
            <a href="{{ route('menu') }}" class="px-8 py-3.5 bg-amber-800 rounded-full text-white text-base font-bold font-['Nunito'] shadow-[0px_4px_16px_rgba(225,125,25,0.35)] hover:shadow-lg active:scale-95 transition-all flex justify-center items-center gap-2 group">
                Lihat Semua Menu
                <i data-lucide="arrow-right" class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </section>

    {{-- ===== BE YOUR OWN MIXOLOGIST ===== --}}
    <section id="mixologist" class="w-full py-20 bg-gradient-to-br from-orange-100/80 to-lime-50 relative overflow-hidden border-y border-orange-200/50">
        {{-- Decorative blobs --}}
        <div class="size-96 absolute right-[10%] top-[20%] opacity-10 bg-amber-800 rounded-full blur-[64px]"></div>
        <div class="size-72 absolute left-[5%] bottom-[10%] opacity-[0.07] bg-lime-500 rounded-full blur-[80px]"></div>

        {{-- Animation Keyframes --}}
        <style>
            @keyframes float-y {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-12px); }
            }
            @keyframes bubble-rise {
                0% { transform: translateY(0) scale(1); opacity: 0.7; }
                100% { transform: translateY(-180px) scale(0.3); opacity: 0; }
            }
            @keyframes wave {
                0%, 100% { d: path("M0,8 C30,4 60,12 96,8 C132,4 162,12 192,8 L192,40 L0,40 Z"); }
                50% { d: path("M0,12 C30,16 60,4 96,12 C132,16 162,4 192,12 L192,40 L0,40 Z"); }
            }
            @keyframes pulse-glow-mix {
                0%, 100% { box-shadow: 0 0 20px rgba(251, 146, 60, 0.2), 0 25px 50px -12px rgba(0,0,0,0.15); }
                50% { box-shadow: 0 0 35px rgba(251, 146, 60, 0.35), 0 25px 50px -12px rgba(0,0,0,0.2); }
            }
            @keyframes orbit {
                0% { transform: rotate(0deg) translateX(var(--orbit-radius)) rotate(0deg) scale(var(--fruit-scale, 1)); }
                100% { transform: rotate(360deg) translateX(var(--orbit-radius)) rotate(-360deg) scale(var(--fruit-scale, 1)); }
            }
            @keyframes sparkle {
                0%, 100% { opacity: 0; transform: scale(0) rotate(0deg); }
                50% { opacity: 1; transform: scale(1) rotate(180deg); }
            }
            @keyframes straw-sip {
                0%, 80%, 100% { transform: translateY(0); }
                90% { transform: translateY(-3px); }
            }
            .orbit-fruit {
                animation: orbit var(--orbit-duration) linear infinite;
                --orbit-radius: 120px;
                --fruit-scale: 1;
            }
            .orbit-fruit.paused { animation-play-state: paused; }
            .glass-idle { animation: float-y 4s ease-in-out infinite, pulse-glow-mix 3s ease-in-out infinite; }
        </style>

        <div class="max-w-[1280px] mx-auto px-4 md:px-8 relative z-10">
            <div class="w-full max-w-[1024px] mx-auto flex flex-col lg:flex-row justify-between items-center gap-12 lg:gap-24">
                
                {{-- Left: Animated Blender Scene --}}
                <div class="flex-1 flex justify-center items-center w-full relative" style="min-height: 420px;">
                    
                    {{-- Sparkle particles --}}
                    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
                        <div class="absolute top-[15%] left-[20%] w-2 h-2 bg-amber-300 rounded-full" style="animation: sparkle 3s ease-in-out infinite 0s;"></div>
                        <div class="absolute top-[25%] right-[25%] w-1.5 h-1.5 bg-lime-400 rounded-full" style="animation: sparkle 4s ease-in-out infinite 1s;"></div>
                        <div class="absolute bottom-[30%] left-[30%] w-1 h-1 bg-orange-300 rounded-full" style="animation: sparkle 3.5s ease-in-out infinite 0.5s;"></div>
                        <div class="absolute top-[60%] right-[15%] w-2 h-2 bg-yellow-300 rounded-full" style="animation: sparkle 2.8s ease-in-out infinite 1.5s;"></div>
                        <div class="absolute top-[40%] left-[10%] w-1.5 h-1.5 bg-rose-300 rounded-full" style="animation: sparkle 3.2s ease-in-out infinite 2s;"></div>
                    </div>

                    {{-- Glass with shadow --}}
                    <div class="relative flex flex-col items-center z-20">
                        <div class="absolute -bottom-4 w-32 h-4 bg-black/10 rounded-full blur-md"></div>
                        
                        <div id="glass-container" class="relative glass-idle" style="width: 160px; height: 220px;">
                            <div class="absolute inset-0 rounded-b-[2rem] rounded-t-lg border-[3px] border-white/70 bg-gradient-to-br from-white/40 to-white/20 backdrop-blur-md overflow-hidden">
                                <div class="absolute top-0 left-2 w-6 h-full bg-gradient-to-b from-white/50 to-transparent rounded-full blur-sm"></div>
                                
                                <div id="mix-liquid" class="absolute bottom-0 left-0 right-0 transition-all duration-700 ease-out overflow-hidden" style="height: 25%; background: linear-gradient(to top, #e5e7eb, #d1d5db);">
                                    <svg class="absolute -top-3 left-0 w-full" viewBox="0 0 192 20" preserveAspectRatio="none" style="height: 16px;">
                                        <path fill="currentColor" class="text-inherit opacity-40" d="M0,8 C30,4 60,12 96,8 C132,4 162,12 192,8 L192,40 L0,40 Z" style="animation: wave 3s ease-in-out infinite;"></path>
                                    </svg>
                                    <div class="absolute inset-0 opacity-30 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMTAiIGN5PSIxMCIgcj0iMiIgZmlsbD0id2hpdGUiLz48L3N2Zz4=')]"></div>
                                </div>

                                <div id="bubbles-container" class="absolute inset-0 overflow-hidden pointer-events-none"></div>
                            </div>

                            <div id="straw" class="absolute -top-8 right-8 w-3 rounded-full z-30 transition-all duration-500" style="height: 80px; background: linear-gradient(to right, #dc2626, #ef4444, #dc2626); opacity: 0; animation: straw-sip 4s ease-in-out infinite;">
                                <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 rounded-full border-2 border-red-500 bg-red-400"></div>
                            </div>
                        </div>


                    </div>

                    {{-- Orbiting Fruits --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                        <div class="relative" style="width: 280px; height: 280px;">
                            <div class="orbit-fruit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-4xl drop-shadow-lg" style="--orbit-duration: 8s; --orbit-radius: 130px; --fruit-scale: 1.1;">🍊</div>
                            <div class="orbit-fruit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-3xl drop-shadow-lg" style="--orbit-duration: 10s; --orbit-radius: 105px; --fruit-scale: 0.9; animation-delay: -3s;">🍓</div>
                            <div class="orbit-fruit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-4xl drop-shadow-lg" style="--orbit-duration: 12s; --orbit-radius: 140px; --fruit-scale: 1; animation-delay: -6s;">🥝</div>
                            <div class="orbit-fruit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-3xl drop-shadow-lg" style="--orbit-duration: 9s; --orbit-radius: 115px; --fruit-scale: 0.85; animation-delay: -1.5s;">🫐</div>
                            <div class="orbit-fruit absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-3xl drop-shadow-lg" style="--orbit-duration: 11s; --orbit-radius: 125px; --fruit-scale: 0.95; animation-delay: -7s;">🥭</div>
                        </div>
                    </div>
                </div>

                {{-- Right: Content --}}
                <div class="flex-1 relative w-full">
                    <div class="w-full">
                        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold font-['Nunito'] rounded-full mb-3 tracking-wider uppercase">✨ Custom Blend</span>
                        <h2 class="text-amber-600 text-4xl md:text-5xl font-black font-['Nunito'] leading-tight">Be Your Own<br/>Mixologist!</h2>
                    </div>
                    <div class="w-full mt-4">
                        <p class="text-zinc-700 text-base font-medium font-['Nunito'] leading-relaxed">Ciptakan racikan unikmu sendiri <span class="font-bold text-amber-700">tanpa batasan</span>. Nikmati buah segar pilihanmu, hitung kalori dengan mudah, dan mix & match sesukamu. Kami yang bikin, kalian yang nikmatin!</p>
                    </div>
                    <a href="{{ route('customer.racik') }}" class="mt-8 w-full md:w-auto px-8 py-4 bg-amber-600 rounded-full inline-flex justify-center items-center gap-2 shadow-[0px_0px_20px_5px_rgba(217,119,6,0.3)] hover:bg-amber-700 transition-all active:scale-95 group relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 w-full h-full transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                        <span class="text-center text-white text-base font-bold font-['Nunito'] leading-6 relative z-10">Mulai Racik</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-white relative z-10 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== KENAPA MEMILIH KAMI? ===== --}}
    <section class="w-full py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-zinc-900 text-4xl md:text-5xl font-extrabold font-['Nunito'] text-center">Kenapa Memilih Kami?</h2>
                <p class="text-stone-600 text-base font-medium font-['Nunito'] mt-4 text-center max-w-lg">Komitmen kami adalah menghadirkan jus terbaik dari bahan terbaik, langsung ke tanganmu.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Organik --}}
                <div class="stagger-item text-center p-8 rounded-3xl bg-green-50 border border-green-100 card-hover">
                    <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-2xl flex items-center justify-center text-3xl">🌿</div>
                    <h3 class="text-zinc-800 text-lg font-bold font-['Nunito'] mb-2">100% Organik</h3>
                    <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed">Semua bahan baku kami berasal dari petani organik lokal tersertifikasi.</p>
                </div>
                {{-- Tanpa Pengawet --}}
                <div class="stagger-item text-center p-8 rounded-3xl bg-rose-50 border border-rose-100 card-hover">
                    <div class="w-16 h-16 mx-auto mb-4 bg-rose-100 rounded-2xl flex items-center justify-center text-3xl">🚫</div>
                    <h3 class="text-zinc-800 text-lg font-bold font-['Nunito'] mb-2">Tanpa Pengawet</h3>
                    <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed">Tidak ada gula tambahan, pewarna buatan, atau bahan pengawet apapun.</p>
                </div>
                {{-- Gratis Ongkir --}}
                <div class="stagger-item text-center p-8 rounded-3xl bg-blue-50 border border-blue-100 card-hover">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl">🚚</div>
                    <h3 class="text-zinc-800 text-lg font-bold font-['Nunito'] mb-2">Gratis Ongkir</h3>
                    <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed">Pengiriman gratis untuk area tertentu. Jus segar langsung ke pintumu.</p>
                </div>
                {{-- Cold-Pressed --}}
                <div class="stagger-item text-center p-8 rounded-3xl bg-amber-50 border border-amber-100 card-hover">
                    <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 rounded-2xl flex items-center justify-center text-3xl">❄️</div>
                    <h3 class="text-zinc-800 text-lg font-bold font-['Nunito'] mb-2">Cold-Pressed</h3>
                    <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed">Teknik cold-pressed menjaga nutrisi & enzim alami tetap utuh.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== LANGGANAN JUS MINGGUAN ===== --}}
    <section id="langganan" class="w-full py-20 bg-violet-50">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            {{-- Title --}}
            <div class="flex flex-col justify-start items-center gap-3.5 mb-16">
                <h2 class="text-center text-zinc-900 text-4xl md:text-5xl font-extrabold font-['Nunito'] leading-[48px]">Langganan Jus Mingguan</h2>
                <div class="max-w-[672px]">
                    <p class="text-center text-stone-700 text-sm font-medium font-['Nunito'] leading-6">Lebih hemat, lebih sehat. Jus segar diantar otomatis ke pintu Anda setiap pagi.</p>
                </div>
            </div>

            {{-- Pricing Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto relative">

                {{-- Starter --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-yellow-400 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover">
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito'] leading-6">Starter</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito'] leading-9">Rp 250rb</span>
                        <span class="text-zinc-500 text-sm font-normal font-['Nunito'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4 pb-10">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">3 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Bebas Pilih Varian</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-yellow-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 bg-amber-800 rounded-full flex flex-col justify-center items-center hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito'] leading-6">Mulai Langganan</span>
                    </button>
                </div>

                {{-- Healthy (Popular) --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-lime-400 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover relative md:-translate-y-2">
                    <div class="absolute left-1/2 -translate-x-1/2 -top-3 px-4 py-1 bg-lime-400 rounded-full z-10">
                        <span class="text-white text-xs font-bold font-['Nunito'] uppercase leading-3 tracking-wide">PALING POPULER</span>
                    </div>
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito'] leading-6">Healthy</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito'] leading-9">Rp 450rb</span>
                        <span class="text-zinc-500 text-sm font-normal font-['Nunito'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">6 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Bebas Pilih Varian</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Botol Kaca Eksklusif</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-lime-400 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 relative bg-amber-800 rounded-full flex flex-col justify-center items-center shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)] hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito'] leading-6">Mulai Langganan</span>
                    </button>
                </div>

                {{-- Ultimate --}}
                <div class="stagger-item p-8 bg-white rounded-3xl border-t-4 border-pink-500 flex flex-col justify-start items-start shadow-[0px_8px_10px_-6px_rgba(0,0,0,0.04),0px_10px_25px_-5px_rgba(0,0,0,0.07)] card-hover">
                    <div class="self-stretch pb-2">
                        <h3 class="text-zinc-700 text-xl font-bold font-['Nunito'] leading-6">Ultimate</h3>
                    </div>
                    <div class="self-stretch pb-6 relative">
                        <span class="text-amber-800 text-3xl font-normal font-['Nunito'] leading-9">Rp 800rb</span>
                        <span class="text-zinc-500 text-sm font-normal font-['Nunito'] leading-5 ml-2">/minggu</span>
                    </div>
                    <div class="self-stretch pb-8">
                        <div class="flex flex-col justify-start items-start gap-4">
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">12 Botol / Minggu</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Konsultasi Nutrisi</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Botol Kaca Eksklusif</span>
                            </div>
                            <div class="self-stretch inline-flex justify-start items-center gap-2">
                                <div class="size-5 bg-pink-500 rounded-sm"></div>
                                <span class="text-zinc-700 text-base font-normal font-['Nunito'] leading-6">Gratis Ongkir</span>
                            </div>
                        </div>
                    </div>
                    <button class="self-stretch py-3 bg-amber-800 rounded-full flex flex-col justify-center items-center hover:bg-amber-900 transition-all active:scale-95">
                        <span class="text-center text-white text-base font-normal font-['Nunito'] leading-6">Mulai Langganan</span>
                    </button>
                </div>
            </div>
        </div>
    </section>


    {{-- ===== TESTIMONIALS ===== --}}
    <section class="w-full py-24 bg-orange-50/50 relative overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-zinc-900 text-4xl font-extrabold font-['Nunito'] text-center">Apa Kata Mereka?</h2>
                <p class="text-stone-600 text-base font-medium font-['Nunito'] mt-4 text-center">Ribuan pelanggan telah membuktikan kesegaran Juice Kidding.</p>
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
                    <p class="text-zinc-600 font-medium font-['Nunito'] italic leading-relaxed flex-1">"Jus cold-pressed terbaik yang pernah saya coba. Teksturnya kental dan rasa buah aslinya sangat terasa. Auto langganan mingguan!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-rose-200 rounded-full flex items-center justify-center text-rose-700 font-bold text-xl">S</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito']">Sarah L.</h4>
                            <span class="text-zinc-500 text-sm font-['Nunito']">Pecinta Detox</span>
                        </div>
                    </div>
                </div>

                {{-- Testi 2 --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-zinc-100 card-hover flex flex-col gap-4 md:translate-y-4">
                    <div class="flex gap-1 text-yellow-400">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-400"></i>
                    </div>
                    <p class="text-zinc-600 font-medium font-['Nunito'] italic leading-relaxed flex-1">"Sangat praktis untuk dibawa ke gym. Energi langsung naik setelah minum yang varian merah. Pengirimannya juga selalu on time!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center text-blue-700 font-bold text-xl">D</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito']">Dimas R.</h4>
                            <span class="text-zinc-500 text-sm font-['Nunito']">Fitness Enthusiast</span>
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
                    <p class="text-zinc-600 font-medium font-['Nunito'] italic leading-relaxed flex-1">"Anak-anak saya yang susah makan sayur jadi suka minum jus ini karena rasanya enak dan manis alami. Botolnya juga lucu!"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-zinc-100">
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center text-purple-700 font-bold text-xl">M</div>
                        <div>
                            <h4 class="text-zinc-900 font-bold font-['Nunito']">Mila A.</h4>
                            <span class="text-zinc-500 text-sm font-['Nunito']">Ibu Rumah Tangga</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ARTIKEL TERBARU ===== --}}
    @if(isset($artikels) && $artikels->count() > 0)
    <section class="w-full py-24 bg-white relative overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-zinc-900 text-4xl font-extrabold font-['Nunito'] text-center">Artikel Terbaru</h2>
                <p class="text-stone-600 text-base font-medium font-['Nunito'] mt-4 text-center">Temukan inspirasi dan tips sehat seputar gaya hidup.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($artikels as $artikel)
                    <a href="{{ route('artikel.detail', $artikel->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_30px_rgba(245,158,11,0.1)] transition-all duration-300 border border-zinc-100 flex flex-col hover:-translate-y-1">
                        <div class="w-full h-48 relative overflow-hidden bg-zinc-100">
                            @if($artikel->thumbnail)
                                <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                    <i data-lucide="image" class="w-8 h-8 text-amber-200"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-white/90 backdrop-blur rounded-full shadow-sm">
                                <span class="text-amber-700 text-[10px] font-bold font-['Nunito'] uppercase tracking-wider">{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-bold text-zinc-900 font-['Nunito'] leading-snug mb-3 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $artikel->judul }}</h3>
                            <p class="text-zinc-500 text-sm font-medium font-['Nunito'] line-clamp-2 mt-auto">{{ $artikel->ringkasan }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('artikel.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-100 text-amber-800 rounded-full text-sm font-bold font-['Nunito'] hover:bg-amber-200 transition-colors">
                    Baca Semua Artikel <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ===== CTA FINAL ===== --}}
    <section class="w-full py-24 bg-gradient-to-br from-amber-600 via-orange-500 to-red-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-[10%] text-8xl">🍊</div>
            <div class="absolute bottom-10 right-[15%] text-7xl">🍓</div>
            <div class="absolute top-1/2 left-[60%] text-6xl">🥝</div>
        </div>
        <div class="max-w-[800px] mx-auto px-4 md:px-8 text-center relative z-10">
            <h2 class="text-white text-4xl md:text-5xl font-black font-['Nunito'] leading-tight mb-6">Siap Mencoba Kesegaran<br/>Juice Kidding?</h2>
            <p class="text-white/80 text-lg font-medium font-['Nunito'] mb-10">Pesan sekarang dan rasakan energi murni dari buah-buahan segar pilihan. Gratis ongkir untuk pesanan pertamamu!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('menu') }}" class="px-10 py-4 bg-white rounded-full text-amber-700 text-lg font-bold font-['Nunito'] shadow-xl hover:shadow-2xl hover:scale-105 transition-all active:scale-95">
                    Pesan Sekarang
                </a>
                <a href="{{ route('customer.racik') }}" class="px-10 py-4 bg-white/20 backdrop-blur border-2 border-white/50 rounded-full text-white text-lg font-bold font-['Nunito'] hover:bg-white/30 transition-all active:scale-95">
                    Racik Sendiri
                </a>
            </div>
        </div>
    </section>

    {{-- Mixologist Animation Script --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const glass = document.getElementById('glass-container');
        const liquid = document.getElementById('mix-liquid');
        const bubblesContainer = document.getElementById('bubbles-container');
        const straw = document.getElementById('straw');
        const fruits = document.querySelectorAll('.orbit-fruit');

        if (!glass) return;

        const juiceCombos = [
            { name: '🍊 Tropical Blast', gradient: 'linear-gradient(to top, #ea580c, #fb923c, #fdba74)', waveColor: '#fb923c' },
            { name: '🍓 Berry Bliss', gradient: 'linear-gradient(to top, #be123c, #f43f5e, #fda4af)', waveColor: '#f43f5e' },
            { name: '🥝 Green Detox', gradient: 'linear-gradient(to top, #4d7c0f, #84cc16, #bef264)', waveColor: '#84cc16' },
            { name: '🫐 Purple Rain', gradient: 'linear-gradient(to top, #6d28d9, #8b5cf6, #c4b5fd)', waveColor: '#8b5cf6' },
            { name: '🥭 Mango Sunrise', gradient: 'linear-gradient(to top, #d97706, #f59e0b, #fde68a)', waveColor: '#f59e0b' },
        ];

        let comboIndex = 0;

        function createBubble() {
            const bubble = document.createElement('div');
            const size = Math.random() * 8 + 3;
            bubble.className = 'absolute rounded-full bg-white/40';
            bubble.style.width = size + 'px';
            bubble.style.height = size + 'px';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.bottom = '0';
            bubble.style.animation = `bubble-rise ${2 + Math.random() * 2}s ease-out forwards`;
            bubblesContainer.appendChild(bubble);
            setTimeout(() => bubble.remove(), 4000);
        }

        function spawnBubbles(duration) {
            const interval = setInterval(() => createBubble(), 150);
            setTimeout(() => clearInterval(interval), duration);
        }

        function animateCycle() {
            const combo = juiceCombos[comboIndex % juiceCombos.length];
            comboIndex++;

            fruits.forEach(f => f.classList.remove('paused'));
            liquid.style.height = '25%';
            liquid.style.background = 'linear-gradient(to top, #e5e7eb, #d1d5db)';
            straw.style.opacity = '0';

            setTimeout(() => {
                fruits.forEach((fruit, i) => {
                    setTimeout(() => {
                        fruit.classList.add('paused');
                        fruit.style.transition = 'all 0.8s cubic-bezier(0.22, 1, 0.36, 1)';
                        fruit.style.transform = 'translate(-50%, -50%) scale(0)';
                        fruit.style.opacity = '0';
                    }, i * 180);
                });
            }, 2500);

            setTimeout(() => {
                glass.classList.remove('glass-idle');
                let shakeId = setInterval(() => {
                    const rx = (Math.random() - 0.5) * 6;
                    const ry = (Math.random() - 0.5) * 3;
                    glass.style.transform = `translate(${rx}px, ${ry}px) rotate(${rx * 0.3}deg)`;
                }, 40);

                liquid.style.background = combo.gradient;
                
                let h = 25;
                const fillInterval = setInterval(() => {
                    h += 0.8;
                    if (h >= 75) { clearInterval(fillInterval); h = 75; }
                    liquid.style.height = h + '%';
                }, 30);

                spawnBubbles(2500);

                setTimeout(() => {
                    clearInterval(shakeId);
                    glass.style.transform = '';
                    glass.classList.add('glass-idle');

                    straw.style.opacity = '1';
                    straw.style.background = `linear-gradient(to right, ${combo.waveColor}cc, ${combo.waveColor}, ${combo.waveColor}cc)`;

                    setTimeout(() => {
                        straw.style.opacity = '0';

                        setTimeout(() => {
                            fruits.forEach(fruit => {
                                fruit.style.transition = 'none';
                                fruit.style.transform = '';
                                fruit.style.opacity = '1';
                                fruit.classList.remove('paused');
                            });
                            void glass.offsetWidth;
                            animateCycle();
                        }, 600);

                    }, 3000);

                }, 2500);

            }, 3600);
        }

        animateCycle();
    });
    </script>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('#order-type-tabs .tab-btn');
    const input = document.getElementById('location-input');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('active');
                t.classList.add('text-zinc-500', 'font-semibold', 'hover:bg-white/60');
            });
            tab.classList.remove('text-zinc-500', 'font-semibold', 'hover:bg-white/60');
            tab.classList.add('active');

            if (input) {
                input.placeholder = tab.dataset.tab === 'pickup'
                    ? 'Pilih toko terdekat...'
                    : 'Ketik lokasimu';
            }
        });
    });
});
</script>
@endsection
