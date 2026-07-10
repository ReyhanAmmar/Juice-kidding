@extends('layouts.main')

@section('title', 'Pesanan Saya - Juice Kidding')

@section('content')
<main class="w-full pt-32 pb-24 bg-gray-50 min-h-screen">
    <div class="max-w-[900px] mx-auto px-4 md:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-zinc-900 font-['Nunito']">Pesanan Saya</h1>
            <p class="text-zinc-500 font-medium mt-2">Daftar semua transaksi Anda di Juice Kidding.</p>
        </div>

        @if($pesanans->count() > 0)
        <div class="space-y-4">
            @foreach($pesanans as $pesanan)
            <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-zinc-100 hover:shadow-md transition-shadow">
                {{-- Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="text-amber-600 font-black text-sm">#{{ $pesanan->kode_pesanan }}</span>
                        <p class="text-xs text-zinc-500 font-medium mt-0.5">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d M Y') }}
                            · {{ $pesanan->id_tipe_pesanan == 1 ? 'Pick-up' : 'Delivery' }}
                        </p>
                    </div>
                    @php
                        $statusColors = [
                            1 => 'bg-blue-100 text-blue-700',
                            2 => 'bg-yellow-100 text-yellow-700',
                            3 => 'bg-purple-100 text-purple-700',
                            4 => 'bg-orange-100 text-orange-700',
                            5 => 'bg-cyan-100 text-cyan-700',
                            6 => 'bg-green-100 text-green-700',
                            7 => 'bg-red-100 text-red-700',
                        ];
                        $statusLabels = [
                            1 => 'Baru', 2 => 'Diproses', 3 => 'Siap',
                            4 => 'Diantar', 5 => 'Sampai', 6 => 'Selesai', 7 => 'Dibatalkan',
                        ];
                        $sc = $statusColors[$pesanan->id_status_pesanan] ?? 'bg-gray-100 text-gray-700';
                        $sl = $statusLabels[$pesanan->id_status_pesanan] ?? 'Unknown';
                    @endphp
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold {{ $sc }} px-2.5 py-1 rounded-full">
                        ● {{ $sl }}
                    </span>
                </div>

                {{-- Items --}}
                <div class="space-y-2 mb-4">
                    @foreach($pesanan->detail_pesanan as $detail)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-zinc-100 overflow-hidden flex-shrink-0">
                                @if($detail->menu && $detail->menu->foto)
                                    <img src="{{ asset('storage/'.$detail->menu->foto) }}" alt="{{ $detail->nama_menu_snapshot }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-amber-50 text-amber-600 font-bold text-xs">
                                        {{ substr($detail->nama_menu_snapshot, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <span class="font-medium text-zinc-700">{{ $detail->jumlah }}x {{ $detail->nama_menu_snapshot }}</span>
                        </div>
                        <span class="font-bold text-zinc-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-3 border-t border-zinc-100">
                    <div class="flex items-center gap-2">
                        @if($pesanan->id_status_pesanan <= 5 && $pesanan->id_status_pesanan >= 1)
                        <a href="{{ route('customer.tracking', ['id' => $pesanan->id_pesanan]) }}"
                           class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-all active:scale-95 inline-flex items-center gap-1.5">
                            <i data-lucide="route" class="w-3 h-3"></i> Lacak Pesanan
                        </a>
                        @endif
                    </div>
                    <span class="font-extrabold text-amber-600 text-lg">
                        Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $pesanans->links() }}
        </div>
        @else
        <div class="bg-white rounded-3xl p-12 shadow-sm border border-zinc-100 text-center">
            <div class="w-20 h-20 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shopping-bag" class="w-10 h-10 text-amber-300"></i>
            </div>
            <h3 class="text-lg font-bold text-zinc-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-zinc-500 text-sm mb-6">Yuk mulai pesan jus segar favoritmu!</p>
            <a href="{{ route('menu') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-2xl transition-all shadow-[0_4px_16px_rgba(245,158,11,0.35)] inline-flex items-center gap-2">
                <i data-lucide="grid" class="w-4 h-4"></i> Lihat Menu
            </a>
        </div>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
