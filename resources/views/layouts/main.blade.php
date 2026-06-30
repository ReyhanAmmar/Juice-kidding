<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juice Kidding â€” Jus segar 100% alami, tanpa pengawet. Pesan sekarang dan nikmati kesegaran langsung di rumahmu!">
    <title>Juice Kidding â€” Taste the Rainbow, Segar & Colorful!</title>

    {{-- Google Fonts: Nunito Sans & Nunito --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Nunito:wght@900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN v4 --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ===== Custom font-family override ===== */
        * { font-family: 'Nunito Sans', sans-serif; }

        /* ===== Custom Animations ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in-right { animation: fadeInRight 0.7s ease-out forwards; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-8px) rotate(2deg); }
            75% { transform: translateY(4px) rotate(-1deg); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes bounceSlow {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        .animate-bounce-slow { animation: bounceSlow 3s ease-in-out infinite; }

        /* Stagger items */
        .stagger-item { opacity: 0; }
        .stagger-item.visible { animation: fadeInUp 0.5s ease-out forwards; }

        /* Card hover lift */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px 0 rgba(0,0,0,0.12);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }

        /* Navbar background on scroll */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        }

        /* Pulse glow for CTAs */
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(225,125,25, 0.4); }
            50% { box-shadow: 0 0 0 12px rgba(225,125,25, 0); }
        }
        .animate-pulse-glow { animation: pulseGlow 2s infinite; }

        /* Tilt effect */
        .tilt-card {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
        }
        .tilt-card:hover {
            transform: translateY(-8px) scale(1.02) rotate3d(1, 1, 0, 2deg);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-white font-['Nunito_Sans'] antialiased overflow-x-hidden">

    {{-- ===== NAVBAR ===== --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/70 backdrop-blur-md shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] border-b border-zinc-200/50">
        {{-- Rainbow bar --}}
        <div class="h-1 w-full bg-gradient-to-r from-red-600 via-amber-600 via-16% to-pink-500"></div>

        <div class="w-full max-w-[1280px] mx-auto h-20 px-8 flex justify-between items-center gap-8">
            {{-- Logo --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('beranda') }}">
                    <img class="h-10 w-auto hover:scale-105 transition-transform" src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding Logo">
                </a>
                <a href="{{ route('beranda') }}" class="flex items-center hover:opacity-90 transition-opacity">
                    <span class="text-[34px] font-black tracking-tight pt-1 flex items-center leading-none" style="font-family: 'Nunito', sans-serif;">
                        <span class="text-[#E92429]">J</span>
                        <span class="text-[#F47920]">u</span>
                        <span class="text-[#FDC310]">i</span>
                        <span class="text-[#9BCA3C]">c</span>
                        <span class="text-[#9BCA3C]">e</span>
                        <span class="w-2"></span>
                        <span class="text-[#1B5B9C]">K</span>
                        <span class="text-[#466EB4]">i</span>
                        <span class="text-[#8C4799]">d</span>
                        <span class="text-[#E73E86]">d</span>
                        <span class="text-[#F05A28]">i</span>
                        <span class="text-[#F58220]">n</span>
                        <span class="text-[#9BCA3C]">g</span>
                    </span>
                </a>
            </div>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-[480px]">
                <div class="w-full relative flex justify-center items-center">
                    <div class="w-full pl-11 pr-4 py-2.5 bg-white rounded-full shadow-sm border border-zinc-200 overflow-hidden focus-within:ring-2 focus-within:ring-amber-500/20 focus-within:border-amber-500 transition-all">
                        <input type="text" placeholder="Cari jus favoritmu..."
                               class="w-full bg-transparent text-sm font-medium font-['Nunito_Sans'] text-gray-900 placeholder-gray-400 outline-none">
                    </div>
                    <div class="absolute left-4">
                        <i data-lucide="search" class="w-4 h-4 text-zinc-400"></i>
                    </div>
                </div>
            </div>

            {{-- Nav Links & Actions --}}
            <div class="flex items-center gap-8 shrink-0">
                {{-- Nav Links --}}
                <div class="flex items-center gap-6">
                    <a href="/menu" class="py-1 border-b-2 border-amber-800">
                        <span class="text-amber-800 text-[15px] font-bold font-['Nunito_Sans']">Menu</span>
                    </a>
                    <a href="#langganan" class="py-1 group">
                        <span class="text-stone-600 group-hover:text-amber-800 text-[15px] font-bold font-['Nunito_Sans'] transition-colors">Langganan</span>
                    </a>
                    <a href="#hadiah" class="py-1 group">
                        <span class="text-stone-600 group-hover:text-amber-800 text-[15px] font-bold font-['Nunito_Sans'] transition-colors">Hadiah</span>
                    </a>
                </div>

                <div class="w-px h-6 bg-zinc-200"></div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('customer.keranjang') }}" class="w-9 h-9 rounded-full flex justify-center items-center hover:bg-amber-50 transition-colors">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-amber-800"></i>
                        </a>
                        <div class="w-9 h-9 rounded-full flex justify-center items-center cursor-pointer hover:bg-amber-50 transition-colors">
                            <i data-lucide="user" class="w-5 h-5 text-amber-800"></i>
                        </div>
                    @else
                        <a href="{{ route('customer.keranjang') ?? '#' }}" class="w-9 h-9 rounded-full flex justify-center items-center hover:bg-amber-50 transition-colors">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-amber-800"></i>
                        </a>
                        <a href="{{ route('login') }}" class="w-9 h-9 rounded-full flex justify-center items-center hover:bg-amber-50 transition-colors">
                            <i data-lucide="user" class="w-5 h-5 text-amber-800"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    @yield('content')

    {{-- ===== FOOTER ===== --}}
    <footer class="w-full px-8 py-16 bg-white border-t border-zinc-100 flex flex-col justify-center items-center relative overflow-hidden mt-12">
        <div class="max-w-[1280px] w-full mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            {{-- Brand --}}
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding" class="h-10">
                    <span class="text-amber-600 text-2xl font-black font-['Nunito'] tracking-tight">Juice Kidding</span>
                </div>
                <p class="text-zinc-500 text-sm font-medium font-['Nunito_Sans'] leading-relaxed mb-6">Squeeze the day! Nikmati kesegaran jus cold-pressed 100% organik langsung di depan pintumu.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-pink-100 hover:text-pink-600 transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-green-100 hover:text-green-600 transition-colors"><i data-lucide="message-circle" class="w-5 h-5"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-blue-100 hover:text-blue-600 transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                </div>
            </div>

            {{-- Links --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito_Sans'] mb-4">Eksplorasi</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('menu') }}" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Katalog Menu</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Langganan Mingguan</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Tukar Poin</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito_Sans'] mb-4">Bantuan</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Partners --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito_Sans'] mb-4">Tersedia di</h4>
                <div class="flex gap-4 mb-6">
                    <div class="w-16 h-16 bg-zinc-50 rounded-2xl border border-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-400">Gofood</div>
                    <div class="w-16 h-16 bg-zinc-50 rounded-2xl border border-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-400">Grab</div>
                </div>
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito_Sans'] mb-4">Pembayaran</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">QRIS</span>
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">GoPay</span>
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">BCA</span>
                </div>
            </div>
        </div>
        <div class="w-full max-w-[1280px] mx-auto mt-12 pt-8 border-t border-zinc-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-zinc-400 text-sm font-medium font-['Nunito_Sans']">© 2024 Juice Kidding. Squeeze the Day!</span>
            <div class="text-zinc-400 text-sm font-medium font-['Nunito_Sans'] flex items-center gap-1">
                Dibuat dengan <i data-lucide="heart" class="w-4 h-4 text-red-500 fill-red-500"></i> di Indonesia
            </div>
        </div>
    </footer>

    {{-- Floating Cart Button --}}
    <a href="{{ route('customer.keranjang') ?? '#' }}" id="floating-cart" class="fixed bottom-8 right-8 z-[90] w-16 h-16 bg-amber-600 rounded-full shadow-[0px_8px_30px_rgba(225,125,25,0.4)] flex justify-center items-center hover:bg-amber-700 hover:scale-110 active:scale-95 transition-all duration-300 translate-y-32 opacity-0 pointer-events-none group">
        <i data-lucide="shopping-bag" class="w-7 h-7 text-white"></i>
        <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-sm"></span>
    </a>

    {{-- ===== TOAST ===== --}}
    <div id="toast" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] bg-white shadow-[0px_10px_25px_-5px_rgba(0,0,0,0.15)] rounded-2xl px-6 py-4 flex items-center gap-3 pointer-events-none opacity-0 -translate-y-16 transition-all duration-500">
        <span id="toast-emoji" class="text-2xl">ðŸ›’</span>
        <span id="toast-msg" class="text-sm font-bold text-zinc-700 font-['Nunito_Sans']"></span>
    </div>

    {{-- ===== SCRIPTS ===== --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // ===== Navbar scroll effect =====
        const navbar = document.getElementById('navbar');
        const fab = document.getElementById('floating-cart');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
            
            // FAB Visibility
            if (fab) {
                if (window.scrollY > 400) {
                    fab.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
                } else {
                    fab.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
                }
            }
        });

        // ===== Menu Category Filter =====
        const catChips = document.querySelectorAll('.menu-cat-chip');
        const productItems = document.querySelectorAll('.product-item');

        catChips.forEach(chip => {
            chip.addEventListener('click', () => {
                // Reset all chips
                catChips.forEach(c => {
                    c.classList.remove('bg-amber-800', 'text-white', 'shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)]');
                    c.classList.add('bg-white', 'text-zinc-700', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-gray-200');
                });
                // Activate clicked
                chip.classList.add('bg-amber-800', 'text-white', 'shadow-[0px_0px_20px_5px_rgba(146,76,0,0.35)]');
                chip.classList.remove('bg-white', 'text-zinc-700', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-gray-200');

                const cat = chip.dataset.cat;
                productItems.forEach(item => {
                    if (cat === 'all' || item.dataset.cat === cat) {
                        item.style.display = '';
                        item.style.animation = 'fadeInUp 0.5s ease-out forwards';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // ===== Scroll-triggered Stagger Animations =====
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.stagger-item').forEach(el => observer.observe(el));

        // ===== Smooth Scroll for Anchor Links =====
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const targetId = link.getAttribute('href');
                if (targetId === '#') return;
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Re-init lucide
        lucide.createIcons();
    });

    // ===== Toast Function =====
    function showToast(msg, emoji = 'ðŸ›’', duration = 3000) {
        const t = document.getElementById('toast');
        const m = document.getElementById('toast-msg');
        const e = document.getElementById('toast-emoji');
        m.textContent = msg;
        e.textContent = emoji;
        t.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
        t.classList.add('opacity-100', 'translate-y-0');
        setTimeout(() => {
            t.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
            t.classList.remove('opacity-100', 'translate-y-0');
        }, duration);
    }

    // ===== Add to Cart =====
    function addToCart(name) {
        showToast(`${name} ditambahkan ke keranjang!`, 'ðŸ›’');
    }
    </script>

    @yield('scripts')
</html>
