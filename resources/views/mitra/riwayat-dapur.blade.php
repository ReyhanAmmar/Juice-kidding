@extends('layouts.main', ['hideHeader' => true, 'hideMinimalHeader' => true, 'hideFooter' => true])

@section('title', 'Riwayat Pesanan - Juice Kidding')

@section('content')
@include('mitra.partials.dapur-header')

<main class="w-full pt-14 pb-10 bg-[#F8F7FC] min-h-screen">
    <div class="max-w-[900px] mx-auto px-4 md:px-8">

        {{-- Page Header --}}
        <div class="pt-8 pb-6 mb-8 border-b border-[#E8E6F0]">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-[#1A1820] font-['Nunito']">Riwayat Pesanan</h1>
                    <p class="text-[#9B97A8] text-sm font-medium mt-1">Semua pesanan yang telah diproses dapur</p>
                </div>
                <div class="flex items-center gap-2 text-xs text-[#9B97A8] bg-white px-3 py-1.5 rounded-full border border-[#E8E6F0]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#96C84B] animate-pulse"></span>
                    <span class="font-bold">{{ $totalHariIni }} selesai hari ini</span>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] p-4">
                <span class="text-[11px] font-bold text-[#9B97A8] uppercase tracking-wider">Total Riwayat</span>
                <div class="text-xl font-black text-[#1A1820] mt-1">{{ $riwayat->total() }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] p-4">
                <span class="text-[11px] font-bold text-[#9B97A8] uppercase tracking-wider">Selesai</span>
                <div class="text-xl font-black text-[#6E9A2A] mt-1">{{ $riwayat->where('id_status_pesanan', 6)->count() }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] p-4">
                <span class="text-[11px] font-bold text-[#9B97A8] uppercase tracking-wider">Siap</span>
                <div class="text-xl font-black text-[#E17D19] mt-1">{{ $riwayat->where('id_status_pesanan', 3)->count() }}</div>
            </div>
            <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] p-4">
                <span class="text-[11px] font-bold text-[#9B97A8] uppercase tracking-wider">Diantar</span>
                <div class="text-xl font-black text-[#194B96] mt-1">{{ $riwayat->whereIn('id_status_pesanan', [4, 5])->count() }}</div>
            </div>
        </div>

        {{-- Riwayat List --}}
        <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] overflow-hidden">
            <div class="px-5 py-4 border-b border-[#E8E6F0] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#FDF3E7] flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="w-4 h-4 text-[#E17D19]" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-[#1A1820]">Daftar Riwayat</h2>
                        <p class="text-[11px] text-[#9B97A8]">Pesanan yang sudah diproses dapur</p>
                    </div>
                </div>
            </div>

            @if($riwayat->count() > 0)
                <div class="divide-y divide-[#E8E6F0]">
                    @foreach($riwayat as $order)
                    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F8F7FC] transition-colors">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            {{-- Status Icon --}}
                            <div class="flex-shrink-0">
                                @php
                                    $statusIcons = [
                                        3 => ['icon' => 'package-check', 'bg' => 'bg-[#FDF3E7]', 'color' => 'text-[#E17D19]'],
                                        4 => ['icon' => 'truck', 'bg' => 'bg-[#194B96]/10', 'color' => 'text-[#194B96]'],
                                        5 => ['icon' => 'map-pin', 'bg' => 'bg-[#194B96]/10', 'color' => 'text-[#194B96]'],
                                        6 => ['icon' => 'check', 'bg' => 'bg-[#EEF7D8]', 'color' => 'text-[#6E9A2A]'],
                                    ];
                                    $s = $statusIcons[$order->id_status_pesanan] ?? ['icon' => 'circle', 'bg' => 'bg-[#F8F7FC]', 'color' => 'text-[#9B97A8]'];
                                @endphp
                                <div class="w-7 h-7 rounded-full {{ $s['bg'] }} flex items-center justify-center">
                                    <i data-lucide="{{ $s['icon'] }}" class="w-3.5 h-3.5 {{ $s['color'] }}" aria-hidden="true"></i>
                                </div>
                            </div>
                            {{-- Info --}}
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-[#E17D19]">#{{ $order->kode_pesanan }}</span>
                                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $order->id_tipe_pesanan == 1 ? 'bg-[#194B96]/10 text-[#194B96]' : 'bg-[#96C84B]/15 text-[#6E9A2A]' }}">
                                        {{ $order->id_tipe_pesanan == 1 ? 'Pick-up' : 'Delivery' }}
                                    </span>
                                </div>
                                <span class="text-[11px] text-[#9B97A8] truncate block mt-0.5">
                                    {{ $order->detail_pesanan->pluck('nama_menu_snapshot')->take(2)->join(', ') }}
                                    @if($order->detail_pesanan->count() > 2)
                                        <span class="text-[#9B97A8]">+{{ $order->detail_pesanan->count() - 2 }} lagi</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        {{-- Meta --}}
                        <div class="flex items-center gap-3 flex-shrink-0">
                            @if($order->durasi_menit !== null)
                                <span class="text-[10px] font-bold text-[#6E9A2A] bg-[#EEF7D8] px-2 py-0.5 rounded-full flex items-center gap-1 whitespace-nowrap">
                                    <i data-lucide="timer" class="w-3 h-3" aria-hidden="true"></i>
                                    {{ $order->durasi_menit }} mnt
                                </span>
                            @endif
                            <span class="text-[11px] text-[#9B97A8] whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($order->updated_at)->format('d/m H:i') }}
                            </span>
                            <span class="text-[10px] font-bold whitespace-nowrap
                                {{ $order->id_status_pesanan == 6 ? 'text-[#6E9A2A]' : ($order->id_status_pesanan == 3 ? 'text-[#E17D19]' : 'text-[#194B96]') }}">
                                {{ ['Siap', 'Diantar', 'Sampai', 'Selesai'][$order->id_status_pesanan - 3] ?? '-' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($riwayat->hasPages())
                <div class="px-5 py-4 border-t border-[#E8E6F0] flex items-center justify-between">
                    <span class="text-[11px] text-[#9B97A8]">Halaman {{ $riwayat->currentPage() }} dari {{ $riwayat->lastPage() }}</span>
                    <div class="flex items-center gap-2">
                        @if($riwayat->previousPageUrl())
                            <a href="{{ $riwayat->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-[#E17D19] bg-[#FDF3E7] hover:bg-[#FDF3E7]/80 transition-colors">← Sebelumnya</a>
                        @endif
                        @if($riwayat->nextPageUrl())
                            <a href="{{ $riwayat->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-[#E17D19] hover:bg-[#C45E0A] transition-colors">Selanjutnya →</a>
                        @endif
                    </div>
                </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-12 h-12 bg-[#F8F7FC] rounded-full flex items-center justify-center mb-3">
                        <i data-lucide="clipboard-list" class="w-6 h-6 text-[#9B97A8]" aria-hidden="true"></i>
                    </div>
                    <p class="text-[#1A1820] text-sm font-bold">Belum Ada Riwayat</p>
                    <p class="text-[#9B97A8] text-xs mt-1">Pesanan yang sudah diproses akan muncul di sini.</p>
                </div>
            @endif
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endsection