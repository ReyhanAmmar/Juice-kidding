<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juice Kidding â€” Jus segar 100% alami, tanpa pengawet. Pesan sekarang dan nikmati kesegaran langsung di rumahmu!">
    <title>Juice Kidding</title>

    {{-- Google Fonts: Nunito (brand primary) + Nunito Sans (fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400..900;1,400..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

    {{-- Page-specific head content --}}
    @yield('head')

    {{-- Tailwind CSS CDN v4 --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ===== Custom font-family override ===== */
        * { font-family: 'Nunito', 'Nunito Sans', sans-serif; }

        /* ===== Design Tokens (CSS Custom Properties) — Juice Kidding Brand ===== */
        :root {
            /* Primary — Oranye Jus (dari logo) */
            --color-primary: #E17D19;
            --color-primary-dark: #C45E0A;
            --color-primary-light: #FDF3E7;

            /* Secondary — Hijau Jus (dari logo) */
            --color-secondary: #96C84B;
            --color-secondary-dark: #6E9A2A;
            --color-secondary-light: #EEF7D8;

            /* Accent — Rainbow Palette (dari logo) */
            --color-accent-red: #E11919;
            --color-accent-yellow: #E1C819;
            --color-accent-blue: #194B96;
            --color-accent-purple: #7D4B96;
            --color-accent-pink: #E14B7D;
            --color-accent-green: #AFC84B;

            /* Semantic status colors */
            --color-success: var(--color-secondary);
            --color-error: var(--color-accent-red);
            --color-warning: var(--color-accent-yellow);
            --color-info: var(--color-accent-blue);

            /* Text — WCAG AA compliant, from DESIGN.md palette */
            --text-dark: #1A1820;       /* Body / heading — 14:1 on white */
            --text-body: #3D3A4A;       /* Body text — 9:1 on white */
            --text-muted: #9B97A8;      /* Muted / caption — 4.5:1 on white */
            --text-placeholder: #9B97A8;/* Muted — 4.5:1 on white */
            --text-inverse: #ffffff;
            --text-inverse-muted: rgba(255,255,255,0.75);

            /* Surfaces */
            --surface-page: #F8F7FC;    /* Halaman latar */
            --surface-card: #ffffff;
            --surface-elevated: #fafafa;
            --surface-brand-light: var(--color-primary-light);
            --surface-overlay: rgba(0,0,0,0.5);

            /* Borders */
            --border-subtle: #E8E6F0;   /* Border card / divider */
            --border-default: #d4d4d8;

            /* Z-index scale */
            --z-dropdown: 50;
            --z-sticky: 60;
            --z-navbar: 70;
            --z-modal-backdrop: 80;
            --z-modal: 90;
            --z-toast: 100;
            --z-tooltip: 110;
        }

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

        @keyframes floatGentle {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }
        .animate-float-gentle { animation: floatGentle 3.5s ease-in-out infinite; }

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

        /* Tilt effect */
        .tilt-card {
            transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.3s ease;
        }
        .tilt-card:hover {
            transform: translateY(-8px) scale(1.02) rotate3d(1, 1, 0, 2deg);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15);
        }

        /* ===== Shimmer Loading ===== */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .animate-shimmer {
            background: linear-gradient(90deg, transparent 25%, rgba(255,255,255,0.4) 50%, transparent 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* ===== Scale In ===== */
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-scale-in { animation: scaleIn 0.4s ease-out forwards; }

        /* ===== Slide In Left ===== */
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in-left { animation: slideInLeft 0.6s ease-out forwards; }

        /* ===== Card Hover Glow ===== */
        .card-glow {
            transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
        }
        .card-glow:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px -12px rgba(245, 158, 11, 0.25), 0 8px 24px -8px rgba(0,0,0,0.1);
        }

        /* ===== Hide Scrollbar ===== */
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }

        /* ===== Star Rating ===== */
        .star-filled { color: #F59E0B; }
        .star-empty { color: #D1D5DB; }

        /* ===== Text wrap utilities ===== */
        .text-wrap-balance { text-wrap: balance; }
        .text-wrap-pretty { text-wrap: pretty; }

        /* ===== Smooth pulse (replaces animate-bounce) ===== */
        @keyframes smoothPulse {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(-6px); opacity: 0.7; }
        }
        .animate-smooth-pulse { animation: smoothPulse 2s ease-in-out infinite; }

        @keyframes smoothPulseOnce {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }
        .animate-smooth-pulse-once { animation: smoothPulseOnce 0.4s ease-out; }

        /* ===== Reduced motion ===== */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body class="bg-white font-['Nunito'] antialiased overflow-x-hidden">

    @if(!isset($hideHeader))
        @include('partials.header')
    @elseif(!isset($hideMinimalHeader))
        {{-- Minimal Header for Auth Pages --}}
        <div class="absolute top-0 left-0 w-full p-6 z-50 flex justify-center sm:justify-start">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2 hover:opacity-90 transition-opacity bg-white/50 backdrop-blur-sm px-4 py-2 rounded-full shadow-sm">
                <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding Logo" class="h-8">
                <span class="text-amber-600 text-xl font-black tracking-tight" style="font-family: 'Nunito', sans-serif;">Juice Kidding</span>
            </a>
        </div>
    @endif

    @yield('content')

    @if(!isset($hideFooter))
        @include('partials.footer')
    @endif

    {{-- Floating Cart Button (only for customer pages) --}}
    @if(!isset($hideHeader))
    @php
        $cartCount = 0;
        if(Auth::check() && Auth::user()->id_role == 2) {
            $cartCount = \App\Models\Keranjang::where('id_customer', Auth::id())->sum('jumlah');
        }
    @endphp
    <a href="{{ route('customer.keranjang') }}" id="floating-cart" class="fixed bottom-8 right-8 z-[90] w-16 h-16 bg-amber-600 rounded-full shadow-[0px_8px_30px_rgba(225,125,25,0.4)] flex justify-center items-center hover:bg-amber-700 hover:scale-110 active:scale-95 transition-all duration-300 translate-y-32 opacity-0 pointer-events-none group">
        <i data-lucide="shopping-bag" class="w-7 h-7 text-white"></i>
        <span class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full text-white text-xs font-bold flex items-center justify-center shadow-sm {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
    </a>
    @endif

    {{-- ===== TOAST ===== --}}
    <div id="toast" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] bg-white shadow-[0px_10px_25px_-5px_rgba(0,0,0,0.15)] rounded-2xl px-6 py-4 flex items-center gap-3 pointer-events-none opacity-0 -translate-y-16 transition-all duration-500">
        <span id="toast-emoji" class="text-2xl">🛒</span>
        <span id="toast-msg" class="text-sm font-bold text-zinc-700 font-['Nunito']"></span>
    </div>

    {{-- ===== MODAL KUSTOMISASI MENU (Pop-Up ala GoFood/GrabFood, Juice Kidding Style) ===== --}}
    <div id="kustomisasi-modal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-zinc-900/60 backdrop-blur-sm hidden animate-fade-in">
        <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl animate-scale-in flex flex-col max-h-[85vh]">
            {{-- Header Modal --}}
            <div class="p-6 border-b border-zinc-100 flex items-center justify-between">
                <div>
                    <h3 id="modal-menu-name" class="text-xl font-black text-zinc-900 font-['Nunito']">Kustomisasi Menu</h3>
                    <p id="modal-menu-price-base" class="text-sm font-bold text-amber-600 mt-1"></p>
                </div>
                <button onclick="closeCustomizationModal()" class="w-10 h-10 rounded-full bg-zinc-50 hover:bg-zinc-100 flex items-center justify-center text-zinc-500 transition-all active:scale-90 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body Modal (Scrollable) --}}
            <div class="p-6 overflow-y-auto space-y-6 flex-1" id="modal-options-body">
                {{-- Konten pilihan opsi kustomisasi di-render via JS --}}
            </div>

            {{-- Footer Modal --}}
            <div class="p-6 border-t border-zinc-100 bg-zinc-50/50 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-zinc-500 text-sm font-bold font-['Nunito']">Kuantitas</span>
                    {{-- Quantity Selector Produk --}}
                    <div class="flex items-center bg-zinc-200/60 rounded-xl p-1">
                        <button onclick="changeModalQty(-1)" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-700 active:scale-90 transition-all font-bold cursor-pointer">-</button>
                        <span id="modal-product-qty" class="w-10 text-center font-black text-zinc-900">1</span>
                        <button onclick="changeModalQty(1)" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-700 active:scale-90 transition-all font-bold cursor-pointer">+</button>
                    </div>
                </div>

                <button id="btn-modal-submit" onclick="submitCustomization()" class="w-full py-4 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black rounded-2xl flex items-center justify-between px-6 transition-all active:scale-95 shadow-lg shadow-orange-500/25 cursor-pointer">
                    <span class="font-['Nunito']">Tambah ke Keranjang</span>
                    <span id="modal-total-price" class="font-['Nunito']">Rp0</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ===== SCRIPTS ===== --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // ===== Navbar scroll effect =====
        const navbar = document.getElementById('navbar');
        const fab = document.getElementById('floating-cart');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar?.classList.add('navbar-scrolled');
            } else {
                navbar?.classList.remove('navbar-scrolled');
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
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // ===== User Dropdown Toggle =====
        const ddBtn = document.getElementById('user-dropdown-btn');
        const ddMenu = document.getElementById('user-dropdown-menu');
        if (ddBtn && ddMenu) {
            ddBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = !ddMenu.classList.contains('invisible');
                if (isOpen) {
                    ddMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                    ddMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                } else {
                    ddMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                    ddMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                }
            });
            document.addEventListener('click', (e) => {
                if (!document.getElementById('user-dropdown-wrapper')?.contains(e.target)) {
                    ddMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                    ddMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                }
            });
        }
    });

    // ===== Toast Function =====
    function showToast(msg, emoji = '🛒', duration = 3000) {
        const t = document.getElementById('toast');
        const m = document.getElementById('toast-msg');
        const e = document.getElementById('toast-emoji');
        if (m) m.textContent = msg;
        if (e) {
            e.textContent = emoji;
            if (!emoji) {
                e.style.display = 'none';
            } else {
                e.style.display = '';
            }
        }
        if (t) {
            t.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
            t.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                t.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
                t.classList.remove('opacity-100', 'translate-y-0');
            }, duration);
        }
    }

    // ===== Add to Cart (AJAX) =====
    function addToCart(menuId, menuName, qty = 1) {
        const url = '/customer/keranjang/add';
        const csrfToken = '{{ csrf_token() }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                id_menu: menuId,
                jumlah: qty,
                opsi: []
            })
        })
        .then(async res => {
            if (!res.ok) {
                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
                    return;
                }
                if (res.status === 403) {
                    window.location.reload();
                    return;
                }
                const err = await res.json().catch(() => ({}));
                throw new Error(err.message || 'Gagal menambahkan ke keranjang');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                showToast('berhasil ditambahkan ke keranjang', '');
                bounceFloatingCart();
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang', '❌');
            }
        })
        .catch(err => {
            showToast(err.message, '❌');
        });
    }

    // Floating cart animation helper
    function bounceFloatingCart() {
        const fab = document.getElementById('floating-cart');
        if (fab) {
            fab.classList.remove('animate-smooth-pulse-once');
            void fab.offsetWidth; // reflow to restart
            fab.classList.add('animate-smooth-pulse-once');
            const badge = fab.querySelector('span');
            if (badge) {
                badge.classList.remove('hidden');
                let currentCount = parseInt(badge.textContent || '0');
                badge.textContent = currentCount + 1;
                badge.classList.add('scale-125');
                setTimeout(() => { badge.classList.remove('scale-125'); }, 300);
            }
        }
    }

    // ===== Modal Kustomisasi Menu (Pop-Up ala GoFood/GrabFood) =====
    let currentMenuData = null;
    let modalProductQty = 1;

    function showCustomizationModal(menuId) {
        const body = document.getElementById('modal-options-body');
        body.innerHTML = '<div class="text-center py-8"><i data-lucide="loader-2" class="w-8 h-8 text-amber-500 animate-spin mx-auto"></i><p class="text-zinc-500 text-xs mt-2">Memuat opsi...</p></div>';
        if (typeof lucide !== 'undefined') lucide.createIcons();

        document.getElementById('kustomisasi-modal').classList.remove('hidden');
        modalProductQty = 1;
        document.getElementById('modal-product-qty').innerText = modalProductQty;

        fetch(`/menu/${menuId}/kustomisasi`)
            .then(res => res.json())
            .then(data => {
                currentMenuData = data;
                renderModalContent();
            })
            .catch(() => {
                body.innerHTML = '<div class="text-center py-8 text-red-500"><p>Gagal memuat opsi kustomisasi.</p></div>';
            });
    }

    function renderModalContent() {
        const menu = currentMenuData.menu;
        const tipeOpsi = currentMenuData.tipe_opsi;

        document.getElementById('modal-menu-name').innerText = menu.nama_jus;
        document.getElementById('modal-menu-price-base').innerText = 'Harga dasar: Rp ' + menu.harga.toLocaleString('id-ID');

        const body = document.getElementById('modal-options-body');
        body.innerHTML = '';

        tipeOpsi.forEach(tipe => {
            if (tipe.opsi.length === 0) return;

            let tipeHtml = `
                <div>
                    <h4 class="text-xs font-black text-zinc-900 uppercase tracking-wider mb-3 flex items-center gap-2 font-['Nunito']">
                        ${tipe.nama_tipe}
                        ${tipe.wajib_pilih ? '<span class="text-[9px] bg-red-50 text-red-600 px-2 py-0.5 rounded-full font-bold">Wajib</span>' : '<span class="text-[9px] bg-zinc-100 text-zinc-500 px-2 py-0.5 rounded-full font-bold">Opsional</span>'}
                    </h4>
                    <div class="space-y-2.5">
            `;

            tipe.opsi.forEach((opsi, index) => {
                const inputType = tipe.pilih_banyak ? 'checkbox' : 'radio';
                const inputName = `opsi_${tipe.id_tipe_opsi}`;
                const isChecked = !tipe.pilih_banyak && tipe.wajib_pilih && index === 0 ? 'checked' : '';

                tipeHtml += `
                    <label class="flex items-center justify-between p-3 rounded-xl border border-zinc-200 bg-white hover:border-amber-300 transition-all cursor-pointer group active:scale-[0.98]">
                        <div class="flex items-center gap-3">
                            <input type="${inputType}" name="${inputName}" value="${opsi.id_opsi}" data-harga="${opsi.harga_tambahan}" ${isChecked} onchange="updateModalPrice()" class="opsi-input-modal accent-amber-600 rounded-md">
                            <span class="text-sm font-bold text-zinc-700 font-['Nunito']">${opsi.nama_opsi}</span>
                        </div>
                        ${opsi.harga_tambahan > 0 ? `<span class="text-xs font-black text-amber-600 font-['Nunito']">+Rp ${opsi.harga_tambahan.toLocaleString('id-ID')}</span>` : ''}
                    </label>
                `;
            });

            tipeHtml += '</div></div>';
            body.innerHTML += tipeHtml;
        });

        if (typeof lucide !== 'undefined') lucide.createIcons();
        updateModalPrice();
    }

    function updateModalPrice() {
        if (!currentMenuData) return;
        let basePrice = currentMenuData.menu.harga;
        let optionPrice = 0;

        document.querySelectorAll('.opsi-input-modal:checked').forEach(input => {
            optionPrice += parseInt(input.dataset.harga || 0);
        });

        let totalPrice = (basePrice + optionPrice) * modalProductQty;
        document.getElementById('modal-total-price').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }

    function changeModalQty(change) {
        modalProductQty = Math.max(1, modalProductQty + change);
        document.getElementById('modal-product-qty').innerText = modalProductQty;
        updateModalPrice();
    }

    function closeCustomizationModal() {
        document.getElementById('kustomisasi-modal').classList.add('hidden');
        currentMenuData = null;
    }

    function submitCustomization() {
        if (!currentMenuData) return;

        const selectedOpsi = [];
        document.querySelectorAll('.opsi-input-modal:checked').forEach(input => {
            selectedOpsi.push(parseInt(input.value));
        });

        const csrfToken = '{{ csrf_token() }}';

        fetch('/customer/keranjang/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id_menu: currentMenuData.menu.id_menu,
                jumlah: modalProductQty,
                opsi: selectedOpsi
            })
        })
        .then(async res => {
            if (!res.ok) {
                if (res.status === 401) {
                    window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
                    return;
                }
                if (res.status === 403) {
                    window.location.reload();
                    return;
                }
                const err = await res.json().catch(() => ({}));
                throw new Error(err.message || 'Gagal menambahkan ke keranjang');
            }
            return res.json();
        })
        .then(data => {
            if (data && data.success) {
                closeCustomizationModal();
                showToast('Berhasil ditambahkan ke keranjang', '🛒');
                if (typeof bounceFloatingCart === 'function') bounceFloatingCart();
            } else if (data) {
                showToast(data.message || 'Gagal menambahkan ke keranjang', '❌');
            }
        })
        .catch(err => {
            showToast(err.message, '❌');
        });
    }

    // Close modal on backdrop click
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('kustomisasi-modal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeCustomizationModal();
                }
            });
        }
    });
    </script>

    @yield('scripts')
</body>
</html>
