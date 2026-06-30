@extends('layouts.app-customer')

@section('title', 'Antrian Dapur — Juice Kidding')

@section('main-class', 'pb-4')

@section('content')
<section class="px-4 pt-4 pb-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-xl font-black text-gray-900">Antrian Dapur 👨‍🍳</h1>
            <p class="text-xs font-medium text-gray-400">Pesanan yang perlu disiapkan</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-blue bg-blue-100 px-2.5 py-1 rounded-full">
                <span class="w-2 h-2 rounded-full bg-accent-blue animate-pulse"></span>
                5 Antrian
            </span>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-4 overflow-x-auto hide-scrollbar pb-1">
        <button class="queue-tab text-sm font-bold text-white bg-primary px-4 py-1.5 rounded-full shadow-btn whitespace-nowrap transition-all active:scale-95" data-filter="all">
            Semua
        </button>
        <button class="queue-tab text-sm font-semibold text-gray-500 bg-white border-2 border-gray-200 px-4 py-1.5 rounded-full whitespace-nowrap hover:border-primary hover:text-primary transition-all active:scale-95" data-filter="baru">
            Baru
        </button>
        <button class="queue-tab text-sm font-semibold text-gray-500 bg-white border-2 border-gray-200 px-4 py-1.5 rounded-full whitespace-nowrap hover:border-primary hover:text-primary transition-all active:scale-95" data-filter="diproses">
            Diproses
        </button>
        <button class="queue-tab text-sm font-semibold text-gray-500 bg-white border-2 border-gray-200 px-4 py-1.5 rounded-full whitespace-nowrap hover:border-primary hover:text-primary transition-all active:scale-95" data-filter="selesai">
            Selesai
        </button>
    </div>

    {{-- Queue Cards --}}
    <div class="space-y-3" id="queue-list">

        {{-- Order 1 — Baru --}}
        <div class="queue-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-accent-blue animate-fade-in-up" data-status="baru">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-001</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-blue bg-blue-100 px-2 py-0.5 rounded-full ml-2">● Baru</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">13:45</span>
            </div>
            <div class="space-y-1.5 mb-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">1x Jus Alpukat Susu</span>
                    <span class="font-bold text-gray-900">Rp 18.000</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">2x Kiwi Mint Splash</span>
                    <span class="font-bold text-gray-900">Rp 30.000</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <i data-lucide="user" class="w-3 h-3"></i>
                    <span>Reyhan · Delivery</span>
                </div>
                <button onclick="updateStatus(this, 'diproses')" class="bg-primary hover:bg-primary-dark text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-btn transition-all active:scale-95 flex items-center gap-1">
                    <i data-lucide="chef-hat" class="w-3 h-3"></i> Proses
                </button>
            </div>
        </div>

        {{-- Order 2 — Baru --}}
        <div class="queue-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-accent-blue animate-fade-in-up" data-status="baru" style="animation-delay: 80ms">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-002</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-blue bg-blue-100 px-2 py-0.5 rounded-full ml-2">● Baru</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">13:50</span>
            </div>
            <div class="space-y-1.5 mb-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">1x Smoothie Berry Blast</span>
                    <span class="font-bold text-gray-900">Rp 22.000</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <i data-lucide="user" class="w-3 h-3"></i>
                    <span>Sarah · Pick-up</span>
                </div>
                <button onclick="updateStatus(this, 'diproses')" class="bg-primary hover:bg-primary-dark text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-btn transition-all active:scale-95 flex items-center gap-1">
                    <i data-lucide="chef-hat" class="w-3 h-3"></i> Proses
                </button>
            </div>
        </div>

        {{-- Order 3 — Diproses --}}
        <div class="queue-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-accent-yellow animate-fade-in-up" data-status="diproses" style="animation-delay: 160ms">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-003</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full ml-2">● Diproses</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">13:30</span>
            </div>
            <div class="space-y-1.5 mb-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">3x Jus Jeruk Murni</span>
                    <span class="font-bold text-gray-900">Rp 36.000</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">1x Green Detox</span>
                    <span class="font-bold text-gray-900">Rp 25.000</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <i data-lucide="user" class="w-3 h-3"></i>
                    <span>Ahmad · Delivery</span>
                </div>
                <button onclick="updateStatus(this, 'selesai')" class="bg-secondary hover:bg-secondary-dark text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-btn-green transition-all active:scale-95 flex items-center gap-1">
                    <i data-lucide="check" class="w-3 h-3"></i> Selesai
                </button>
            </div>
        </div>

        {{-- Order 4 — Selesai --}}
        <div class="queue-card bg-white rounded-2xl shadow-card p-4 border-l-4 border-secondary opacity-60 animate-fade-in-up" data-status="selesai" style="animation-delay: 240ms">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-primary font-black text-sm">JK-004</span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-secondary-dark bg-secondary-light px-2 py-0.5 rounded-full ml-2">● Selesai</span>
                </div>
                <span class="text-[10px] font-medium text-gray-400">13:15</span>
            </div>
            <div class="space-y-1.5 mb-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-gray-700">2x Jus Mangga Thai</span>
                    <span class="font-bold text-gray-900">Rp 32.000</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <i data-lucide="user" class="w-3 h-3"></i>
                    <span>Diana · Pick-up</span>
                </div>
                <span class="text-xs font-bold text-secondary flex items-center gap-1">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai
                </span>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Filter tabs
    document.querySelectorAll('.queue-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.queue-tab').forEach(t => {
                t.classList.remove('text-white', 'bg-primary', 'shadow-btn', 'font-bold');
                t.classList.add('text-gray-500', 'bg-white', 'border-2', 'border-gray-200', 'font-semibold');
            });
            tab.classList.add('text-white', 'bg-primary', 'shadow-btn', 'font-bold');
            tab.classList.remove('text-gray-500', 'bg-white', 'border-2', 'border-gray-200', 'font-semibold');

            const filter = tab.dataset.filter;
            document.querySelectorAll('.queue-card').forEach(card => {
                card.style.display = (filter === 'all' || card.dataset.status === filter) ? '' : 'none';
            });
        });
    });

    lucide.createIcons();
});

function updateStatus(btn, newStatus) {
    const card = btn.closest('.queue-card');
    card.dataset.status = newStatus;

    if (newStatus === 'diproses') {
        card.querySelector('.border-l-4').classList.replace('border-accent-blue', 'border-accent-yellow');
        const badge = card.querySelector('[class*="bg-blue-100"]');
        if (badge) {
            badge.className = 'inline-flex items-center gap-1 text-[11px] font-bold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full ml-2';
            badge.textContent = '● Diproses';
        }
        btn.className = 'bg-secondary hover:bg-secondary-dark text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-btn-green transition-all active:scale-95 flex items-center gap-1';
        btn.innerHTML = '<i data-lucide="check" class="w-3 h-3"></i> Selesai';
        btn.setAttribute('onclick', "updateStatus(this, 'selesai')");
        showToast('Pesanan sedang diproses!', '👨‍🍳');
    } else if (newStatus === 'selesai') {
        card.classList.add('opacity-60');
        card.querySelector('.border-l-4')?.classList.replace('border-accent-yellow', 'border-secondary');
        const badge = card.querySelector('[class*="bg-yellow-100"]');
        if (badge) {
            badge.className = 'inline-flex items-center gap-1 text-[11px] font-bold text-secondary-dark bg-secondary-light px-2 py-0.5 rounded-full ml-2';
            badge.textContent = '● Selesai';
        }
        btn.outerHTML = '<span class="text-xs font-bold text-secondary flex items-center gap-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Selesai</span>';
        showToast('Pesanan selesai disiapkan!', '✅');
    }
    lucide.createIcons();
}
</script>
@endsection
