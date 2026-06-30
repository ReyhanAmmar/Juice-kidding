@extends('layouts.app-customer')

@section('title', 'Pengantaran — Juice Kidding')

@section('main-class', 'pb-4')

@section('content')
<section class="px-4 pt-4 pb-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-xl font-black text-gray-900">Pengantaran 🚀</h1>
            <p class="text-xs font-medium text-gray-400">Daftar pesanan untuk diantar</p>
        </div>
        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-purple bg-purple-100 px-2.5 py-1 rounded-full">
            <span class="w-2 h-2 rounded-full bg-accent-purple animate-pulse"></span>
            3 Antaran
        </span>
    </div>

    {{-- Delivery Cards --}}
    <div class="space-y-3" id="delivery-list">

        {{-- Delivery 1 — Menunggu --}}
        <div class="delivery-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-accent-yellow animate-fade-in-up" data-status="menunggu">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-001</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full ml-2">● Menunggu Driver</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">14:15</span>
            </div>

            {{-- Customer Info --}}
            <div class="bg-gray-50 rounded-xl p-3 mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-accent-blue text-white text-sm font-black flex items-center justify-center flex-shrink-0">R</div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-900">Reyhan</p>
                        <p class="text-xs font-medium text-gray-400 truncate flex items-center gap-1">
                            <i data-lucide="phone" class="w-3 h-3"></i> 0812-3456-7890
                        </p>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <div class="flex items-start gap-2 mb-3 text-sm">
                <i data-lucide="map-pin" class="w-4 h-4 text-accent-red flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-bold text-gray-900">Jl. Merdeka No. 10</p>
                    <p class="text-xs font-medium text-gray-400">Jakarta Selatan · 2.5 km</p>
                </div>
            </div>

            {{-- Items Summary --}}
            <div class="flex items-center justify-between mb-3 text-sm">
                <span class="font-medium text-gray-500">3 item · Rp 53.000</span>
                <span class="font-bold text-accent-blue flex items-center gap-1">
                    <i data-lucide="wallet" class="w-3 h-3"></i> COD
                </span>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2">
                <button onclick="openMaps('Jl. Merdeka No. 10, Jakarta Selatan')" class="flex-1 border-2 border-accent-blue text-accent-blue font-bold text-xs py-2.5 rounded-xl hover:bg-blue-50 transition-all active:scale-95 flex items-center justify-center gap-1">
                    <i data-lucide="navigation" class="w-3 h-3"></i> Navigasi
                </button>
                <button onclick="ambilPesanan(this)" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold text-xs py-2.5 rounded-xl shadow-btn transition-all active:scale-95 flex items-center justify-center gap-1">
                    <i data-lucide="package" class="w-3 h-3"></i> Ambil Pesanan
                </button>
            </div>
        </div>

        {{-- Delivery 2 — Sedang Diantar --}}
        <div class="delivery-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-primary animate-fade-in-up" data-status="diantar" style="animation-delay: 80ms">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-003</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-primary bg-primary-light px-2 py-0.5 rounded-full ml-2">● Sedang Diantar</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">13:50</span>
            </div>

            <div class="bg-gray-50 rounded-xl p-3 mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-secondary text-white text-sm font-black flex items-center justify-center flex-shrink-0">A</div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-900">Ahmad</p>
                        <p class="text-xs font-medium text-gray-400 truncate flex items-center gap-1">
                            <i data-lucide="phone" class="w-3 h-3"></i> 0856-7890-1234
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-2 mb-3 text-sm">
                <i data-lucide="map-pin" class="w-4 h-4 text-accent-red flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="font-bold text-gray-900">Jl. Sudirman Kav. 25</p>
                    <p class="text-xs font-medium text-gray-400">Jakarta Pusat · 4.2 km</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-3 text-sm">
                <span class="font-medium text-gray-500">4 item · Rp 72.000</span>
                <span class="font-bold text-accent-blue flex items-center gap-1">
                    <i data-lucide="wallet" class="w-3 h-3"></i> Transfer
                </span>
            </div>

            <div class="flex gap-2">
                <button onclick="openMaps('Jl. Sudirman Kav. 25, Jakarta Pusat')" class="flex-1 border-2 border-accent-blue text-accent-blue font-bold text-xs py-2.5 rounded-xl hover:bg-blue-50 transition-all active:scale-95 flex items-center justify-center gap-1">
                    <i data-lucide="navigation" class="w-3 h-3"></i> Navigasi
                </button>
                <button onclick="selesaiAntar(this)" class="flex-1 bg-secondary hover:bg-secondary-dark text-white font-bold text-xs py-2.5 rounded-xl shadow-btn-green transition-all active:scale-95 flex items-center justify-center gap-1">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai Antar
                </button>
            </div>
        </div>

        {{-- Delivery 3 — Selesai --}}
        <div class="delivery-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-secondary opacity-60 animate-fade-in-up" data-status="selesai" style="animation-delay: 160ms">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-005</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-secondary-dark bg-secondary-light px-2 py-0.5 rounded-full ml-2">● Terkirim</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">12:30</span>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary text-white text-sm font-black flex items-center justify-center flex-shrink-0">B</div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-900">Budi</p>
                        <p class="text-xs font-medium text-gray-400 truncate">Jl. Gatot Subroto No. 15</p>
                    </div>
                    <span class="text-sm font-extrabold text-primary">Rp 45.000</span>
                </div>
            </div>
            <div class="text-center">
                <span class="text-xs font-bold text-secondary flex items-center justify-center gap-1">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Berhasil diantar pukul 12:50
                </span>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
function openMaps(address) {
    window.open(`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`, '_blank');
}

function ambilPesanan(btn) {
    const card = btn.closest('.delivery-card');
    card.dataset.status = 'diantar';
    card.querySelector('.border-l-4')?.classList.replace('border-accent-yellow', 'border-primary');

    const badge = card.querySelector('[class*="bg-yellow-100"]');
    if (badge) {
        badge.className = 'inline-flex items-center gap-1 text-[11px] font-bold text-primary bg-primary-light px-2 py-0.5 rounded-full ml-2';
        badge.textContent = '● Sedang Diantar';
    }

    btn.className = 'flex-1 bg-secondary hover:bg-secondary-dark text-white font-bold text-xs py-2.5 rounded-xl shadow-btn-green transition-all active:scale-95 flex items-center justify-center gap-1';
    btn.innerHTML = '<i data-lucide="check-circle" class="w-3 h-3"></i> Selesai Antar';
    btn.setAttribute('onclick', 'selesaiAntar(this)');

    showToast('Pesanan diambil! Segera antarkan.', '📦');
    lucide.createIcons();
}

function selesaiAntar(btn) {
    const card = btn.closest('.delivery-card');
    card.dataset.status = 'selesai';
    card.classList.add('opacity-60');
    card.querySelector('.border-l-4')?.classList.replace('border-primary', 'border-secondary');

    const badge = card.querySelector('[class*="bg-primary-light"]');
    if (badge) {
        badge.className = 'inline-flex items-center gap-1 text-[11px] font-bold text-secondary-dark bg-secondary-light px-2 py-0.5 rounded-full ml-2';
        badge.textContent = '● Terkirim';
    }

    const actionDiv = btn.parentElement;
    actionDiv.innerHTML = '<div class="text-center w-full"><span class="text-xs font-bold text-secondary flex items-center justify-center gap-1"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Berhasil diantar</span></div>';

    showToast('Pesanan berhasil diantar! 🎉', '✅');
    lucide.createIcons();
}

document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
