@extends('layouts.main')

@section('title', 'Lacak Pesanan — Juice Kidding')

@section('content')
<main class="w-full pt-32 pb-24 bg-gray-50 min-h-screen">
    <div class="max-w-[700px] mx-auto px-4 md:px-8">
        
        {{-- Page Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('customer.riwayat') }}" class="w-9 h-9 rounded-xl bg-white border border-zinc-200 flex items-center justify-center hover:bg-zinc-50 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 text-zinc-600"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-zinc-900 font-['Nunito']">Lacak Pesanan</h1>
                <p class="text-xs font-medium text-zinc-500">Kode: <span class="text-amber-600 font-bold">{{ $pesanan->kode_pesanan }}</span></p>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
            </div>
            <span class="text-sm font-bold text-green-700">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Order Summary Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-100 p-5 mb-5">
            <div class="flex items-center justify-between mb-3">
                @php
                    $statusColors = [
                        1 => 'text-blue-600 bg-blue-50', 2 => 'text-yellow-600 bg-yellow-50',
                        3 => 'text-purple-600 bg-purple-50', 4 => 'text-orange-600 bg-orange-50',
                        5 => 'text-cyan-600 bg-cyan-50', 6 => 'text-green-600 bg-green-50',
                        7 => 'text-red-600 bg-red-50',
                    ];
                    $statusLabels = [
                        1 => 'Baru', 2 => 'Diproses', 3 => 'Siap',
                        4 => 'Diantar', 5 => 'Sampai', 6 => 'Selesai', 7 => 'Dibatalkan',
                    ];
                    $sc = $statusColors[$pesanan->id_status_pesanan] ?? 'text-gray-600 bg-gray-50';
                    $sl = $statusLabels[$pesanan->id_status_pesanan] ?? 'Unknown';
                @endphp
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold {{ $sc }} px-3 py-1.5 rounded-full">
                    ● {{ $sl }}
                </span>
                <span class="text-xs font-medium text-zinc-500">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d M Y') }}</span>
            </div>
            <div class="bg-zinc-50 rounded-xl p-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">🥤</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-zinc-900">{{ $pesanan->detail_pesanan->sum('jumlah') }} item</p>
                        <p class="text-xs font-medium text-zinc-500 line-clamp-1">
                            {{ $pesanan->detail_pesanan->pluck('nama_menu_snapshot')->join(', ') }}
                        </p>
                    </div>
                    <span class="text-amber-600 font-extrabold text-sm">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Progress Tracker --}}
        @if($pesanan->id_status_pesanan != 7)
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-100 p-5 mb-5">
            <h3 class="text-sm font-black text-zinc-900 mb-4 flex items-center gap-2">
                <i data-lucide="route" class="w-4 h-4 text-amber-600"></i>
                Status Pesanan
            </h3>

            <div class="space-y-0 px-2">
                @foreach($statusList as $index => $step)
                @php
                    $riwayat = $pesanan->riwayat_status->where('id_status_pesanan', $step['id'])->first();
                    $isPast = $pesanan->id_status_pesanan > $step['id'];
                    $isCurrent = $pesanan->id_status_pesanan == $step['id'];
                    $isTerminal = in_array($pesanan->id_status_pesanan, [6, 7]);
                    $isCompleted = $isPast || ($isCurrent && $isTerminal);
                    $isActive = $isCurrent && !$isTerminal;
                    $isPending = !$isCompleted && !$isActive;
                    $isLast = $index === count($statusList) - 1;
                @endphp
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center flex-shrink-0">
                        @if($isCompleted && !$isActive)
                        <div class="w-9 h-9 rounded-full bg-green-500 flex items-center justify-center shadow-[0_4px_16px_rgba(150,200,75,0.35)]">
                            <i data-lucide="check" class="w-4 h-4 text-white"></i>
                        </div>
                        @elseif($isActive)
                        <div class="w-9 h-9 rounded-full bg-amber-500 flex items-center justify-center shadow-[0_4px_16px_rgba(225,125,25,0.35)] ring-4 ring-amber-500/20 animate-pulse">
                            <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 text-white"></i>
                        </div>
                        @else
                        <div class="w-9 h-9 rounded-full bg-zinc-100 border-2 border-dashed border-zinc-300 flex items-center justify-center">
                            <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4 text-zinc-300"></i>
                        </div>
                        @endif
                        @if(!$isLast)
                        <div class="w-0.5 h-10 {{ $isCompleted && !$isActive ? 'bg-green-500' : 'bg-zinc-200' }} mt-1"></div>
                        @endif
                    </div>
                    <div class="pt-1.5 {{ !$isLast ? 'pb-6' : '' }}">
                        @if($isActive)
                        <p class="text-sm font-black text-amber-600">{{ $step['label'] }}</p>
                        @elseif($isCompleted)
                        <p class="text-sm font-bold text-zinc-900">{{ $step['label'] }}</p>
                        @else
                        <p class="text-sm font-semibold text-zinc-300">{{ $step['label'] }}</p>
                        @endif
                        @if($riwayat)
                        <p class="text-xs font-medium text-zinc-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($riwayat->created_at)->format('H:i') }} · {{ $step['desc'] }}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        {{-- Cancelled order message --}}
        <div class="bg-red-50 rounded-2xl border border-red-200 p-5 mb-5 text-center">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="x-circle" class="w-6 h-6 text-red-500"></i>
            </div>
            <h3 class="text-lg font-bold text-red-700">Pesanan Dibatalkan</h3>
            @php $batalRiwayat = $pesanan->riwayat_status->where('id_status_pesanan', 7)->first(); @endphp
            @if($batalRiwayat)
            <p class="text-sm text-red-500 mt-1">{{ $batalRiwayat->catatan }}</p>
            @endif
        </div>
        @endif

        {{-- Order Detail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-zinc-100 p-5 mb-5">
            <h3 class="text-sm font-black text-zinc-900 mb-3 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-blue-600"></i>
                Detail Pesanan
            </h3>

            {{-- Items --}}
            <div class="space-y-3 mb-4">
                @foreach($pesanan->detail_pesanan as $detail)
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium text-zinc-600">{{ $detail->jumlah }}x {{ $detail->nama_menu_snapshot }}</span>
                    <span class="font-bold text-zinc-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="space-y-3 text-sm border-t border-zinc-100 pt-3">
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Tipe Pesanan</span>
                    <span class="font-bold text-zinc-900 flex items-center gap-1">
                        @if($pesanan->id_tipe_pesanan == 2)
                        <i data-lucide="truck" class="w-3.5 h-3.5 text-amber-600"></i> Delivery
                        @else
                        <i data-lucide="store" class="w-3.5 h-3.5 text-amber-600"></i> Pick-up
                        @endif
                    </span>
                </div>
                @if($pesanan->alamat_snapshot)
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Alamat</span>
                    <span class="font-bold text-zinc-900 text-right max-w-[60%]">{{ $pesanan->alamat_snapshot }}</span>
                </div>
                @endif
                @if($pesanan->driver)
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Driver</span>
                    <span class="font-bold text-zinc-900">{{ $pesanan->driver->nama_lengkap }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Pembayaran</span>
                    <span class="font-bold text-zinc-900">{{ $pesanan->metode_pembayaran }}</span>
                </div>
                @if($pesanan->ongkos_kirim > 0)
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Subtotal</span>
                    <span class="font-bold text-zinc-900">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-medium text-zinc-500">Ongkos Kirim</span>
                    <span class="font-bold text-zinc-900">Rp {{ number_format($pesanan->ongkos_kirim, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="border-t border-zinc-100 pt-3 flex justify-between">
                    <span class="font-bold text-zinc-900">Total</span>
                    <span class="font-extrabold text-amber-600 text-lg">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col items-center gap-3">
            <a href="{{ route('customer.riwayat') }}" class="text-sm font-bold text-zinc-500 hover:text-amber-600 transition-colors inline-flex items-center gap-1.5">
                <i data-lucide="list" class="w-4 h-4"></i> Lihat Semua Pesanan
            </a>
        </div>

    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    // Auto-refresh tiap 15 detik selama pesanan masih aktif
    const activeStatuses = [1, 2, 3, 4, 5];
    if (activeStatuses.includes({{ $pesanan->id_status_pesanan }})) {
        setTimeout(() => location.reload(), 15000);
    }
});
</script>
@endsection
