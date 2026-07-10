@extends('layouts.main')

@section('head')
<style>
    html { scroll-behavior: smooth; }
</style>
@endsection

@section('content')
{{-- ===== SIMPLE HERO SECTION ===== --}}
<section class="relative pt-28 pb-12 lg:pt-36 lg:pb-16 overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 border-b border-orange-100">
    <div class="max-w-[1280px] mx-auto px-6 sm:px-8 relative z-10 text-center">
        
        @auth
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 border border-orange-200 text-orange-600 font-bold text-sm font-['Nunito'] mb-6 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
            Selamat datang kembali, {{ explode(' ', Auth::user()->nama_lengkap)[0] }}! 👋
        </div>
        @endauth
        
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-zinc-900 mb-5 tracking-tight" style="font-family: 'Nunito', sans-serif;">
            Katalog <span class="bg-gradient-to-r from-orange-500 to-amber-500 bg-clip-text text-transparent">Jus Segar</span>
        </h1>
        
        <p class="text-base md:text-lg text-zinc-500 font-medium max-w-2xl mx-auto font-['Nunito'] leading-relaxed">
            Pilih dari puluhan varian cold-pressed juice 100% organik kami. Dibuat fresh setiap hari tanpa gula tambahan untuk penuhi kebutuhan nutrisimu.
        </p>
        
    </div>
</section>

