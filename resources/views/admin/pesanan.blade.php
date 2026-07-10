@extends('layouts.app-admin')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Kelola Transaksi')
@section('page-subtitle', 'Pantau dan kelola pesanan yang masuk')

@section('content')
<div class="space-y-6">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-3xl p-5 shadow-card border border-gray-100">
        <form method="GET" action="{{ route('admin.pesanan') }}" class="flex flex-wrap items-end gap-4">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-widest">Cari Pesanan</label>
                <div class="flex items-center bg-gray-50 rounded-xl px-3 py-2.5 gap-2 border-2 border-transparent focus-within:border-primary focus-within:bg-white transition-all">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode pesanan atau nama pelanggan..."
                        class="bg-transparent text-sm font-medium text-gray-700 outline-none placeholder-gray-300 w-full">
                </div>
            </div>
            {{-- Status Filter --}}
            <div class="w-40">
                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-widest">Status</label>
                <select name="status" class="w-full bg-gray-50 border-2 border-transparent rounded-xl px-3 py-2.5 text-sm font-medium text-gray-700 focus:border-primary focus:bg-white outline-none transition-all">
                    <option value="">Semua</option>
                    @foreach($statusMap as $id => $s)
                    <option value="{{ $id }}" {{ request('status') == $id ? 'selected' : '' }}>{{ $s['label'] }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Tipe Filter --}}
            <div class="w-36">
                <label class="block text-xs font-bold text-gray-400 mb-1.5 uppercase tracking-widest">Tipe</label>
                <select name="tipe" class="w-full bg-gray-50 border-2 border-transparent rounded-xl px-3 py-2.5 text-sm font-medium text-gray-700 focus:border-primary focus:bg-white outline-none transition-all">
                    <option value="">Semua</option>
                    <option value="1" {{ request('tipe') == '1' ? 'selected' : '' }}>Pick-up</option>
                    <option value="2" {{ request('tipe') == '2' ? 'selected' : '' }}>Delivery</option>
                </select>
            </div>
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-btn transition-all active:scale-95">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'tipe']))
            <a href="{{ route('admin.pesanan') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 px-3 py-2.5 transition-colors">Reset</a>
            @endif
        </form>
    </div>

    {{-- Status Summary Badges --}}
    <div class="flex flex-wrap gap-2">
        @php
            $badgeColors = [
                1 => 'bg-blue-100 text-blue-700', 2 => 'bg-yellow-100 text-yellow-700',
                3 => 'bg-purple-100 text-purple-700', 4 => 'bg-orange-100 text-orange-700',
                5 => 'bg-cyan-100 text-cyan-700', 6 => 'bg-green-100 text-green-700',
                7 => 'bg-red-100 text-red-700',
            ];
        @endphp
        @foreach($statusMap as $id => $s)
        <a href="{{ route('admin.pesanan', ['status' => $id]) }}"
           class="inline-flex items-center gap-1.5 text-[11px] font-bold px-3 py-1.5 rounded-full transition-all hover:opacity-80
                  {{ request('status') == $id ? 'ring-2 ring-offset-1 ring-gray-300' : '' }}
                  {{ $badgeColors[$id] ?? 'bg-gray-100 text-gray-700' }}">
            {{ $s['label'] }}
            <span class="bg-white/60 px-1.5 py-0.5 rounded-full text-[10px]">{{ $statusCounts[$id] ?? 0 }}</span>
        </a>
        @endforeach
    </div>

    {{-- Success Toast --}}
    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 animate-fade-in-up">
        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
        </div>
        <span class="text-sm font-bold text-green-700">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Orders Table --}}
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Pesanan</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Pelanggan</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Tipe</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="text-right px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pesanans as $pesanan)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-bold text-gray-900">#{{ $pesanan->kode_pesanan }}</span>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $pesanan->detail_pesanan->count() }} item</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-700">{{ $pesanan->customer->nama_lengkap ?? 'Guest' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($pesanan->id_tipe_pesanan == 2)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full">
                                <i data-lucide="truck" class="w-3 h-3"></i> Delivery
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">
                                <i data-lucide="store" class="w-3 h-3"></i> Pick-up
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-extrabold text-primary">
                            Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @php $bc = $badgeColors[$pesanan->id_status_pesanan] ?? 'bg-gray-100 text-gray-700'; @endphp
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold {{ $bc }} px-2.5 py-1 rounded-full">
                                ● {{ $statusMap[$pesanan->id_status_pesanan]['label'] ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-medium text-xs">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- Quick status actions --}}
                                @if($pesanan->id_status_pesanan == 1)
                                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="2">
                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-primary hover:bg-primary-dark text-white text-[11px] font-bold transition-all active:scale-95" title="Konfirmasi & Proses">
                                        <i data-lucide="chef-hat" class="w-3 h-3 inline"></i> Proses
                                    </button>
                                </form>
                                @elseif($pesanan->id_status_pesanan == 2)
                                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="3">
                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-secondary hover:bg-secondary-dark text-white text-[11px] font-bold transition-all active:scale-95" title="Tandai Siap">
                                        <i data-lucide="check" class="w-3 h-3 inline"></i> Siap
                                    </button>
                                </form>
                                @elseif($pesanan->id_status_pesanan == 3 && $pesanan->id_tipe_pesanan == 2)
                                {{-- Assign driver --}}
                                <button onclick="openDriverModal({{ $pesanan->id_pesanan }})" class="px-2.5 py-1.5 rounded-lg bg-accent-blue hover:opacity-90 text-white text-[11px] font-bold transition-all active:scale-95" title="Tugaskan Driver">
                                    <i data-lucide="truck" class="w-3 h-3 inline"></i> Driver
                                </button>
                                @elseif($pesanan->id_status_pesanan == 3 && $pesanan->id_tipe_pesanan == 1)
                                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="6">
                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-secondary hover:bg-secondary-dark text-white text-[11px] font-bold transition-all active:scale-95" title="Selesai (Pick-up)">
                                        <i data-lucide="check-circle" class="w-3 h-3 inline"></i> Selesai
                                    </button>
                                </form>
                                @elseif($pesanan->id_status_pesanan == 5)
                                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="6">
                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-secondary hover:bg-secondary-dark text-white text-[11px] font-bold transition-all active:scale-95" title="Selesai">
                                        <i data-lucide="check-circle" class="w-3 h-3 inline"></i> Selesai
                                    </button>
                                </form>
                                @endif

                                {{-- Cancel button (only for active orders) --}}
                                @if(in_array($pesanan->id_status_pesanan, [1, 2]))
                                <form method="POST" action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" class="inline"
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="7">
                                    <input type="hidden" name="catatan" value="Dibatalkan oleh admin">
                                    <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-red-400 hover:text-accent-red transition-all" title="Batalkan">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400 font-medium">
                            <div class="flex flex-col items-center gap-2">
                                <i data-lucide="inbox" class="w-10 h-10 text-gray-200"></i>
                                Belum ada pesanan yang sesuai filter.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pesanans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $pesanans->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Driver Assignment Modal --}}
