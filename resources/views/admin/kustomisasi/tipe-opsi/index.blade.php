@extends('layouts.app-admin')

@section('title', 'Kelola Tipe Opsi')
@section('page-title', 'Kelola Tipe Opsi')
@section('page-subtitle', 'Kelola kategori kustomisasi seperti Ukuran, Tingkat Gula, Topping, dll.')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    {{-- Header with Create Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-gray-900">Daftar Tipe Opsi</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola kategori kustomisasi menu jus</p>
        </div>
        <a href="{{ route('admin.tipe-opsi.create') }}"
           class="w-full sm:w-auto bg-primary text-white font-bold py-3 px-6 rounded-xl
                  hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 shadow-btn">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Tipe Opsi
        </a>
    </div>

    {{-- Toast Message --}}
    @if(session('success'))
    <div id="toast-success" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div id="toast-error" class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        <span class="font-semibold">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-card overflow-hidden">
        @if($tipeOpsi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Nama Tipe</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Wajib Pilih</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Bisa Multi-Pilih</th>
                        <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase tracking-wider">Jumlah Opsi</th>
                        <th class="px-6 py-4 text-right text-xs font-black text-gray-500 uppercase tracking-wider pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($tipeOpsi as $tipe)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="reorderTipeOpsi({{ $tipe->id_tipe_opsi }}, 'up')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Naikkan">
                                    <i data-lucide="chevron-up" class="w-3.5 h-3.5"></i>
                                </button>
                                <span class="w-6 text-center text-xs font-black text-gray-400">{{ ($tipeOpsi->currentPage() - 1) * $tipeOpsi->perPage() + $loop->iteration }}</span>
                                <button onclick="reorderTipeOpsi({{ $tipe->id_tipe_opsi }}, 'down')"
                                        class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-100 hover:text-amber-700 transition-all active:scale-95 flex items-center justify-center cursor-pointer"
                                        title="Turunkan">
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $tipe->nama_tipe }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($tipe->wajib_pilih)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600">
                                <i data-lucide="check" class="w-3 h-3 mr-1"></i> Ya
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                <i data-lucide="x" class="w-3 h-3 mr-1"></i> Tidak
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($tipe->pilih_banyak)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600">
                                <i data-lucide="check" class="w-3 h-3 mr-1"></i> Ya
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                                <i data-lucide="x" class="w-3 h-3 mr-1"></i> Tidak
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-primary-light text-primary">
                                {{ $tipe->opsi_count }} opsi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.tipe-opsi.edit', $tipe) }}"
                                   class="w-9 h-9 rounded-xl bg-primary-light text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-200 active:scale-95"
                                   title="Edit">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.tipe-opsi.destroy', $tipe) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tipe opsi ini?')">
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

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $tipeOpsi->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="layers" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Tipe Opsi</h3>
            <p class="text-gray-500 mb-6">Mulai dengan menambahkan tipe opsi kustomisasi pertama Anda</p>
            <a href="{{ route('admin.tipe-opsi.create') }}"
               class="inline-flex items-center gap-2 bg-primary text-white font-bold py-3 px-6 rounded-xl hover:bg-primary-dark active:scale-[0.98] transition-all duration-200 shadow-btn">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Tambah Tipe Opsi
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        // Auto-hide toast
        const toasts = document.querySelectorAll('#toast-success, #toast-error');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        });
    });

    function reorderTipeOpsi(id, arah) {
        fetch('{{ route("admin.tipe-opsi.reorder") }}', {
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