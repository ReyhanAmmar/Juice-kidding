@extends('layouts.main')

@section('content')
{{-- Hero Section --}}
<section class="relative px-8 pt-[120px] pb-12 overflow-hidden bg-orange-50/50">
    {{-- Decorative blobs --}}
    <div class="size-64 absolute right-[-32px] top-[64px] bg-yellow-400/20 rounded-full blur-[32px]"></div>
    
    <div class="max-w-[1280px] mx-auto relative z-10 animate-fade-in-up">
        {{-- Greeting --}}
        @auth
        <p class="text-sm font-bold text-amber-800/80 mb-2 font-['Nunito_Sans']">
            Halo, <span class="text-amber-800">{{ Auth::user()->nama_lengkap }} 👋</span>
        </p>
        @endauth

        <h1 class="text-4xl lg:text-5xl font-black text-zinc-900 leading-tight mb-4" style="font-family: 'Nunito', sans-serif;">
            Katalog
            <span class="animate-rainbow">Jus Segar</span>
        </h1>
        <p class="text-base font-medium text-stone-600 mt-2 leading-relaxed max-w-lg font-['Nunito_Sans']">
            Dari jus detoksifikasi hingga penambah energi. Pilih rekomendasi kami atau bangun racikan sehatmu sendiri! 🍹
        </p>

        {{-- Search Bar --}}
        <div class="mt-8 relative max-w-xl">
            <div class="flex items-center bg-white border-2 border-zinc-200 rounded-full px-5 py-3.5 gap-3 shadow-sm
                        focus-within:border-amber-500 focus-within:ring-4 focus-within:ring-amber-500/20 transition-all">
                <i data-lucide="search" class="w-5 h-5 text-zinc-400 flex-shrink-0"></i>
                <input type="text" id="search-input" placeholder="Cari jus favoritmu..."
                       class="w-full bg-transparent text-base font-medium text-zinc-900 placeholder-zinc-400 outline-none font-['Nunito_Sans']">
                <button id="search-clear" class="hidden w-6 h-6 rounded-full bg-zinc-200 text-zinc-500 flex items-center justify-center hover:bg-zinc-300 transition-all flex-shrink-0">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<div class="max-w-[1280px] mx-auto">
    {{-- Category Chips --}}
    <section class="px-8 mt-12 mb-8">
        <div class="flex gap-3 overflow-x-auto hide-scrollbar pb-4" id="category-chips">
            <button data-category="all"
                    class="category-chip px-6 py-2.5 bg-amber-800 rounded-full text-white text-sm font-bold font-['Nunito_Sans'] shadow-[0px_4px_16px_rgba(225,125,25,0.35)] transition-all active:scale-95 whitespace-nowrap">
                Semua
            </button>
            <button data-category="terlaris"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Terlaris
            </button>
            <button data-category="buah"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Buah
            </button>
            <button data-category="sayur"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Sayur
            </button>
            <button data-category="mix"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Mix
            </button>
            <button data-category="detox"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Detox & Diet
            </button>
            <button data-category="smoothies"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Smoothies
            </button>
            <button data-category="booster"
                    class="category-chip px-6 py-2.5 bg-white rounded-full outline outline-2 outline-offset-[-2px] outline-gray-200 text-zinc-600 text-sm font-bold font-['Nunito_Sans'] hover:outline-amber-800 hover:text-amber-800 transition-all active:scale-95 whitespace-nowrap">
                Booster
            </button>
        </div>
    </section>

    {{-- Product Grid --}}
    <section id="katalog" class="px-8 pb-20">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black text-zinc-900" style="font-family: 'Nunito', sans-serif;">Menu Pilihan 🥤</h2>
            <span id="product-count" class="text-sm font-bold text-zinc-500 font-['Nunito_Sans']">{{ count($menus) }} menu</span>
        </div>

        {{-- Grid --}}
        <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($menus as $index => $menu)
            <div class="product-card stagger-item bg-white rounded-3xl overflow-hidden card-hover border border-black/5 group relative"
                 data-category="{{ $menu->id_kategori }}"
                 data-name="{{ strtolower($menu->nama_jus) }}"
                 style="animation-delay: {{ $index * 60 }}ms">

                {{-- Thumbnail --}}
                <div class="relative overflow-hidden bg-slate-50 cursor-pointer group" onclick="openQuickView('{{ addslashes($menu->nama_jus) }}', '{{ $menu->harga }}', '{{ $menu->kategori->nama_kategori ?? 'Umum' }}', '{{ asset($menu->foto ? 'uploads/' . $menu->foto : 'images/logo_maskot.png') }}', '{{ $menu->estimasi_kalori ?? '???' }}')">
                    @if($menu->foto)
                        <img src="{{ asset('uploads/' . $menu->foto) }}"
                             class="w-full h-40 lg:h-48 object-cover group-hover:scale-110 transition-transform duration-500"
                             alt="{{ $menu->nama_jus }}" loading="lazy">
                    @else
                        <div class="w-full h-40 lg:h-48 bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                            <span class="text-5xl opacity-50">🥤</span>
                        </div>
                    @endif

                    {{-- Badge habis --}}
                    @if($menu->id_status_stok == 2)
                    <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-[2px] flex items-center justify-center z-10">
                        <span class="text-white text-xs font-bold bg-zinc-800 px-3 py-1.5 rounded-full font-['Nunito_Sans']">
                            Habis
                        </span>
                    </div>
                    @endif

                    {{-- Category tag --}}
                    <div class="absolute top-3 left-3 z-20">
                        <span class="text-[10px] font-bold uppercase tracking-wider bg-white/90 backdrop-blur-md text-amber-800 px-3 py-1 rounded-full shadow-sm font-['Nunito_Sans']">
                            {{ $menu->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-5">
                    <h3 class="text-lg font-bold text-zinc-900 leading-tight line-clamp-1 font-['Nunito_Sans']">
                        {{ $menu->nama_jus }}
                    </h3>
                    @if($menu->estimasi_kalori)
                    <p class="text-xs font-bold text-zinc-400 mt-1 font-['Nunito_Sans']">
                        🔥 {{ $menu->estimasi_kalori }} kkal
                    </p>
                    @else
                    <p class="text-xs font-bold text-zinc-400 mt-1 font-['Nunito_Sans']">
                        🍹 100% Organik
                    </p>
                    @endif
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-amber-600 font-black text-xl" style="font-family: 'Nunito', sans-serif;">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                        @if($menu->id_status_stok != 2)
                            @auth
                            <button onclick="addToCart({{ $menu->id_menu }}, '{{ $menu->nama_jus }}')"
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-orange-500/30
                                           hover:opacity-90 active:scale-95 transition-all z-20 relative cursor-pointer">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                            </button>
                            @else
                            <a href="{{ route('login') }}"
                               class="w-10 h-10 rounded-full bg-zinc-100 text-zinc-400 flex items-center justify-center
                                      hover:bg-amber-100 hover:text-amber-800 transition-all z-20 relative">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
            @empty
            {{-- Empty State --}}
            <div class="col-span-full text-center py-20" id="empty-state">
                <img src="{{ asset('images/logo_maskot.png') }}" alt=""
                     class="w-40 h-40 object-contain mx-auto opacity-50 animate-bounce-slow">
                <h3 class="text-2xl font-black text-zinc-900 mt-6" style="font-family: 'Nunito', sans-serif;">Belum Ada Menu</h3>
                <p class="text-base font-medium text-zinc-500 mt-2 font-['Nunito_Sans']">Katalog menu jus sedang disiapkan. Cek lagi nanti ya! 🍹</p>
            </div>
            @endforelse
        </div>

        {{-- No results (hidden by default) --}}
        <div id="no-results" class="hidden text-center py-20">
            <div class="w-20 h-20 rounded-full bg-zinc-50 border border-zinc-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search-x" class="w-8 h-8 text-zinc-300"></i>
            </div>
            <h3 class="text-xl font-bold text-zinc-900 font-['Nunito_Sans']">Tidak Ditemukan</h3>
            <p class="text-sm font-medium text-zinc-500 mt-1 font-['Nunito_Sans']">Coba kata kunci lain atau ubah kategori</p>
        </div>
    </section>


    {{-- Quick View Modal --}}
    <div id="quickview-modal" class="fixed inset-0 z-[100] flex items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm modal-overlay" onclick="closeQuickView()"></div>
        <div class="bg-white rounded-[2rem] w-full max-w-lg p-6 relative z-10 transform scale-95 opacity-0 transition-all duration-300 flex flex-col sm:flex-row gap-6 shadow-2xl modal-content mx-4">
            <button onclick="closeQuickView()" class="absolute top-4 right-4 w-8 h-8 bg-zinc-100 rounded-full flex items-center justify-center text-zinc-500 hover:bg-red-100 hover:text-red-500 transition-colors z-20">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
            <div class="w-full sm:w-2/5 h-48 sm:h-auto bg-amber-50 rounded-2xl overflow-hidden flex items-center justify-center flex-shrink-0 relative">
                <img id="qv-img" src="" alt="" class="w-full h-full object-cover">
                <div class="absolute top-2 left-2 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-full text-[10px] font-bold text-amber-800 shadow-sm" id="qv-cat">Kategori</div>
            </div>
            <div class="flex-1 flex flex-col">
                <h3 id="qv-title" class="text-2xl font-black text-zinc-900 leading-tight mb-2 font-['Nunito']">Nama Jus</h3>
                <div class="flex items-center gap-4 mb-4">
                    <span id="qv-price" class="text-amber-600 text-xl font-bold font-['Nunito_Sans']">Rp 0</span>
                    <span class="px-2 py-1 bg-orange-100 text-orange-600 rounded text-xs font-bold flex items-center gap-1">
                        <i data-lucide="flame" class="w-3 h-3"></i> <span id="qv-cal">0</span> kkal
                    </span>
                </div>
                <p class="text-zinc-500 text-sm font-medium font-['Nunito_Sans'] leading-relaxed mb-6 flex-1">Terbuat dari 100% buah organik pilihan tanpa tambahan gula dan air. Segar, sehat, dan kaya akan vitamin.</p>
                <button onclick="addToCart(0, document.getElementById('qv-title').textContent); closeQuickView();" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl flex items-center justify-center gap-2 transition-colors shadow-lg shadow-amber-600/30">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>Tambah ke Keranjang</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');
    const chips = document.querySelectorAll('.category-chip');
    const cards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('no-results');
    const productCount = document.getElementById('product-count');

    let activeCategory = 'all';

    // ===== Category Filter =====
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            // Update active chip style
            chips.forEach(c => {
                c.classList.remove('text-white', 'bg-amber-800', 'shadow-[0px_4px_16px_rgba(225,125,25,0.35)]');
                c.classList.add('text-zinc-600', 'bg-white', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-gray-200');
            });
            chip.classList.add('text-white', 'bg-amber-800', 'shadow-[0px_4px_16px_rgba(225,125,25,0.35)]');
            chip.classList.remove('text-zinc-600', 'bg-white', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-gray-200');

            activeCategory = chip.dataset.category;
            filterProducts();
        });
    });

    // ===== Search =====
    if(searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            searchClear.classList.toggle('hidden', !query);
            filterProducts();
        });
    }

    if(searchClear) {
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            searchClear.classList.add('hidden');
            filterProducts();
        });
    }

    // ===== Filter Logic =====
    function filterProducts() {
        if(!searchInput) return;
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        cards.forEach(card => {
            const matchCategory = activeCategory === 'all' || card.dataset.category === activeCategory;
            const matchSearch = !query || card.dataset.name.includes(query);
            const show = matchCategory && matchSearch;

            card.style.display = show ? '' : 'none';
            if (show) {
                visibleCount++;
                card.classList.add('visible');
            }
        });

        if(noResults) noResults.classList.toggle('hidden', visibleCount > 0);
        if(productCount) productCount.textContent = visibleCount + ' menu';
    }

    // ===== Init stagger animation =====
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.05 });

    document.querySelectorAll('.stagger-item').forEach((el, i) => {
        el.style.animationDelay = `${i * 40}ms`;
        observer.observe(el);
    });
    
    // ===== Quick View =====
    window.openQuickView = function(title, price, cat, img, cal) {
        document.getElementById('qv-title').textContent = title;
        document.getElementById('qv-price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('qv-cat').textContent = cat;
        document.getElementById('qv-img').src = img;
        document.getElementById('qv-cal').textContent = cal;

        const modal = document.getElementById('quickview-modal');
        const content = modal.querySelector('.modal-content');
        
        modal.classList.remove('pointer-events-none', 'opacity-0');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    };

    window.closeQuickView = function() {
        const modal = document.getElementById('quickview-modal');
        const content = modal.querySelector('.modal-content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('pointer-events-none', 'opacity-0');
        }, 300);
    };
});
</script>
@endsection