<div class="max-w-[1280px] mx-auto">
    {{-- Search & Controls --}}
    <section class="px-6 sm:px-8 mt-10 mb-6">
        <div class="flex flex-col gap-5">
            {{-- Search Bar --}}
            <div class="relative max-w-xl mx-auto w-full">
                <div class="flex items-center bg-white border-2 border-zinc-200 rounded-2xl px-5 py-3.5 gap-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)] focus-within:border-orange-500 focus-within:ring-4 focus-within:ring-orange-500/20 transition-all duration-300 group">
                    <i data-lucide="search" class="w-5 h-5 text-zinc-400 flex-shrink-0 group-focus-within:text-orange-500 transition-colors"></i>
                    <input type="text" id="search-input" placeholder="Cari jus favoritmu..." class="w-full bg-transparent text-base font-medium text-zinc-900 placeholder-zinc-400 outline-none font-['Nunito']">
                    <button id="search-clear" class="hidden w-7 h-7 rounded-full bg-zinc-100 text-zinc-500 flex items-center justify-center hover:bg-red-100 hover:text-red-500 transition-all flex-shrink-0 cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            {{-- Category Chips + Sort --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                {{-- Chips --}}
                <div class="flex gap-2.5 overflow-x-auto hide-scrollbar pb-2 flex-1" id="category-chips">
                    <button data-category="all"
                            class="category-chip px-5 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl text-white text-sm font-bold font-['Nunito'] shadow-[0px_4px_16px_rgba(249,115,22,0.3)] transition-all active:scale-95 whitespace-nowrap">
                        Semua
                    </button>
                    @foreach($kategoriMenus as $kategori)
                    <button data-category="{{ $kategori->id_kategori }}"
                            class="category-chip px-5 py-2.5 bg-white rounded-xl border-2 border-zinc-200 text-zinc-600 text-sm font-bold font-['Nunito'] hover:border-orange-500 hover:text-orange-600 transition-all active:scale-95 whitespace-nowrap">
                        {{ $kategori->nama_kategori }}
                    </button>
                    @endforeach
                </div>

                {{-- Sort Dropdown --}}
                <div class="relative flex-shrink-0">
                    <select id="sort-select" class="appearance-none bg-white border-2 border-zinc-200 rounded-xl px-4 py-2.5 pr-10 text-sm font-bold text-zinc-600 font-['Nunito'] cursor-pointer hover:border-orange-500 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 outline-none transition-all">
                        <option value="default">Urutkan</option>
                        <option value="price-asc">Harga: Rendah → Tinggi</option>
                        <option value="price-desc">Harga: Tinggi → Rendah</option>
                        <option value="name-asc">Nama: A → Z</option>
                        <option value="name-desc">Nama: Z → A</option>
                        <option value="cal-asc">Kalori: Rendah → Tinggi</option>
                    </select>
                    <i data-lucide="chevrons-up-down" class="w-4 h-4 text-zinc-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- Product Grid --}}
    <section id="katalog" class="px-6 sm:px-8 pb-24">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black text-zinc-900" style="font-family: 'Nunito', sans-serif;">Menu Pilihan</h2>
            <span id="product-count" class="text-sm font-bold text-zinc-500 bg-zinc-100 px-3 py-1 rounded-full font-['Nunito']">{{ count($menus) }} menu</span>
        </div>

        {{-- Grid --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($menus as $index => $menu)
            <div class="product-card stagger-item bg-white rounded-3xl overflow-hidden card-glow border border-zinc-100 group relative"
                 data-category="{{ $menu->id_kategori }}"
                 data-name="{{ strtolower($menu->nama_jus) }}"
                 data-price="{{ $menu->harga }}"
                 data-cal="{{ $menu->estimasi_kalori ?? 0 }}"
                 style="animation-delay: {{ $index * 50 }}ms">

                {{-- Thumbnail --}}
                <a href="{{ route('menu.detail', $menu->id_menu) }}" class="block relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-50 cursor-pointer">
                    @if($menu->foto)
                        <img src="{{ asset('uploads/' . $menu->foto) }}"
                             class="w-full h-48 lg:h-52 object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                             alt="{{ $menu->nama_jus }}" loading="lazy">
                    @else
                        <div class="w-full h-48 lg:h-52 bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 flex items-center justify-center group-hover:scale-110 transition-transform duration-700 ease-out">
                            <span class="text-6xl opacity-40 group-hover:opacity-60 transition-opacity">🥤</span>
                        </div>
                    @endif

                    {{-- Gradient Overlay Bottom --}}
                    <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    {{-- Badge habis --}}
                    @if($menu->id_status_stok == 2)
                    <div class="absolute inset-0 bg-zinc-900/50 backdrop-blur-[3px] flex items-center justify-center z-10">
                        <span class="text-white text-xs font-black bg-zinc-800/90 px-4 py-2 rounded-full font-['Nunito'] tracking-wider uppercase">
                            Habis
                        </span>
                    </div>
                    @endif

                    {{-- Category badge --}}
                    <div class="absolute top-3 left-3 z-20">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/95 backdrop-blur-md text-amber-700 px-3 py-1.5 rounded-full shadow-sm font-['Nunito']">
                            {{ $menu->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>

                    {{-- Rating badge --}}
                    @if($menu->rating_rata > 0)
                    <div class="absolute top-3 right-3 z-20">
                        <span class="text-xs font-black bg-amber-500 text-white px-2.5 py-1.5 rounded-full shadow-md flex items-center gap-1 font-['Nunito']">
                            <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                            {{ number_format($menu->rating_rata, 1) }}
                        </span>
                    </div>
                    @endif
                </a>

                {{-- Info --}}
                <div class="p-5">
                    <a href="{{ route('menu.detail', $menu->id_menu) }}" class="block group/title">
                        <h3 class="text-lg font-black text-zinc-900 leading-tight line-clamp-1 font-['Nunito'] group-hover/title:text-amber-700 transition-colors">
                            {{ $menu->nama_jus }}
                        </h3>
                    </a>

                    {{-- Meta info --}}
                    <div class="flex items-center gap-3 mt-2">
                        @if($menu->estimasi_kalori)
                        <span class="text-xs font-bold text-zinc-500 font-['Nunito']">
                            {{ $menu->estimasi_kalori }} kkal
                        </span>
                        @endif
                        @if($menu->ulasan_count ?? $menu->ulasan->count() > 0)
                        <span class="text-xs font-bold text-zinc-500 font-['Nunito']">
                            {{ $menu->ulasan->count() }} ulasan
                        </span>
                        @endif
                    </div>

                    {{-- Price + Actions --}}
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-amber-600 font-black text-xl" style="font-family: 'Nunito', sans-serif;">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                        @if($menu->id_status_stok != 2)
                            @auth
                            <button onclick="showCustomizationModal({{ $menu->id_menu }})"
                                    class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-orange-500/25
                                           hover:shadow-orange-500/40 hover:scale-105 active:scale-95 transition-all z-20 relative cursor-pointer">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                            </button>
                            @else
                            <a href="{{ route('login') }}"
                               class="w-11 h-11 rounded-xl bg-zinc-100 text-zinc-500 flex items-center justify-center
                                      hover:bg-amber-100 hover:text-amber-700 transition-all z-20 relative">
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
                <div class="w-20 h-20 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mx-auto mb-5">
                    <i data-lucide="cup-soda" class="w-8 h-8 text-amber-400"></i>
                </div>
                <h3 class="text-2xl font-black text-zinc-900" style="font-family: 'Nunito', sans-serif;">Belum Ada Menu</h3>
                <p class="text-base font-medium text-zinc-500 mt-2 font-['Nunito']">Katalog menu jus sedang disiapkan. Cek lagi nanti ya!</p>
            </div>
            @endforelse
        </div>

        {{-- No results (hidden by default) --}}
        <div id="no-results" class="hidden text-center py-20">
            <div class="w-20 h-20 rounded-2xl bg-zinc-50 border-2 border-zinc-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search-x" class="w-8 h-8 text-zinc-300"></i>
            </div>
            <h3 class="text-xl font-bold text-zinc-900 font-['Nunito']">Tidak Ditemukan</h3>
            <p class="text-sm font-medium text-zinc-500 mt-1 font-['Nunito']">Coba kata kunci lain atau ubah kategori</p>
        </div>
    </section>
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
    const sortSelect = document.getElementById('sort-select');

    let activeCategory = 'all';

    // ===== Category Filter =====
    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            chips.forEach(c => {
                c.classList.remove('text-white', 'bg-gradient-to-r', 'from-amber-600', 'to-orange-600', 'shadow-[0px_4px_16px_rgba(225,125,25,0.35)]');
                c.classList.add('text-zinc-600', 'bg-white', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-zinc-200');
            });
            chip.classList.add('text-white', 'bg-gradient-to-r', 'from-amber-600', 'to-orange-600', 'shadow-[0px_4px_16px_rgba(225,125,25,0.35)]');
            chip.classList.remove('text-zinc-600', 'bg-white', 'outline', 'outline-2', 'outline-offset-[-2px]', 'outline-zinc-200');

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

    // ===== Sort =====
    if(sortSelect) {
        sortSelect.addEventListener('change', () => {
            sortProducts();
        });
    }

    function sortProducts() {
        const grid = document.getElementById('product-grid');
        const cardsArr = Array.from(grid.querySelectorAll('.product-card'));
        const sortVal = sortSelect ? sortSelect.value : 'default';

        cardsArr.sort((a, b) => {
            switch(sortVal) {
                case 'price-asc': return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price-desc': return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                case 'name-asc': return a.dataset.name.localeCompare(b.dataset.name);
                case 'name-desc': return b.dataset.name.localeCompare(a.dataset.name);
                case 'cal-asc': return parseInt(a.dataset.cal) - parseInt(b.dataset.cal);
                default: return 0;
            }
        });

        cardsArr.forEach(card => grid.appendChild(card));
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
});
</script>
@endsection