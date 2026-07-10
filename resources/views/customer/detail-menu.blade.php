@extends('layouts.main')

@section('content')
{{-- Breadcrumb --}}
<section class="px-6 sm:px-8 pt-[100px] pb-0 max-w-[1280px] mx-auto">
    <nav class="flex items-center gap-2 text-sm font-semibold font-['Nunito'] animate-fade-in-up">
        <a href="{{ route('menu') }}" class="text-zinc-500 hover:text-amber-600 transition-colors">
            Menu
        </a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-zinc-300"></i>
        <a href="{{ route('menu') }}?kategori={{ $menu->id_kategori }}" class="text-zinc-500 hover:text-amber-600 transition-colors">
            {{ $menu->kategori->nama_kategori ?? 'Umum' }}
        </a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-zinc-300"></i>
        <span class="text-zinc-800">{{ $menu->nama_jus }}</span>
    </nav>
</section>

{{-- Main Product Section --}}
<section class="px-6 sm:px-8 py-8 max-w-[1280px] mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

        {{-- ===== LEFT: Product Image ===== --}}
        <div class="animate-fade-in-up">
            <div class="relative rounded-[2rem] overflow-hidden bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 aspect-square shadow-[0_8px_40px_rgba(0,0,0,0.08)]">
                @if($menu->foto)
                    <img src="{{ asset('uploads/' . $menu->foto) }}"
                         class="w-full h-full object-cover"
                         alt="{{ $menu->nama_jus }}">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-[120px] opacity-30 animate-float">🥤</span>
                    </div>
                @endif

                {{-- Status Badge --}}
                @if($menu->id_status_stok == 2)
                <div class="absolute inset-0 bg-zinc-900/50 backdrop-blur-[3px] flex items-center justify-center z-10">
                    <span class="text-white text-base font-black bg-zinc-800/90 px-6 py-3 rounded-full font-['Nunito'] tracking-wider uppercase">
                        Stok Habis
                    </span>
                </div>
                @endif

                {{-- Category Badge --}}
                <div class="absolute top-5 left-5 z-20">
                    <span class="text-xs font-black uppercase tracking-widest bg-white/95 backdrop-blur-md text-amber-700 px-4 py-2 rounded-full shadow-md font-['Nunito']">
                        {{ $menu->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                </div>

                {{-- Rating Badge --}}
                @if($menu->rating_rata > 0)
                <div class="absolute top-5 right-5 z-20">
                    <span class="text-sm font-black bg-amber-500 text-white px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5 font-['Nunito']">
                        ★ {{ number_format($menu->rating_rata, 1) }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        {{-- ===== RIGHT: Product Info ===== --}}
        <div class="flex flex-col animate-fade-in-up" style="animation-delay: 150ms;">

            {{-- Title --}}
            <h1 class="text-3xl lg:text-4xl font-black text-zinc-900 leading-tight" style="font-family: 'Nunito', sans-serif;">
                {{ $menu->nama_jus }}
            </h1>

            {{-- Meta Row --}}
            <div class="flex flex-wrap items-center gap-3 mt-3">
                {{-- Rating Stars --}}
                @if($menu->rating_rata > 0)
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($menu->rating_rata))
                            <i data-lucide="star" class="w-4 h-4 star-filled fill-current"></i>
                        @else
                            <i data-lucide="star" class="w-4 h-4 star-empty"></i>
                        @endif
                    @endfor
                    <span class="text-sm font-bold text-zinc-500 ml-1 font-['Nunito']">
                        {{ number_format($menu->rating_rata, 1) }}
                    </span>
                </div>
                <div class="w-px h-4 bg-zinc-200"></div>
                @endif

                {{-- Review Count --}}
                <span class="text-sm font-bold text-zinc-500 font-['Nunito']">
                    {{ $menu->ulasan->count() }} ulasan
                </span>

                @if($menu->estimasi_kalori)
                <div class="w-px h-4 bg-zinc-200"></div>
                <span class="text-sm font-bold text-zinc-500 font-['Nunito']">
                    {{ $menu->estimasi_kalori }} kkal
                </span>
                @endif
            </div>

            {{-- Price --}}
            <div class="mt-6 flex items-baseline gap-2">
                <span id="display-price" class="text-4xl font-black text-amber-600" style="font-family: 'Nunito', sans-serif;">
                    Rp{{ number_format($menu->harga, 0, ',', '.') }}
                </span>
                <span class="text-sm font-bold text-zinc-500 font-['Nunito']">/ gelas</span>
            </div>

            {{-- Description --}}
            @if($menu->deskripsi)
            <div class="mt-6 p-5 bg-gradient-to-br from-amber-50/80 to-orange-50/50 rounded-2xl border border-amber-100/50">
                <p class="text-sm font-medium text-zinc-700 leading-relaxed font-['Nunito']">
                    {{ $menu->deskripsi }}
                </p>
            </div>
            @endif

            {{-- Info Tags --}}
            <div class="flex flex-wrap gap-3 mt-6">
                <div class="px-4 py-2.5 bg-green-50 border border-green-100 rounded-xl">
                    <span class="text-xs font-bold text-green-700 font-['Nunito']">100% Organik</span>
                </div>
                <div class="px-4 py-2.5 bg-blue-50 border border-blue-100 rounded-xl">
                    <span class="text-xs font-bold text-blue-700 font-['Nunito']">Tanpa Pengawet</span>
                </div>
                @if($menu->estimasi_kalori)
                <div class="px-4 py-2.5 bg-orange-50 border border-orange-100 rounded-xl">
                    <span class="text-xs font-bold text-orange-700 font-['Nunito']">{{ $menu->estimasi_kalori }} kkal</span>
                </div>
                @endif
            </div>

            {{-- ===== Customization Options ===== --}}
            @if($tipeOpsi->count() > 0)
            <div class="mt-8 space-y-6" id="customization-panel">
                @foreach($tipeOpsi as $tipe)
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <h3 class="text-sm font-black text-zinc-900 uppercase tracking-wide font-['Nunito']">
                            {{ $tipe->nama_tipe }}
                        </h3>
                        @if($tipe->wajib_pilih)
                        <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">Wajib</span>
                        @else
                        <span class="text-[10px] font-bold text-zinc-500 bg-zinc-100 px-2 py-0.5 rounded-full">Opsional</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2.5">
                        @foreach($tipe->opsi as $opsi)
                        @if($tipe->pilih_banyak)
                        {{-- Checkbox style for multi-select (Topping) --}}
                        <label class="opsi-card cursor-pointer group">
                            <input type="checkbox" name="opsi_{{ $tipe->id_tipe_opsi }}[]" value="{{ $opsi->id_opsi }}"
                                   data-harga="{{ $opsi->harga_tambahan }}" class="hidden opsi-input">
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-zinc-200 bg-white
                                        group-hover:border-amber-300 group-hover:bg-amber-50/30
                                        transition-all duration-200
                                        [input:checked~&]:border-amber-500 [input:checked~&]:bg-amber-50 [input:checked~&]:shadow-[0_0_0_1px_rgba(245,158,11,0.3)]">
                                <div class="w-5 h-5 rounded-md border-2 border-zinc-300 flex items-center justify-center flex-shrink-0 transition-all
                                            group-has-[input:checked]:border-amber-500 group-has-[input:checked]:bg-amber-500">
                                    <i data-lucide="check" class="w-3 h-3 text-white opacity-0 group-has-[input:checked]:opacity-100 transition-opacity"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-zinc-700 font-['Nunito']">{{ $opsi->nama_opsi }}</span>
                                    @if($opsi->harga_tambahan > 0)
                                    <span class="text-xs font-bold text-amber-600 ml-1">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </label>
                        @else
                        {{-- Radio style for single-select (Ukuran, Gula) --}}
                        <label class="opsi-card cursor-pointer group">
                            <input type="radio" name="opsi_{{ $tipe->id_tipe_opsi }}" value="{{ $opsi->id_opsi }}"
                                   data-harga="{{ $opsi->harga_tambahan }}" class="hidden opsi-input"
                                   {{ $loop->first && $tipe->wajib_pilih ? 'checked' : '' }}>
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border-2 border-zinc-200 bg-white
                                        group-hover:border-amber-300 group-hover:bg-amber-50/30
                                        transition-all duration-200
                                        group-has-[input:checked]:border-amber-500 group-has-[input:checked]:bg-amber-50 group-has-[input:checked]:shadow-[0_0_0_1px_rgba(245,158,11,0.3)]">
                                <div class="w-4 h-4 rounded-full border-2 border-zinc-300 flex items-center justify-center flex-shrink-0 transition-all
                                            group-has-[input:checked]:border-amber-500">
                                    <div class="w-2 h-2 rounded-full bg-amber-500 scale-0 group-has-[input:checked]:scale-100 transition-transform"></div>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-zinc-700 font-['Nunito']">{{ $opsi->nama_opsi }}</span>
                                    @if($opsi->harga_tambahan > 0)
                                    <span class="text-xs font-bold text-amber-600 ml-1">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </label>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- ===== Quantity + Add to Cart ===== --}}
            @if($menu->id_status_stok != 2)
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                {{-- Quantity Selector --}}
                <div class="flex items-center bg-zinc-100 rounded-xl overflow-hidden flex-shrink-0">
                    <button onclick="updateQty(-1)" class="w-12 h-12 flex items-center justify-center text-zinc-600 hover:bg-zinc-200 active:bg-zinc-300 transition-colors cursor-pointer">
                        <i data-lucide="minus" class="w-4 h-4"></i>
                    </button>
                    <span id="qty-display" class="w-12 h-12 flex items-center justify-center text-base font-black text-zinc-900 font-['Nunito']">1</span>
                    <button onclick="updateQty(1)" class="w-12 h-12 flex items-center justify-center text-zinc-600 hover:bg-zinc-200 active:bg-zinc-300 transition-colors cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </button>
                </div>

                {{-- Add to Cart Button --}}
                @auth
                <button onclick="addToCartDetail()" id="add-to-cart-btn"
                        class="flex-1 py-3.5 px-6 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700
                               text-white font-black text-base rounded-xl flex items-center justify-center gap-3
                               shadow-[0_8px_24px_rgba(245,158,11,0.3)] hover:shadow-[0_12px_32px_rgba(245,158,11,0.4)]
                               active:scale-[0.98] transition-all duration-200 cursor-pointer"
                        style="font-family: 'Nunito', sans-serif;">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>Tambah ke Keranjang</span>
                    <span class="ml-1 opacity-80">•</span>
                    <span id="cart-total-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                </button>
                @else
                <a href="{{ route('login') }}"
                   class="flex-1 py-3.5 px-6 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700
                          text-white font-black text-base rounded-xl flex items-center justify-center gap-3
                          shadow-[0_8px_24px_rgba(245,158,11,0.3)]
                          active:scale-[0.98] transition-all duration-200"
                   style="font-family: 'Nunito', sans-serif;">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                    Masuk untuk Memesan
                </a>
                @endauth
            </div>
            @else
            <div class="mt-8">
                <button disabled class="w-full py-3.5 px-6 bg-zinc-200 text-zinc-500 font-black text-base rounded-xl flex items-center justify-center gap-3 cursor-not-allowed"
                        style="font-family: 'Nunito', sans-serif;">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                    Stok Habis
                </button>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== Reviews Section ===== --}}
