@extends('layouts.main')

@section('title', 'Langganan Jus Mingguan — Juice Kidding')
@section('head')
<meta name="description" content="Langganan jus mingguan Juice Kidding. Lebih hemat, lebih sehat, gratis ongkir!">
<style>
    @keyframes float-sub {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    @keyframes blob-spin {
        0% { transform: rotate(0deg) scale(1); }
        50% { transform: rotate(180deg) scale(1.1); }
        100% { transform: rotate(360deg) scale(1); }
    }
    @keyframes shimmer-card {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes pop-in {
        0% { opacity: 0; transform: scale(0.85); }
        100% { opacity: 1; transform: scale(1); }
    }
    .animate-float-sub { animation: float-sub 4s ease-in-out infinite; }
    .animate-blob { animation: blob-spin 20s linear infinite; }
    .animate-pop-in { animation: pop-in 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .stagger-card { opacity: 0; transform: translateY(30px); }
    .stagger-card.visible { animation: fadeInUp 0.6s ease-out forwards; }
    .card-shimmer {
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.4) 50%, transparent 100%);
        background-size: 200% 100%;
    }
    .card-shimmer:hover { animation: shimmer-card 1.2s ease-in-out; }
    .price-tag {
        background: linear-gradient(135deg, var(--color-primary) 0%, #c45e0a 100%);
    }
    .feature-check {
        transition: all 0.2s ease;
    }
    .plan-card:hover .feature-check {
        transform: scale(1.1);
    }
    .plan-card {
        transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.4s ease;
    }
    .plan-card:hover {
        transform: translateY(-8px);
    }
    .plan-card .card-glow-line {
        transition: opacity 0.4s ease;
    }
    .plan-card:hover .card-glow-line {
        opacity: 0.6;
    }
    .floating-badge {
        animation: float-sub 3s ease-in-out infinite;
    }
    .dot-pattern {
        background-image: radial-gradient(circle, rgba(225,125,25,0.08) 1px, transparent 1px);
        background-size: 20px 20px;
    }
</style>
@endsection

@section('content')
<main class="w-full pt-[81px]">
    {{-- ===== SUBSCRIPTION PLANS ===== --}}
    <section class="w-full py-16 md:py-24 bg-white relative">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            {{-- Section header --}}
            <div class="text-center mb-14 md:mb-20">
                <span class="inline-block px-4 py-1.5 bg-amber-50 text-amber-700 text-xs font-bold font-['Nunito'] rounded-full mb-4 tracking-wider uppercase">Pilih Paketmu</span>
                <h2 class="text-3xl md:text-5xl font-black text-zinc-900 font-['Nunito']">Sesuai Kebutuhanmu</h2>
                <p class="text-zinc-500 text-sm md:text-base font-medium font-['Nunito'] mt-4 max-w-xl mx-auto">Semua paket sudah termasuk gratis ongkir dan bisa kamu atur jadwal pengiriman fleksibel.</p>
            </div>

            {{-- Alert --}}
            @if(session('error'))
            <div class="mb-8 max-w-4xl mx-auto px-4 py-3.5 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 animate-pop-in" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
                <span class="font-bold text-sm">{{ session('error') }}</span>
            </div>
            @endif
            @if(session('success'))
            <div class="mb-8 max-w-4xl mx-auto px-4 py-3.5 bg-lime-50 border border-lime-200 text-lime-700 rounded-2xl flex items-center gap-3 animate-pop-in" role="alert">
                <i data-lucide="check-circle" class="w-5 h-5 text-lime-600 flex-shrink-0"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
            @endif

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
                @forelse($pakets as $p)
                @php
                    // Dynamic palette based on loop
                    $palettes = [
                        ['accent' => 'amber', 'accentHex' => '#E17D19', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'light' => 'bg-amber-100', 'gradient' => 'from-amber-500 to-orange-500', 'shadow' => 'shadow-amber-200/30', 'dot' => 'bg-amber-500'],
                        ['accent' => 'lime',  'accentHex' => '#96C84B', 'bg' => 'bg-lime-50',  'text' => 'text-lime-700', 'border' => 'border-lime-200', 'light' => 'bg-lime-100', 'gradient' => 'from-lime-500 to-green-500', 'shadow' => 'shadow-lime-200/30', 'dot' => 'bg-lime-500'],
                        ['accent' => 'pink',  'accentHex' => '#E14B7D', 'bg' => 'bg-pink-50',  'text' => 'text-pink-700', 'border' => 'border-pink-200', 'light' => 'bg-pink-100', 'gradient' => 'from-pink-500 to-rose-500', 'shadow' => 'shadow-pink-200/30', 'dot' => 'bg-pink-500'],
                    ];
                    $pal = $palettes[$loop->index % 3];
                    $hargaPerBotol = $p->total_pengiriman > 0 ? intval($p->harga / $p->total_pengiriman) : 0;
                    $isPopular = $loop->index == 1;
                @endphp

                <div class="plan-card stagger-card relative bg-white rounded-3xl border border-zinc-200/80 flex flex-col overflow-hidden shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] {{ $isPopular ? 'md:-translate-y-2' : '' }}"
                     style="animation-delay: {{ $loop->index * 0.15 }}s;">

                    {{-- Top accent bar --}}
                    <div class="h-1.5 w-full bg-gradient-to-r {{ $pal['gradient'] }} card-glow-line"></div>

                    {{-- Popular badge --}}
                    @if($isPopular)
                    <div class="absolute top-4 right-4 z-10">
                        <div class="px-3 py-1 {{ $pal['bg'] }} rounded-full border border-{{ $pal['accent'] }}-200 shadow-sm floating-badge" style="animation-delay: 0.3s;">
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full {{ $pal['dot'] }} animate-pulse"></span>
                                <span class="{{ $pal['text'] }} text-[9px] font-black tracking-wider uppercase">Terpopuler</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Card body --}}
                    <div class="p-6 md:p-8 flex flex-col flex-1">
                        {{-- Package name --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">
                                @if($loop->index == 0) 🥤
                                @elseif($loop->index == 1) 🌟
                                @else 👑
                                @endif
                            </span>
                            <h3 class="text-xl font-black text-zinc-900 font-['Nunito']">{{ $p->nama_paket }}</h3>
                        </div>

                        {{-- Price --}}
                        <div class="mb-5">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-4xl font-black font-['Nunito'] tracking-tight" style="color: {{ $pal['accentHex'] }};">Rp {{ number_format($p->harga / 1000, 0) }}k</span>
                                <span class="text-zinc-400 text-xs font-bold">/minggu</span>
                            </div>
                            @if($hargaPerBotol > 0)
                            <div class="mt-1">
                                <span class="text-zinc-400 text-[10px] font-semibold">≈ Rp {{ number_format($hargaPerBotol, 0, ',', '.') }}/botol</span>
                            </div>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if($p->deskripsi)
                        <p class="text-zinc-500 text-xs font-medium leading-relaxed mb-6">{{ $p->deskripsi }}</p>
                        @endif

                        <hr class="border-zinc-100 mb-6">

                        {{-- Benefits --}}
                        <ul class="space-y-3.5 mb-8 flex-1">
                            <li class="flex items-center gap-3">
                                <span class="feature-check w-6 h-6 rounded-full {{ $pal['light'] }} flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="check" class="w-3.5 h-3.5" style="color: {{ $pal['accentHex'] }};"></i>
                                </span>
                                <span class="text-zinc-700 text-xs font-bold">{{ $p->total_pengiriman }} Botol Jus / Minggu</span>
                            </li>

                            @if($p->gratis_ongkir)
                            <li class="flex items-center gap-3">
                                <span class="feature-check w-6 h-6 rounded-full {{ $pal['light'] }} flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="check" class="w-3.5 h-3.5" style="color: {{ $pal['accentHex'] }};"></i>
                                </span>
                                <span class="text-zinc-700 text-xs font-bold">Gratis Ongkos Kirim</span>
                            </li>
                            @endif

                            <li class="flex items-center gap-3">
                                <span class="feature-check w-6 h-6 rounded-full {{ $pal['light'] }} flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="check" class="w-3.5 h-3.5" style="color: {{ $pal['accentHex'] }};"></i>
                                </span>
                                <span class="text-zinc-700 text-xs font-bold">Jadwal Fleksibel</span>
                            </li>

                            {{-- Juice variants --}}
                            <li class="mt-4 pt-4 border-t border-zinc-100">
                                <div class="flex items-center gap-2 mb-2.5">
                                    <i data-lucide="juice" class="w-3.5 h-3.5 text-zinc-400"></i>
                                    <span class="text-zinc-500 text-[10px] font-bold uppercase tracking-wider">Varian Jus Tersedia</span>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($p->menus as $menu)
                                        <span class="px-2.5 py-1 {{ $pal['bg'] }} rounded-lg text-[10px] font-bold" style="color: {{ $pal['accentHex'] }};">
                                            {{ $menu->nama_jus }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-zinc-400 italic">Semua varian menu jus</span>
                                    @endforelse
                                </div>
                            </li>
                        </ul>

                        {{-- CTA Button --}}
                        <a href="{{ route('customer.langganan.checkout', $p->id_paket) }}"
                           class="group relative w-full py-3.5 rounded-full text-white text-xs font-black font-['Nunito'] tracking-wider uppercase transition-all active:scale-[0.97] flex items-center justify-center gap-2 overflow-hidden"
                           style="background: linear-gradient(135deg, {{ $pal['accentHex'] }}, {{ $loop->index == 0 ? '#c45e0a' : ($loop->index == 1 ? '#6e9a2a' : '#c43b6a') }}); box-shadow: 0 4px 20px -4px {{ $pal['accentHex'] }}55;">
                            <span class="relative z-10 flex items-center gap-2">
                                Mulai Langganan
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"></i>
                            </span>
                            <div class="absolute inset-0 bg-white/15 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-3 bg-white rounded-3xl p-16 text-center border border-zinc-200 shadow-sm">
                    <div class="w-20 h-20 bg-zinc-100 rounded-full flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="calendar-off" class="w-8 h-8 text-zinc-400"></i>
                    </div>
                    <h3 class="text-lg font-black text-zinc-700 font-['Nunito']">Paket Langganan Belum Tersedia</h3>
                    <p class="text-sm text-zinc-400 font-medium mt-2 max-w-sm mx-auto">Saat ini admin sedang menyusun paket langganan terbaik untuk Anda. Nantikan update selanjutnya!</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Stagger card animation on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.stagger-card').forEach(el => observer.observe(el));
    document.querySelectorAll('.stagger-item').forEach(el => observer.observe(el));

    // Re-init lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection