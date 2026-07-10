@extends('layouts.main', ['hideHeader' => true, 'hideMinimalHeader' => true, 'hideFooter' => true])

@section('title', 'Pengantaran — Juice Kidding')

@section('head')
<style>
    @keyframes delivery-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(225,125,25,0.3); }
        50% { box-shadow: 0 0 0 8px rgba(225,125,25,0); }
    }
    .card-active {
        animation: delivery-pulse 2s ease-in-out infinite;
    }
    @media (prefers-reduced-motion: reduce) {
        .card-active { animation: none !important; }
    }
</style>
@endsection

@section('content')
@include('mitra.partials.dapur-header')

<main class="w-full pt-14 bg-zinc-50 min-h-screen">
    {{-- Mobile-first container --}}
    <div class="max-w-md mx-auto px-4 py-5">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-black text-zinc-900">Pengantaran</h1>
                <p class="text-xs text-zinc-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d M') }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if($antrean->count() > 0)
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $antrean->count() }} antrean
                </span>
                @endif
                @if($aktif->count() > 0)
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    {{ $aktif->count() }} aktif
                </span>
                @endif
            </div>
        </div>

        {{-- ===== SECTION: Pengantaran Aktif (priority) ===== --}}
        @if($aktif->count() > 0)
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i data-lucide="truck" class="w-3.5 h-3.5 text-blue-600" aria-hidden="true"></i>
                </div>
                <span class="text-sm font-black text-zinc-900">Sedang Diantar</span>
            </div>

            <div class="space-y-4">
                @foreach($aktif as $order)
                <div class="card-active bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden">
                    {{-- Address — BIG AND CLEAR --}}
                    <div class="p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white text-base font-black flex items-center justify-center flex-shrink-0 shadow-sm">
                                {{ $order->customer ? strtoupper(substr($order->customer->nama_lengkap, 0, 1)) : '?' }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-base font-black text-zinc-900">{{ $order->customer->nama_lengkap ?? 'Pelanggan' }}</p>
                                @if($order->jarak_km)
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-flex items-center gap-1 mt-1">
                                    <i data-lucide="map-pin" class="w-3 h-3" aria-hidden="true"></i>
                                    {{ $order->jarak_km }} km
                                </span>
                                @endif
                            </div>
                            <span class="text-[10px] font-bold text-blue-600 whitespace-nowrap bg-blue-50 px-2 py-1 rounded-full">Aktif</span>
                        </div>

                        {{-- Address --}}
                        <div class="mt-4 flex items-start gap-2.5">
                            <i data-lucide="map-pin" class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" aria-hidden="true"></i>
                            <p class="text-sm font-bold text-zinc-700 leading-snug">{{ $order->alamat->alamat_lengkap ?? 'Alamat tidak tersedia' }}</p>
                        </div>

                        {{-- Items summary --}}
                        <div class="mt-3 flex items-center gap-2 text-xs text-zinc-500 font-medium">
                            <i data-lucide="package" class="w-3.5 h-3.5" aria-hidden="true"></i>
                            <span>#{{ $order->kode_pesanan }} · {{ $order->detail_pesanan->sum('jumlah') }} item</span>
                        </div>
                    </div>

                    {{-- Big action buttons --}}
                    <div class="px-5 pb-5 flex flex-col gap-2.5">
                        <button onclick="openMaps('{{ $order->alamat->alamat_lengkap ?? ($order->alamat->latitude ?? '').','.($order->alamat->longitude ?? '') }}')"
                                class="w-full py-3.5 border-2 border-blue-600 text-blue-700 font-black rounded-xl text-sm hover:bg-blue-50 transition-all active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="navigation" class="w-5 h-5" aria-hidden="true"></i>
                            Buka Peta
                        </button>
                        <button onclick="selesaiAntar({{ $order->id_pesanan }}, this)"
                                class="w-full py-4 bg-lime-500 hover:bg-lime-600 text-white font-black rounded-xl text-base transition-all active:scale-[0.98] shadow-lg shadow-lime-500/25 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <i data-lucide="check-circle" class="w-5 h-5" aria-hidden="true"></i>
                            Selesaikan Pengantaran
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ===== SECTION: Antrean Pengantaran ===== --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i data-lucide="package" class="w-3.5 h-3.5 text-amber-600" aria-hidden="true"></i>
                </div>
                <span class="text-sm font-black text-zinc-900">Antrean Pengantaran</span>
                @if($antrean->count() > 0)
                <span class="text-[10px] font-bold text-zinc-400 bg-zinc-100 px-2 py-0.5 rounded-full">{{ $antrean->count() }}</span>
                @endif
            </div>

            @if($antrean->count() > 0)
            <div class="space-y-3">
                @foreach($antrean as $order)
                <div class="bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden">
                    <div class="p-4">
                        {{-- Customer & order code --}}
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-amber-600 text-white text-sm font-black flex items-center justify-center flex-shrink-0">
                                    {{ $order->customer ? strtoupper(substr($order->customer->nama_lengkap, 0, 1)) : '?' }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-zinc-900">{{ $order->customer->nama_lengkap ?? 'Pelanggan' }}</p>
                                    <span class="text-xs font-bold text-amber-700">#{{ $order->kode_pesanan }}</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-400">
                                {{ $order->detail_pesanan->sum('jumlah') }} item
                            </span>
                        </div>

                        {{-- Address — focus here --}}
                        <div class="flex items-start gap-2.5 mb-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-red-400 flex-shrink-0 mt-0.5" aria-hidden="true"></i>
                            <p class="text-sm font-bold text-zinc-700 leading-snug">{{ $order->alamat->alamat_lengkap ?? 'Alamat tidak tersedia' }}</p>
                        </div>

                        {{-- Distance if available --}}
                        @if($order->jarak_km)
                        <div class="flex items-center gap-1.5 text-xs font-bold text-zinc-500 mb-3">
                            <i data-lucide="map" class="w-3.5 h-3.5" aria-hidden="true"></i>
                            <span>Jarak: {{ $order->jarak_km }} km</span>
                        </div>
                        @endif
                    </div>

                    {{-- Action buttons --}}
                    <div class="px-4 pb-4 flex flex-col gap-2.5">
                        @if($order->alamat && ($order->alamat->latitude || $order->alamat->alamat_lengkap))
                        <button onclick="openMaps('{{ $order->alamat->alamat_lengkap ?? $order->alamat->latitude.','.$order->alamat->longitude }}')"
                                class="w-full py-3 border-2 border-amber-600 text-amber-700 font-black rounded-xl text-sm hover:bg-amber-50 transition-all active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer">
                            <i data-lucide="navigation" class="w-4 h-4" aria-hidden="true"></i>
                            Lihat di Peta
                        </button>
                        @endif
                        <button onclick="ambilPesanan({{ $order->id_pesanan }}, this)"
                                class="w-full py-4 bg-amber-600 hover:bg-amber-700 text-white font-black rounded-xl text-base transition-all active:scale-[0.98] shadow-lg shadow-amber-600/25 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <i data-lucide="package" class="w-5 h-5" aria-hidden="true"></i>
                            Ambil Pesanan
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-2xl border border-dashed border-zinc-200 p-8 text-center">
                <div class="w-12 h-12 bg-zinc-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="package" class="w-6 h-6 text-zinc-300" aria-hidden="true"></i>
                </div>
                <p class="text-sm font-black text-zinc-500">Tidak Ada Antrean</p>
                <p class="text-xs text-zinc-400 mt-1">Semua pesanan sudah diambil driver.</p>
            </div>
            @endif
        </div>

        {{-- ===== SECTION: Riwayat ===== --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-zinc-100 flex items-center justify-center">
                    <i data-lucide="clipboard-check" class="w-3.5 h-3.5 text-zinc-500" aria-hidden="true"></i>
                </div>
                <span class="text-sm font-black text-zinc-900">Riwayat</span>
                @if($riwayat->count() > 0)
                <span class="text-[10px] font-bold text-zinc-400 bg-zinc-100 px-2 py-0.5 rounded-full">{{ $riwayat->count() }}</span>
                @endif
            </div>

            @if($riwayat->count() > 0)
            <div class="bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden divide-y divide-zinc-100">
                @foreach($riwayat as $order)
                <div class="px-4 py-3 flex items-center justify-between gap-3 opacity-60">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-7 h-7 rounded-full bg-lime-100 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-lime-600" aria-hidden="true"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-zinc-900 truncate">#{{ $order->kode_pesanan }}</p>
                            <p class="text-[11px] text-zinc-400 truncate">{{ $order->customer->nama_lengkap ?? 'Pelanggan' }}</p>
                        </div>
                    </div>
                    <span class="text-[11px] text-zinc-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($order->updated_at)->format('H:i') }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-2xl border border-dashed border-zinc-200 p-8 text-center">
                <div class="w-12 h-12 bg-zinc-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i data-lucide="clipboard-check" class="w-6 h-6 text-zinc-300" aria-hidden="true"></i>
                </div>
                <p class="text-sm font-black text-zinc-500">Belum Ada Riwayat</p>
                <p class="text-xs text-zinc-400 mt-1">Pengantaran yang selesai akan muncul di sini.</p>
            </div>
            @endif
        </div>

    </div>
</main>

<script>
function openMaps(address) {
    if (!address) return showToast('Alamat tidak tersedia', '❌');
    window.open('https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(address), '_blank');
}

function ambilPesanan(id, btn) {
    if (btn.disabled) return;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin" aria-hidden="true"></i> Memproses...';
    if (typeof lucide !== 'undefined') lucide.createIcons();

    fetch('{{ url("driver/ambil-pesanan") }}/' + id, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Pesanan diambil!', '📦');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Gagal mengambil pesanan', '❌');
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="package" class="w-5 h-5"></i> Ambil Pesanan';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    })
    .catch(() => {
        showToast('Terjadi kesalahan', '❌');
        btn.disabled = false;
        btn.innerHTML = '<i data-lucide="package" class="w-5 h-5"></i> Ambil Pesanan';
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
}

function selesaiAntar(id, btn) {
    if (btn.disabled) return;
    btn.disabled = true;
    btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Memproses...';
    if (typeof lucide !== 'undefined') lucide.createIcons();

    fetch('{{ url("driver/selesai-antar") }}/' + id, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Pengantaran selesai!', '✅');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Gagal', '❌');
            btn.disabled = false;
            btn.innerHTML = '<i data-lucide="check-circle" class="w-5 h-5"></i> Selesaikan Pengantaran';
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    })
    .catch(() => {
        showToast('Terjadi kesalahan', '❌');
        btn.disabled = false;
        btn.innerHTML = '<i data-lucide="check-circle" class="w-5 h-5"></i> Selesaikan Pengantaran';
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
}

function showToast(msg, emoji) {
    const toast = document.getElementById('toast');
    const msgEl = document.getElementById('toast-msg');
    const emojiEl = document.getElementById('toast-emoji');
    if (msgEl) msgEl.textContent = msg;
    if (emojiEl) emojiEl.textContent = emoji || '✅';
    if (toast) {
        toast.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
        toast.classList.add('opacity-100', 'translate-y-0');
        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
            toast.classList.remove('opacity-100', 'translate-y-0');
        }, 3000);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Realtime: reload halaman tiap 15 detik untuk cek antrean baru
    setTimeout(() => location.reload(), 15000);
});
</script>
@endsection