@extends('layouts.app-admin')

@section('title', 'Tambah Tipe Opsi')
@section('page-title', 'Tambah Tipe Opsi')
@section('page-subtitle', 'Buat kategori kustomisasi baru (contoh: Ukuran, Gula, Topping)')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in-up">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-card p-8">
        <form action="{{ route('admin.tipe-opsi.store') }}" method="POST">
            @csrf

            {{-- Nama Tipe --}}
            <div class="mb-6">
                <label for="nama_tipe" class="block text-sm font-bold text-gray-700 mb-2">Nama Tipe <span class="text-red-500">*</span></label>
                <input type="text"
                       id="nama_tipe"
                       name="nama_tipe"
                       value="{{ old('nama_tipe') }}"
                       required
                       maxlength="50"
                       class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl
                              focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                              transition-all duration-200 text-gray-900 placeholder-gray-400
                              {{ $errors->has('nama_tipe') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '' }}"
                       placeholder="Contoh: Ukuran, Tingkat Gula, Topping">
                @error('nama_tipe')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Checkboxes --}}
            <div class="space-y-4 mb-8">
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <input type="checkbox"
                           id="wajib_pilih"
                           name="wajib_pilih"
                           value="1"
                           class="w-5 h-5 text-primary border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20
                                  checked:bg-primary checked:border-primary transition-all cursor-pointer">
                    <label for="wajib_pilih" class="text-sm font-semibold text-gray-700 cursor-pointer">
                        Wajib Dipilih
                    </label>
                    <span class="text-xs text-gray-400 ml-auto">Customer harus memilih minimal 1 opsi</span>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <input type="checkbox"
                           id="pilih_banyak"
                           name="pilih_banyak"
                           value="1"
                           class="w-5 h-5 text-primary border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20
                                  checked:bg-primary checked:border-primary transition-all cursor-pointer">
                    <label for="pilih_banyak" class="text-sm font-semibold text-gray-700 cursor-pointer">
                        Bisa Memilih Banyak (Multi-select)
                    </label>
                    <span class="text-xs text-gray-400 ml-auto">Checkbox (contoh: Topping). Uncheck = Radio (contoh: Ukuran)</span>
                </div>
            </div>

            {{-- Urutan --}}
            <div class="mb-6">
                <label for="urutan" class="block text-sm font-bold text-gray-700 mb-2">Urutan Posisi</label>
                <input type="number"
                       id="urutan"
                       name="urutan"
                       value="{{ old('urutan', 0) }}"
                       min="0"
                       class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl
                              focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                              transition-all duration-200 text-gray-900 placeholder-gray-400
                              {{ $errors->has('urutan') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '' }}"
                       placeholder="0">
                <p class="mt-1 text-xs text-gray-400">Urutan terkecil akan tampil lebih dulu di halaman customer.</p>
                @error('urutan')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.tipe-opsi.index') }}"
                   class="flex-1 py-3.5 px-6 bg-gray-100 text-gray-700 font-bold rounded-xl
                          hover:bg-gray-200 active:bg-gray-300 transition-all duration-200
                          text-center flex items-center justify-center gap-2">
                    <i data-lucide="x" class="w-5 h-5"></i>
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 py-3.5 px-6 bg-primary text-white font-bold rounded-xl
                               hover:bg-primary-dark active:scale-[0.98] transition-all duration-200
                               flex items-center justify-center gap-2 shadow-btn">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Simpan Tipe Opsi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection