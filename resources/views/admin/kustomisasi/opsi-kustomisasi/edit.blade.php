@extends('layouts.app-admin')

@section('title', 'Edit Opsi Kustomisasi')
@section('page-title', 'Opsi Kustomisasi')
@section('page-subtitle', 'Perbarui data opsi kustomisasi')

@section('content')
<div class="animate-fade-in-up max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-card border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h2 class="text-lg font-black text-gray-900 flex items-center gap-2">
                <i data-lucide="edit-2" class="w-5 h-5 text-primary"></i>
                Form Edit Opsi Kustomisasi
            </h2>
        </div>

        <form action="{{ route('admin.opsi-kustomisasi.update', $opsiKustomisasi) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Tipe Opsi --}}
            <div>
                <label for="id_tipe_opsi" class="block text-sm font-bold text-gray-700 mb-2">Tipe Opsi <span class="text-red-500">*</span></label>
                <select name="id_tipe_opsi" id="id_tipe_opsi"
                        class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white
                               focus:border-primary focus:ring-2 focus:ring-primary-light
                               text-gray-900 font-medium transition-all"
                        required>
                    <option value="">-- Pilih Tipe Opsi --</option>
                    @foreach($tipeOpsi as $tipe)
                    <option value="{{ $tipe->id_tipe_opsi }}" {{ old('id_tipe_opsi', $opsiKustomisasi->id_tipe_opsi) == $tipe->id_tipe_opsi ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }} ({{ $tipe->pilih_banyak ? 'Multi-select' : 'Single-select' }})
                    </option>
                    @endforeach
                </select>
                @error('id_tipe_opsi')
                <p class="mt-1.5 text-sm font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Opsi --}}
            <div>
                <label for="nama_opsi" class="block text-sm font-bold text-gray-700 mb-2">Nama Opsi <span class="text-red-500">*</span></label>
                <input type="text" name="nama_opsi" id="nama_opsi"
                       value="{{ old('nama_opsi', $opsiKustomisasi->nama_opsi) }}"
                       placeholder="Contoh: Boba, Less Sugar, Large, Extra Ice"
                       class="w-full px-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white
                              focus:border-primary focus:ring-2 focus:ring-primary-light
                              text-gray-900 font-medium transition-all"
                       required maxlength="100">
                @error('nama_opsi')
                <p class="mt-1.5 text-sm font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga Tambahan --}}
            <div>
                <label for="harga_tambahan" class="block text-sm font-bold text-gray-700 mb-2">Harga Tambahan (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" name="harga_tambahan" id="harga_tambahan"
                           value="{{ old('harga_tambahan', $opsiKustomisasi->harga_tambahan) }}"
                           min="0"
                           placeholder="0"
                           class="w-full pl-10 pr-4 py-3.5 rounded-xl border-2 border-gray-200 bg-white
                                  focus:border-primary focus:ring-2 focus:ring-primary-light
                                  text-gray-900 font-bold transition-all"
                           required>
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-lg">Rp</span>
                </div>
                <p class="mt-1.5 text-xs text-gray-500">Isi 0 jika opsi ini gratis (tanpa biaya tambahan)</p>
                @error('harga_tambahan')
                <p class="mt-1.5 text-sm font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <input type="checkbox" name="is_active" id="is_active"
                       value="1" {{ old('is_active', $opsiKustomisasi->is_active) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-2 border-gray-300 text-primary
                              focus:ring-2 focus:ring-primary-light
                              checked:bg-primary checked:border-primary
                              transition-all cursor-pointer">
                <label for="is_active" class="font-bold text-gray-900 cursor-pointer">Aktifkan opsi ini (akan tampil di halaman customer)</label>
            </div>

            {{-- Urutan --}}
            <div>
                <label for="urutan" class="block text-sm font-bold text-gray-700 mb-2">Urutan Posisi</label>
                <input type="number" name="urutan" id="urutan"
                       value="{{ old('urutan', $opsiKustomisasi->urutan) }}"
                       min="0"
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-white
                              focus:border-primary focus:ring-2 focus:ring-primary-light
                              text-gray-900 font-bold transition-all"
                       placeholder="0">
                <p class="mt-1 text-xs text-gray-400">Urutan terkecil akan tampil lebih dulu di halaman customer.</p>
                @error('urutan')
                <p class="mt-1.5 text-sm font-medium text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.opsi-kustomisasi.index') }}"
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
                    Update Opsi
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

        // Auto-format harga input
        const hargaInput = document.getElementById('harga_tambahan');
        hargaInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseInt(this.value.replace(/[^\d]/g, '')) || 0;
            }
        });
    });
</script>
@endsection