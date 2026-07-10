@extends('layouts.app-admin')

@section('title', 'Kelola Opsi Racik Sendiri')
@section('page-title', 'Opsi Racik Sendiri')
@section('page-subtitle', 'Kelola Cairan Base, Bahan (Buah & Sayur), dan Tambahan')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-gray-900">Daftar Opsi Racik Sendiri</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola opsi untuk fitur Racik Sendiri customer</p>
        </div>
        <a href="{{ route('admin.racik-opsi.create') }}"
           class="w-full sm:w-auto bg-primary text-white font-bold py-3 px-6 rounded-xl
                  hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 shadow-btn">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Opsi Racik
        </a>
    </div>

    {{-- Toast --}}
    @if(session('success'))
    <div id="toast-success" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
        <i data-lucide="check-circle" class="w-5 h-5"></i><span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div id="toast-error" class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
        <i data-lucide="alert-circle" class="w-5 h-5"></i><span class="font-semibold">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Group by Tipe Opsi --}}
    @foreach($tipeOpsi as $tipe)
    <div class="bg-white rounded-3xl border border-gray-100 shadow-card overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-amber-600 text-white text-sm font-black flex items-center justify-center">
                    {{ $loop->iteration }}
                </span>
                <div>
                    <h3 class="font-black text-gray-900 font-['Nunito']">{{ $tipe->nama_tipe }}</h3>
                    <span class="text-xs text-gray-500 font-medium">{{ $tipe->opsi->count() }} opsi</span>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                         {{ $tipe->wajib_pilih ? 'bg-red-50 text-red-600' : 'bg-gray-100 text-gray-500' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $tipe->wajib_pilih ? 'bg-red-500' : 'bg-gray-400' }}"></span>
                {{ $tipe->wajib_pilih ? 'Wajib' : 'Opsional' }}
                &middot;
                {{ $tipe->pilih_banyak ? 'Multi' : 'Single' }}
            </span>
        </div>

        @if($tipe->opsi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Nama Opsi</th>
                        <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Harga Tambahan</th>
                        <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-black text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($tipe->opsi as $opsi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-1">
                                <button onclick="reorderOpsi({{ $opsi->id_opsi }}, 'up')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Naikkan">
                                    <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="w-6 text-center text-xs font-black text-gray-400">{{ $opsi->urutan }}</span>
                                <button onclick="reorderOpsi({{ $opsi->id_opsi }}, 'down')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Turunkan">
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="font-bold text-gray-900">{{ $opsi->nama_opsi }}</div>
                        </td>
                        <td class="px-6 py-3">
                            @if($opsi->harga_tambahan > 0)
                                <span class="font-bold text-primary">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                            @else
                                <span class="font-medium text-gray-500">Gratis</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            @if($opsi->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.racik-opsi.edit', $opsi->id_opsi) }}"
                                   class="w-9 h-9 rounded-xl bg-primary-light text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-200 active:scale-95"
                                   title="Edit">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.racik-opsi.destroy', $opsi->id_opsi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus opsi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-200 active:scale-95"
                                            title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                <i data-lucide="package" class="w-7 h-7 text-gray-300"></i>
            </div>
            <p class="text-gray-500 font-medium">Belum ada opsi untuk {{ $tipe->nama_tipe }}</p>
            <a href="{{ route('admin.racik-opsi.create') }}" class="mt-2 inline-flex items-center gap-1 text-sm font-bold text-primary hover:underline">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
            </a>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        const toasts = document.querySelectorAll('#toast-success, #toast-error');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        });
    });

    function reorderOpsi(id, arah) {
        fetch('{{ route("admin.racik-opsi.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id, arah })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
        });
    }
</script>
@endsection