<div id="driver-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 hidden">
    <div class="bg-white rounded-3xl shadow-card-lg w-full max-w-sm p-6 animate-scale-in">
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mx-auto">
            <i data-lucide="truck" class="w-7 h-7 text-accent-blue"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 text-center mt-4">Tugaskan Driver</h3>
        <p class="text-sm font-medium text-gray-500 text-center mt-2">Pilih driver untuk mengantar pesanan ini.</p>
        
        <form id="driver-form" method="POST" action="">
            @csrf @method('PUT')
            <div class="mt-5 space-y-2">
                @foreach($drivers as $driver)
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 hover:border-primary cursor-pointer transition-all">
                    <input type="radio" name="id_driver" value="{{ $driver->id_user }}" class="accent-primary" required>
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold text-sm flex items-center justify-center">
                        {{ substr($driver->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <span class="text-sm font-bold text-gray-900">{{ $driver->nama_lengkap }}</span>
                        <span class="text-xs text-gray-400 block">{{ $driver->no_hp }}</span>
                    </div>
                </label>
                @endforeach
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeDriverModal()" class="flex-1 border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-2xl hover:bg-gray-50 text-sm transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-accent-blue hover:opacity-90 text-white font-bold py-3 rounded-2xl text-sm transition-all active:scale-95">
                    Tugaskan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openDriverModal(pesananId) {
    const modal = document.getElementById('driver-modal');
    const form = document.getElementById('driver-form');
    form.action = `{{ url('admin/pesanan') }}/${pesananId}/assign-driver`;
    modal.classList.remove('hidden');
}

function closeDriverModal() {
    document.getElementById('driver-modal').classList.add('hidden');
}

// Close modal on backdrop click
document.getElementById('driver-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDriverModal();
});
</script>
@endsection
