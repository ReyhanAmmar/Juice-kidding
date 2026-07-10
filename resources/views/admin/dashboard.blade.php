@extends('layouts.app-admin')

@section('title', 'Dashboard')
@section('page-title', 'Overview')
@section('page-subtitle', 'Statistik dan ringkasan aktivitas terbaru')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Subscription Generator Panel --}}
    <div class="bg-gradient-to-r from-[#E17D19] to-[#E17D19]/80 rounded-3xl p-6 shadow-card border border-orange-100 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-lg font-black font-['Nunito']">Pemicu Pengiriman Langganan Harian</h3>
            <p class="text-white/90 text-xs font-medium mt-1">Tekan tombol di samping setiap pagi untuk meng-generate pesanan harian bernilai Rp0 dari seluruh pelanggan yang memiliki jadwal kirim hari ini.</p>
        </div>
        <form action="{{ route('admin.langganan.generate') }}" method="POST" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-white text-[#E17D19] hover:bg-orange-50 font-black rounded-2xl text-sm transition-all active:scale-95 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Generate Pengiriman Hari Ini
            </button>
        </form>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1 --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 flex flex-col justify-between hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-secondary-light flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6 text-secondary-dark"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="px-2 py-1 bg-green-50 text-green-600 rounded-lg font-bold flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> 12%
                </span>
                <span class="text-gray-400 font-medium">dari bulan lalu</span>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 flex flex-col justify-between hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 mb-1">Pesanan Selesai</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ number_format($pesananSelesai, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-light flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-6 h-6 text-primary-dark"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="px-2 py-1 bg-green-50 text-green-600 rounded-lg font-bold flex items-center gap-1">
                    <i data-lucide="check-circle" class="w-3 h-3"></i> Sukses
                </span>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 flex flex-col justify-between hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 mb-1">Pesanan Aktif</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ number_format($pesananBaru, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-orange-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="px-2 py-1 bg-orange-50 text-orange-600 rounded-lg font-bold flex items-center gap-1">
                    Proses
                </span>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 flex flex-col justify-between hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-400 mb-1">Total Pelanggan</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ number_format($totalPelanggan, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm text-gray-400 font-medium">
                Customer terdaftar
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Pesanan Terbaru --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-card border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-black text-gray-800 text-lg">Pesanan Terbaru</h3>
                <a href="{{ route('admin.pesanan') }}" class="text-primary font-bold text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 font-bold">Kode Pesanan</th>
                            <th class="pb-3 font-bold">Pelanggan</th>
                            <th class="pb-3 font-bold">Total</th>
                            <th class="pb-3 font-bold">Status</th>
                            <th class="pb-3 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($pesananTerbaru as $pesanan)
                        <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="py-4 font-bold text-gray-700">#{{ $pesanan->kode_pesanan }}</td>
                            <td class="py-4 text-gray-600 font-medium">{{ $pesanan->customer->nama_lengkap ?? 'Guest' }}</td>
                            <td class="py-4 font-bold text-primary">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                            <td class="py-4">
                                @if($pesanan->id_status_pesanan == 6)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Selesai</span>
                                @elseif($pesanan->id_status_pesanan == 7)
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Batal</span>
                                @else
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">Proses</span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                <button class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 inline-flex items-center justify-center transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 font-medium">Belum ada pesanan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Menu Terlaris --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100">
            <h3 class="font-black text-gray-800 text-lg mb-6">Menu Terlaris</h3>
            <div class="space-y-5">
                @forelse($menuTerlaris as $menu)
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                        @if($menu->foto)
                            <img src="{{ asset('storage/'.$menu->foto) }}" alt="{{ $menu->nama_jus }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-primary-light text-primary font-bold">
                                {{ substr($menu->nama_jus, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-800 truncate">{{ $menu->nama_jus }}</h4>
                        <p class="text-xs text-gray-400 font-medium truncate">{{ $menu->detail_pesanan_sum_jumlah ?? 0 }} terjual</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-primary">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-gray-400 font-medium text-sm">Belum ada data penjualan.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
