@extends('layouts.app-admin')

@section('title', 'Tambah Opsi Racik Sendiri')
@section('page-title', 'Tambah Opsi Racik Sendiri')
@section('page-subtitle', 'Tambah Cairan Base, Bahan, atau Tambahan baru')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in-up">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-card p-8">
        <form action="{{ route('admin.racik-opsi.store') }}" method="POST">
            @csrf

            {{-- Tipe Opsi --}}
            <div class="mb-6">
                <label for="id_tipe_opsi" class="block text-sm font-bold text-gray-700 mb-2">Tipe Opsi <span class="text-red-500">*</span></label>
                <select name="id_tipe_opsi" id="id_tipe_opsi" required
                        class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl
                               focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                               transition-all duration-200 text-gray-900 font-medium
                               {{ $errors->has('id_tipe_opsi') ? 'border-red-500' : '' }}">
                    <option value="">-- Pilih Tipe --</option>
                    @foreach($tipeOpsi as $tipe)
                    <option value="{{ $tipe->id_tipe_opsi }}" {{ old('id_tipe_opsi') == $tipe->id_tipe_opsi ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }}
                    </option>
                    @endforeach
                </select>
                @error('id_tipe_opsi')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Opsi --}}
            <div class="mb-6">
                <label for="nama_opsi" class="block text-sm font-bold text-gray-700 mb-2">Nama Opsi <span class="text-red-500">*</span></label>
                <input type="text" id="nama_opsi" name="nama_opsi" value="{{ old('nama_opsi') }}"
                       required maxlength="100"
                       class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl
                              focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                              transition-all duration-200 text-gray-900 placeholder-gray-400
                              {{ $errors->has('nama_opsi') ? 'border-red-500' : '' }}"
                       placeholder="Contoh: Mangga Arumanis, Jahe Emprit, Air Kelapa">
                @error('nama_opsi')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Tambahan --}}
            <div class="mb-6">
                <label for="harga_tambahan" class="block text-sm font-bold text-gray-700 mb-2">Harga Tambahan (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" id="harga_tambahan" name="harga_tambahan"
                           value="{{ old('harga_tambahan', 0) }}" min="0" required
                           class="w-full pl-10 pr-4 py-3.5 border-2 border-gray-200 rounded-xl
                                  focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                                  transition-all duration-200 text-gray-900 font-bold
                                  {{ $errors->has('harga_tambahan') ? 'border-red-500' : '' }}"
                           placeholder="0">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                </div>
                <p class="mt-1 text-xs text-gray-400">Isi 0 jika gratis.</p>
                @error('harga_tambahan')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Urutan --}}
            <div class="mb-6">
                <label for="urutan" class="block text-sm font-bold text-gray-700 mb-2">Urutan Posisi</label>
                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                       class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl
                              focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20
                              transition-all duration-200 text-gray-900
                              {{ $errors->has('urutan') ? 'border-red-500' : '' }}"
                       placeholder="0">
                <p class="mt-1 text-xs text-gray-400">Urutan terkecil tampil lebih dulu.</p>
                @error('urutan')
                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 mb-8">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-5 h-5 text-primary border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/20
                              checked:bg-primary checked:border-primary transition-all cursor-pointer">
                <label for="is_active" class="text-sm font-semibold text-gray-700 cursor-pointer">
                    Aktifkan opsi ini (akan tampil di halaman Racik Sendiri)
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.racik-opsi.index') }}"
                   class="flex-1 py-3.5 px-6 bg-gray-100 text-gray-700 font-bold rounded-xl
                          hover:bg-gray-200 active:bg-gray-300 transition-all duration-200
                          text-center flex items-center justify-center gap-2">
                    <i data-lucide="x" class="w-5 h-5"></i> Batal
                </a>
                <button type="submit"
                        class="flex-1 py-3.5 px-6 bg-primary text-white font-bold rounded-xl
                               hover:bg-primary-dark active:scale-[0.98] transition-all duration-200
                               flex items-center justify-center gap-2 shadow-btn">
                    <i data-lucide="save" class="w-5 h-5"></i> Simpan Opsi
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