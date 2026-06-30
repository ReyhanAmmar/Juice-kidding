@extends('layouts.app-customer')

@section('title', 'Lacak Pesanan — Juice Kidding')

@section('content')
<section class="px-4 pt-4 pb-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('beranda') }}" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4 text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-xl font-black text-gray-900">Lacak Pesanan</h1>
            <p class="text-xs font-medium text-gray-400">Kode: <span class="text-primary font-bold">JK-20260623-001</span></p>
        </div>
    </div>

    {{-- Order Status Card --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up">
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-primary bg-primary-light px-2.5 py-1 rounded-full">
                ● Sedang Disiapkan
            </span>
            <span class="text-xs font-medium text-gray-400">23 Jun 2026</span>
        </div>
        <div class="bg-gray-50 rounded-xl p-3">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-light to-orange-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🥤</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900">3 item</p>
                    <p class="text-xs font-medium text-gray-400 line-clamp-1">Jus Alpukat Susu, Jus Kiwi Mint, Smoothie Berry</p>
                </div>
                <span class="text-primary font-extrabold text-sm">Rp 53.000</span>
            </div>
        </div>
    </div>

    {{-- Progress Tracker (Section 7.11) --}}
    <div class="bg-white rounded-2xl shadow-card p-5 mb-4 animate-fade-in-up" style="animation-delay: 80ms">
        <h3 class="text-sm font-black text-gray-900 mb-4 flex items-center gap-2">
            <i data-lucide="route" class="w-4 h-4 text-primary"></i>
            Status Pesanan
        </h3>

        <div class="space-y-0 px-2">
            {{-- Step 1: Selesai (hijau) --}}
            <div class="flex gap-4 items-start">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-secondary flex items-center justify-center shadow-btn-green">
                        <i data-lucide="check" class="w-4 h-4 text-white"></i>
                    </div>
                    <div class="w-0.5 h-10 bg-secondary mt-1"></div>
                </div>
                <div class="pt-1.5 pb-6">
                    <p class="text-sm font-bold text-gray-900">Pesanan Dikonfirmasi</p>
                    <p class="text-xs font-medium text-gray-400 mt-0.5">13:45 · Pesanan diterima sistem</p>
                </div>
            </div>

            {{-- Step 2: Selesai (hijau) --}}
            <div class="flex gap-4 items-start">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-secondary flex items-center justify-center shadow-btn-green">
                        <i data-lucide="check" class="w-4 h-4 text-white"></i>
                    </div>
                    <div class="w-0.5 h-10 bg-secondary mt-1"></div>
                </div>
                <div class="pt-1.5 pb-6">
                    <p class="text-sm font-bold text-gray-900">Pembayaran Diterima</p>
                    <p class="text-xs font-medium text-gray-400 mt-0.5">13:46 · Bayar di tempat (COD)</p>
                </div>
            </div>

            {{-- Step 3: Aktif (oranye, animasi) --}}
            <div class="flex gap-4 items-start">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center shadow-btn ring-4 ring-primary/20 animate-pulse">
                        <i data-lucide="chef-hat" class="w-4 h-4 text-white"></i>
                    </div>
                    <div class="w-0.5 h-10 bg-gray-200 mt-1"></div>
                </div>
                <div class="pt-1.5 pb-6">
                    <p class="text-sm font-black text-primary">Sedang Disiapkan</p>
                    <p class="text-xs font-medium text-gray-400 mt-0.5">Estimasi siap pukul 14:10</p>
                </div>
            </div>

            {{-- Step 4: Belum (abu) --}}
            <div class="flex gap-4 items-start">
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <i data-lucide="truck" class="w-4 h-4 text-gray-300"></i>
                    </div>
                    <div class="w-0.5 h-10 bg-gray-200 mt-1"></div>
                </div>
                <div class="pt-1.5 pb-6">
                    <p class="text-sm font-semibold text-gray-300">Sedang Diantar</p>
                </div>
            </div>

            {{-- Step 5: Belum Terakhir --}}
            <div class="flex gap-4 items-start">
                <div class="flex-shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <i data-lucide="smile" class="w-4 h-4 text-gray-300"></i>
                    </div>
                </div>
                <div class="pt-1.5">
                    <p class="text-sm font-semibold text-gray-300">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Detail --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up" style="animation-delay: 160ms">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="file-text" class="w-4 h-4 text-accent-blue"></i>
            Detail Pesanan
        </h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Tipe Pesanan</span>
                <span class="font-bold text-gray-900 flex items-center gap-1">
                    <i data-lucide="bike" class="w-3.5 h-3.5 text-primary"></i> Delivery
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Alamat</span>
                <span class="font-bold text-gray-900 text-right max-w-[60%]">Jl. Merdeka No. 10, Jakarta</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Pembayaran</span>
                <span class="font-bold text-gray-900">COD (Bayar di Tempat)</span>
            </div>
            <div class="border-t border-gray-100 pt-3 flex justify-between">
                <span class="font-bold text-gray-900">Total</span>
                <span class="font-extrabold text-primary text-lg">Rp 58.000</span>
            </div>
        </div>
    </div>

    {{-- Help Button --}}
    <div class="text-center animate-fade-in-up" style="animation-delay: 240ms">
        <button class="inline-flex items-center gap-2 text-sm font-bold text-accent-blue hover:underline">
            <i data-lucide="headphones" class="w-4 h-4"></i>
            Butuh Bantuan?
        </button>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