<section class="px-6 sm:px-8 py-12 max-w-[1280px] mx-auto border-t border-zinc-100">
    <div class="animate-fade-in-up">
        <h2 class="text-2xl font-black text-zinc-900 mb-8" style="font-family: 'Nunito', sans-serif;">
            Ulasan Pelanggan
        </h2>

        @if($menu->ulasan->count() > 0)
        {{-- Rating Summary --}}
        <div class="flex flex-col sm:flex-row gap-8 mb-10 p-6 bg-gradient-to-br from-amber-50/80 to-orange-50/50 rounded-2xl border border-amber-100/50">
            {{-- Big Rating --}}
            <div class="flex flex-col items-center justify-center flex-shrink-0">
                <span class="text-5xl font-black text-zinc-900" style="font-family: 'Nunito', sans-serif;">
                    {{ number_format($menu->rating_rata, 1) }}
                </span>
                <div class="flex items-center gap-1 mt-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($menu->rating_rata))
                            <i data-lucide="star" class="w-4 h-4 star-filled fill-current"></i>
                        @else
                            <i data-lucide="star" class="w-4 h-4 star-empty"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-xs font-bold text-zinc-500 mt-1 font-['Nunito']">{{ $menu->ulasan->count() }} ulasan</span>
            </div>

            {{-- Rating Bars --}}
            <div class="flex-1 space-y-2">
                @for($star = 5; $star >= 1; $star--)
                @php
                    $count = $menu->ulasan->where('rating', $star)->count();
                    $total = $menu->ulasan->count();
                    $pct = $total > 0 ? ($count / $total) * 100 : 0;
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-zinc-500 w-6 text-right font-['Nunito']">{{ $star }}</span>
                    <i data-lucide="star" class="w-3 h-3 star-filled fill-current flex-shrink-0"></i>
                    <div class="flex-1 h-2.5 bg-zinc-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-400 to-orange-400 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="text-xs font-bold text-zinc-500 w-8 font-['Nunito']">{{ $count }}</span>
                </div>
                @endfor
            </div>
        </div>

        {{-- Review List --}}
        <div class="space-y-4">
            @foreach($menu->ulasan->sortByDesc('created_at')->take(10) as $ulasan)
            <div class="p-5 bg-white border border-zinc-100 rounded-2xl hover:border-zinc-200 transition-colors">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="text-white text-sm font-black">{{ strtoupper(substr($ulasan->customer->nama_lengkap ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-sm font-bold text-zinc-900 font-['Nunito']">{{ $ulasan->customer->nama_lengkap ?? 'Anonim' }}</span>
                            <span class="text-xs text-zinc-500 font-['Nunito']">{{ $ulasan->created_at->diffForHumans() }}</span>
                        </div>
                        {{-- Stars --}}
                        <div class="flex items-center gap-0.5 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $ulasan->rating)
                                    <i data-lucide="star" class="w-3.5 h-3.5 star-filled fill-current"></i>
                                @else
                                    <i data-lucide="star" class="w-3.5 h-3.5 star-empty"></i>
                                @endif
                            @endfor
                        </div>
                        @if($ulasan->komentar)
                        <p class="text-sm font-medium text-zinc-600 mt-2 leading-relaxed font-['Nunito']">{{ $ulasan->komentar }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- No Reviews --}}
        <div class="text-center py-12 bg-zinc-50/50 rounded-2xl border border-zinc-100">
            <div class="w-16 h-16 rounded-2xl bg-zinc-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="message-square" class="w-7 h-7 text-zinc-300"></i>
            </div>
            <h3 class="text-lg font-bold text-zinc-700 font-['Nunito']">Belum Ada Ulasan</h3>
            <p class="text-sm font-medium text-zinc-500 mt-1 font-['Nunito']">Jadilah yang pertama mengulas jus ini!</p>
        </div>
        @endif
    </div>
</section>

{{-- ===== Related Products ===== --}}
@if($relatedMenus->count() > 0)
<section class="px-6 sm:px-8 py-12 max-w-[1280px] mx-auto border-t border-zinc-100">
    <div class="animate-fade-in-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-black text-zinc-900" style="font-family: 'Nunito', sans-serif;">
                Jus Lainnya
            </h2>
            <a href="{{ route('menu') }}" class="text-sm font-bold text-amber-600 hover:text-amber-700 font-['Nunito'] flex items-center gap-1 transition-colors">
                Lihat Semua
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedMenus as $related)
            <a href="{{ route('menu.detail', $related->id_menu) }}"
               class="block bg-white rounded-3xl overflow-hidden card-glow border border-zinc-100 group">
                {{-- Thumbnail --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-50">
                    @if($related->foto)
                        <img src="{{ asset('uploads/' . $related->foto) }}"
                             class="w-full h-44 object-cover group-hover:scale-110 transition-transform duration-700"
                             alt="{{ $related->nama_jus }}" loading="lazy">
                    @else
                        <div class="w-full h-44 flex items-center justify-center">
                            <span class="text-5xl opacity-30">🥤</span>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/95 backdrop-blur-md text-amber-700 px-3 py-1.5 rounded-full shadow-sm font-['Nunito']">
                            {{ $related->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                </div>
                {{-- Info --}}
                <div class="p-4">
                    <h3 class="text-base font-bold text-zinc-900 line-clamp-1 font-['Nunito'] group-hover:text-amber-700 transition-colors">
                        {{ $related->nama_jus }}
                    </h3>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-amber-600 font-black text-lg" style="font-family: 'Nunito', sans-serif;">
                            Rp{{ number_format($related->harga, 0, ',', '.') }}
                        </span>
                        @if($related->rating_rata > 0)
                        <span class="text-xs font-bold text-zinc-500 flex items-center gap-1 font-['Nunito']">
                            <i data-lucide="star" class="w-3 h-3 star-filled fill-current"></i>
                            {{ number_format($related->rating_rata, 1) }}
                        </span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ===== Mobile Sticky CTA ===== --}}
@if($menu->id_status_stok != 2)
<div class="fixed bottom-0 left-0 right-0 z-50 lg:hidden bg-white/95 backdrop-blur-xl border-t border-zinc-200 px-6 py-4 shadow-[0_-4px_24px_rgba(0,0,0,0.08)]">
    <div class="flex items-center gap-4 max-w-[1280px] mx-auto">
        <div class="flex-shrink-0">
            <span class="text-xl font-black text-amber-600" style="font-family: 'Nunito', sans-serif;" id="mobile-price">
                Rp{{ number_format($menu->harga, 0, ',', '.') }}
            </span>
        </div>
        @auth
        <button onclick="addToCartDetail()"
                class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-sm rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-orange-500/30 active:scale-[0.98] transition-all cursor-pointer font-['Nunito']">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
            Tambah ke Keranjang
        </button>
        @else
        <a href="{{ route('login') }}"
           class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-sm rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-orange-500/30 active:scale-[0.98] transition-all font-['Nunito']">
            <i data-lucide="lock" class="w-4 h-4"></i>
            Masuk untuk Memesan
        </a>
        @endauth
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const basePrice = {{ $menu->harga }};
    let qty = 1;

    // ===== Quantity =====
    window.updateQty = function(delta) {
        qty = Math.max(1, Math.min(99, qty + delta));
        document.getElementById('qty-display').textContent = qty;
        updateTotalPrice();
    };

    // ===== Calculate Extra from Options =====
    function getExtraPrice() {
        let extra = 0;
        document.querySelectorAll('.opsi-input:checked').forEach(input => {
            extra += parseInt(input.dataset.harga || 0);
        });
        return extra;
    }

    // ===== Update Total Price Display =====
    function updateTotalPrice() {
        const total = (basePrice + getExtraPrice()) * qty;
        const formatted = 'Rp' + new Intl.NumberFormat('id-ID').format(total);

        const cartTotal = document.getElementById('cart-total-price');
        const displayPrice = document.getElementById('display-price');
        const mobilePrice = document.getElementById('mobile-price');

        if (cartTotal) cartTotal.textContent = formatted;
        if (mobilePrice) mobilePrice.textContent = formatted;

        // Pulse animation on price change
        if (displayPrice) {
            displayPrice.textContent = formatted;
            displayPrice.classList.add('scale-105');
            setTimeout(() => displayPrice.classList.remove('scale-105'), 200);
        }
    }

    // ===== Listen to Option Changes =====
    document.querySelectorAll('.opsi-input').forEach(input => {
        input.addEventListener('change', updateTotalPrice);
    });

    // Initialize price
    updateTotalPrice();

    // ===== Add to Cart =====
    window.addToCartDetail = function() {
        const menuId = {{ $menu->id_menu }};
        const menuName = '{{ addslashes($menu->nama_jus) }}';

        // Collect selected options
        const selectedOpsi = [];
        document.querySelectorAll('.opsi-input:checked').forEach(input => {
            selectedOpsi.push(input.value);
        });

        @auth
        // AJAX add to cart
        fetch('/customer/keranjang/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                id_menu: menuId,
                jumlah: qty,
                opsi: selectedOpsi
            })
        })
        .then(async res => {
            if (!res.ok) {
                const err = await res.json().catch(() => ({}));
                throw new Error(err.message || 'Gagal menambahkan ke keranjang');
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                showToast('berhasil ditambahkan ke keranjang', '');
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang');
            }
        })
        .catch(err => {
            showToast(err.message);
        });
        @endauth
    };
});
</script>
@endsection
