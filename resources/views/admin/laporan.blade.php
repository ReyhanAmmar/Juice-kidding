@extends('layouts.app-admin')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')
@section('page-subtitle', 'Analisis performa penjualan dan keuangan')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Date Range Filter --}}
    <div class="bg-white rounded-3xl p-5 shadow-card border border-gray-100">
        <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6">
            <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-widest">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="bg-gray-50 border-2 border-transparent rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:border-primary focus:bg-white outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-widest">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="bg-gray-50 border-2 border-transparent rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:border-primary focus:bg-white outline-none transition-all">
                </div>
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-btn transition-all active:scale-95">
                    Terapkan
                </button>
            </form>
            
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.laporan', ['filter' => 'hari-ini']) }}" class="px-4 py-2.5 text-sm font-bold rounded-xl border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all {{ request('filter') == 'hari-ini' ? 'bg-primary text-white border-primary shadow-btn' : 'text-gray-600' }}">
                    <span class="hidden sm:inline">Hari Ini</span><span class="sm:hidden">Hari</span>
                </a>
                <a href="{{ route('admin.laporan', ['filter' => 'minggu-ini']) }}" class="px-4 py-2.5 text-sm font-bold rounded-xl border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all {{ request('filter') == 'minggu-ini' ? 'bg-primary text-white border-primary shadow-btn' : 'text-gray-600' }}">Minggu Ini</a>
                <a href="{{ route('admin.laporan', ['filter' => 'bulan-ini']) }}" class="px-4 py-2.5 text-sm font-bold rounded-xl border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all {{ request('filter') == 'bulan-ini' ? 'bg-primary text-white border-primary shadow-btn' : 'text-gray-600' }}">Bulan Ini</a>
                <a href="{{ route('admin.laporan', ['filter' => 'tahun-ini']) }}" class="px-4 py-2.5 text-sm font-bold rounded-xl border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all {{ request('filter') == 'tahun-ini' ? 'bg-primary text-white border-primary shadow-btn' : 'text-gray-600' }}">Tahun Ini</a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Pendapatan --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($startDate)->format('d/m') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m') }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-secondary-light flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6 text-secondary-dark"></i>
                </div>
            </div>
        </div>

        {{-- Pesanan Sukses --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pesanan Selesai</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ number_format($pesananSukses) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-light flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-6 h-6 text-primary-dark"></i>
                </div>
            </div>
        </div>

        {{-- Rata-rata Pembelian --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Rata-rata Pesanan</p>
                    <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($rataRata, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-6 h-6 text-accent-blue"></i>
                </div>
            </div>
        </div>

        {{-- Pesanan Dibatalkan --}}
        <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100 hover:shadow-card-lg transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Pesanan Batal</p>
                    <h3 class="text-2xl font-black text-gray-800">{{ number_format($pesananBatal) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">{{ $pesananSukses + $pesananBatal > 0 ? number_format(($pesananBatal / max($pesananSukses + $pesananBatal, 1)) * 100, 1) : 0 }}% dari total</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-6 h-6 text-accent-red"></i>
                </div>
            </div>
        </div>
    </div>

    
    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Revenue Trend (Line Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-card border border-gray-100">
            <h3 class="font-black text-gray-800 text-lg mb-1 flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-primary"></i>
                Tren Pendapatan
            </h3>
            <p class="text-xs text-gray-400 font-medium mb-4">
                {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                · {{ $dailyRevenue->count() }} hari data
            </p>
            <div class="relative" style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Breakdown Charts --}}
        <div class="space-y-6">
            {{-- Order Type Doughnut --}}
            <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100">
                <h3 class="font-black text-gray-800 text-sm mb-4">Tipe Pesanan</h3>
                <div class="relative mx-auto" style="max-width: 180px; height: 180px;">
                    <canvas id="typeChart"></canvas>
                </div>
                <div class="flex justify-center gap-4 mt-4 text-xs font-bold">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-accent-blue"></span> Pick-up ({{ $tipePesanan[1] ?? 0 }})</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-accent-purple"></span> Delivery ({{ $tipePesanan[2] ?? 0 }})</span>
                </div>
            </div>

            {{-- Payment Method Doughnut --}}
            <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100">
                <h3 class="font-black text-gray-800 text-sm mb-4">Metode Pembayaran</h3>
                <div class="relative mx-auto" style="max-width: 180px; height: 180px;">
                    <canvas id="paymentChart"></canvas>
                </div>
                <div class="flex justify-center gap-4 mt-4 text-xs font-bold">
                    @foreach($metodePembayaran as $metode => $count)
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full" style="background: {{ $metode == 'COD' ? '#E17D19' : '#96C84B' }}"></span>
                        {{ $metode }} ({{ $count }})
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Top Selling Menu --}}
    <div class="bg-white rounded-3xl p-6 shadow-card border border-gray-100">
        <h3 class="font-black text-gray-800 text-lg mb-6 flex items-center gap-2">
            <i data-lucide="trophy" class="w-5 h-5 text-accent-yellow"></i>
            Menu Terlaris
        </h3>
        @if($menuTerlaris->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">#</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Produk</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Terjual</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($menuTerlaris as $index => $menu)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4">
                            @if($index == 0)
                            <span class="text-lg">🥇</span>
                            @elseif($index == 1)
                            <span class="text-lg">🥈</span>
                            @elseif($index == 2)
                            <span class="text-lg">🥉</span>
                            @else
                            <span class="text-sm font-bold text-gray-400">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                                    @if($menu->foto)
                                    <img src="{{ asset('storage/'.$menu->foto) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center bg-primary-light text-primary font-bold">
                                        {{ substr($menu->nama_jus, 0, 1) }}
                                    </div>
                                    @endif
                                </div>
                                <span class="font-bold text-gray-900">{{ $menu->nama_jus }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-700">{{ $menu->detail_pesanan_sum_jumlah ?? 0 }} porsi</td>
                        <td class="px-6 py-4 font-extrabold text-primary">Rp {{ number_format($menu->detail_pesanan_sum_subtotal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-8 text-center text-gray-400 font-medium">Belum ada data penjualan pada periode ini.</div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');

    const dailyData = {!! json_encode($dailyRevenue->pluck('revenue')) !!};
    const dailyLabels = {!! json_encode($dailyRevenue->pluck('tanggal_pesan')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!};
    const activeFilter = '{{ $filter }}';

    // Upper bounds: daily=5jt, weekly=50jt, monthly=500jt, yearly=5M
    const UPPER_BOUNDS = {
        'hari-ini': 5000000,
        'minggu-ini': 50000000,
        'bulan-ini': 500000000,
        'tahun-ini': 5000000000,
    };

    const chartMax = UPPER_BOUNDS[activeFilter] || 5000000;

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: dailyData,
                borderColor: '#E17D19',
                backgroundColor: 'rgba(225, 125, 25, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#E17D19',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1A1820',
                    titleFont: { family: 'Nunito', weight: 'bold', size: 12 },
                    bodyFont: { family: 'Nunito', size: 12 },
                    padding: 12,
                    cornerRadius: 12,
                    callbacks: {
                        label: function(ctx) {
                            return 'Rp ' + ctx.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: chartMax,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { family: 'Nunito', weight: 'bold', size: 11 },
                        color: '#9B97A8',
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return 'Rp ' + (value/1000) + 'rb';
                            return 'Rp ' + value;
                        },
                        stepSize: chartMax / 5,
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Nunito', weight: 'bold', size: 11 },
                        color: '#9B97A8',
                        maxTicksLimit: 15,
                    }
                }
            }
        }
    });

    // Order Type Doughnut
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pick-up', 'Delivery'],
            datasets: [{
                data: [{{ $tipePesanan[1] ?? 0 }}, {{ $tipePesanan[2] ?? 0 }}],
                backgroundColor: ['#194B96', '#7D4B96'],
                borderWidth: 0,
                spacing: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

    // Payment Method Doughnut
    const payCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(payCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($metodePembayaran->keys()) !!},
            datasets: [{
                data: {!! json_encode($metodePembayaran->values()) !!},
                backgroundColor: ['#E17D19', '#96C84B', '#194B96', '#E14B7D'],
                borderWidth: 0,
                spacing: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection
