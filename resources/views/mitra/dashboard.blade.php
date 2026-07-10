@extends('layouts.main', ['hideHeader' => true, 'hideMinimalHeader' => true, 'hideFooter' => true])

@section('title', 'Dashboard Dapur — Juice Kidding')

@section('head')
<style>
    .kanban-col {
        min-height: calc(100vh - 140px);
    }
    .kanban-card {
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .kanban-card:active {
        transform: scale(0.98);
    }
    @media (prefers-reduced-motion: reduce) {
        .kanban-card, .kanban-card:active { transition: none !important; transform: none !important; }
    }
</style>
@endsection

@section('content')
@include('mitra.partials.dapur-header')

<main class="w-full pt-14 bg-zinc-50 min-h-screen overflow-x-hidden">
    {{-- Top Bar --}}
    <div class="sticky top-14 z-30 bg-white/90 backdrop-blur-sm border-b border-zinc-200/60">
        <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-3 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-lg font-black text-zinc-900">Dapur</h1>
                <p class="text-[11px] text-zinc-400 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-amber-600 bg-amber-50 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $jumlahBaru + $jumlahDiproses + $jumlahSiap }} aktif
                </span>
                <span class="text-[11px] font-bold text-lime-600 bg-lime-50 px-3 py-1.5 rounded-full">
                    {{ $jumlahSelesaiHariIni }} selesai
                </span>
            </div>
        </div>
    </div>

    {{-- Kanban Board --}}
    <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start" id="kanban-board">

            {{-- COLUMN 1: Pesanan Baru --}}
            <div class="kanban-col flex flex-col" id="col-baru">
                @include('mitra.partials.dapur-column', ['orders' => $pesananBaru, 'status' => 1, 'label' => 'Pesanan Baru', 'icon' => 'bell-ring', 'color' => 'blue', 'count' => $jumlahBaru])
            </div>

            {{-- COLUMN 2: Sedang Diproses --}}
            <div class="kanban-col flex flex-col" id="col-diproses">
                @include('mitra.partials.dapur-column', ['orders' => $pesananDiproses, 'status' => 2, 'label' => 'Sedang Diproses', 'icon' => 'chef-hat', 'color' => 'amber', 'count' => $jumlahDiproses])
            </div>

            {{-- COLUMN 3: Siap Diambil --}}
            <div class="kanban-col flex flex-col" id="col-siap">
                @include('mitra.partials.dapur-column', ['orders' => $pesananSiap, 'status' => 3, 'label' => 'Siap Diambil', 'icon' => 'package-check', 'color' => 'purple', 'count' => $jumlahSiap])
            </div>

        </div>
    </div>
</main>

<div id="dapur-modal-container"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    startPolling();
});

function showDetailModal(id_pesanan) {
    fetch(`{{ url('/dapur/pesanan') }}/${id_pesanan}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('dapur-modal-container').innerHTML = data.html;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            } else {
                alert('Gagal memuat detail pesanan.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
        });
}

function closeDetailModal(id_pesanan) {
    const modal = document.getElementById(`detail-modal-${id_pesanan}`);
    if (modal) {
        modal.classList.add('hidden');
        setTimeout(() => {
            document.getElementById('dapur-modal-container').innerHTML = '';
        }, 300);
    }
}

// ===== REALTIME POLLING =====
let polling = true;

function startPolling() {
    pollDashboard();
    setInterval(pollDashboard, 10000);
}

function pollDashboard() {
    if (!polling) return;

    fetch('{{ route("dapur.dashboard.json") }}', {
        headers: { 'Accept': 'application/json' }
    })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Update counts in top bar
            const activeBadge = document.querySelector('.sticky .flex .gap-3 span:first-child');
            const doneBadge = document.querySelector('.sticky .flex .gap-3 span:last-child');
            if (activeBadge) activeBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> ${data.counts.total} aktif`;
            if (doneBadge) doneBadge.textContent = `${data.counts.selesaiHariIni} selesai`;

            // Update each column
            ['baru', 'diproses', 'siap'].forEach(col => {
                const colEl = document.getElementById(`col-${col}`);
                if (colEl && data.columns[col]) {
                    colEl.innerHTML = data.columns[col];
                }
            });

            if (typeof lucide !== 'undefined') lucide.createIcons();
        })
        .catch(err => console.error('Polling error:', err));
}
</script>
@endsection