@extends('layouts.app-admin')

@section('title', 'Kelola Opsi Kustomisasi')
@section('page-title', 'Opsi Kustomisasi')
@section('page-subtitle', 'Kelola detail opsi seperti Boba, Less Sugar, Large, dll.')

@section('content')
<div class="animate-fade-in-up">
    {{-- Header with Create Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Daftar Opsi Kustomisasi</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Kelola opsi detail untuk setiap tipe (Topping, Ukuran, Gula, dll.)</p>
        </div>
        <a href="{{ route('admin.opsi-kustomisasi.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-bold rounded-xl
                  hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 shadow-btn
                  w-full sm:w-auto justify-center">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Opsi
        </a>
    </div>

    {{-- Filter Tipe Opsi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-card p-4 mb-6">
        <form method="GET" action="{{ route('admin.opsi-kustomisasi.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <i data-lucide="filter" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
                <span class="text-sm font-bold text-gray-700">Filter:</span>
            </div>
            <div class="flex-1 w-full sm:w-auto sm:min-w-[250px]">
                <select name="tipe_opsi" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 bg-white
                               focus:border-primary focus:ring-2 focus:ring-primary/20
                               text-gray-900 font-medium text-sm transition-all">
                    <option value="">-- Semua Tipe Opsi --</option>
                    @foreach($tipeOpsiList as $tipe)
                    <option value="{{ $tipe->id_tipe_opsi }}" {{ request('tipe_opsi') == $tipe->id_tipe_opsi ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }}
                    </option>
                    @endforeach
                </select>
            </div>
            @if(request('tipe_opsi'))
            <a href="{{ route('admin.opsi-kustomisasi.index') }}"
               class="text-sm font-bold text-red-500 hover:text-red-700 hover:underline transition-all whitespace-nowrap">
                <i data-lucide="x" class="w-4 h-4 inline"></i> Hapus Filter
            </a>
            @endif
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        {{-- Table Header --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">No</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Opsi</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Tipe Opsi</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Harga Tambahan</th>
                        <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($opsiKustomisasi as $opsi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="reorderOpsi({{ $opsi->id_opsi }}, 'up')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Naikkan">
                                    <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="w-6 text-center text-xs font-black text-gray-400">{{ ($opsiKustomisasi->currentPage() - 1) * $opsiKustomisasi->perPage() + $loop->iteration }}</span>
                                <button onclick="reorderOpsi({{ $opsi->id_opsi }}, 'down')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Turunkan">
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $opsi->nama_opsi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($opsi->tipe_opsi)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                             bg-primary-light text-primary">
                                    {{ $opsi->tipe_opsi->nama_tipe }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm italic">Tidak ada tipe</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($opsi->harga_tambahan > 0)
                                <span class="font-bold text-primary">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                            @else
                                <span class="font-medium text-gray-500">Gratis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($opsi->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-light text-green">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.opsi-kustomisasi.edit', $opsi) }}"
                                   class="w-9 h-9 rounded-xl bg-primary-light text-primary flex items-center justify-center
                                          hover:bg-primary active:scale-95 transition-all"
                                   title="Edit">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.opsi-kustomisasi.destroy', $opsi) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus opsi ini?')"
                                            class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center
                                                   hover:bg-red-100 active:scale-95 transition-all"
                                            title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="package" class="w-7 h-7 text-gray-400"></i>
                                </div>
                                <h3 class="font-bold text-gray-700">Belum Ada Opsi Kustomisasi</h3>
                                <p class="text-sm text-gray-500 max-w-xs text-center">Tambahkan opsi pertama untuk memulai kustomisasi menu</p>
                                <a href="{{ route('admin.opsi-kustomisasi.create') }}"
                                   class="mt-2 px-5 py-2.5 bg-primary text-white font-bold rounded-xl
                                          hover:bg-primary-dark active:scale-[0.98] transition-all shadow-btn">
                                    <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i>
                                    Tambah Opsi Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($opsiKustomisasi->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $opsiKustomisasi->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });

    function reorderOpsi(id, arah) {
        fetch('{{ route("admin.opsi-kustomisasi.reorder") }}', {
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