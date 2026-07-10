@extends('layouts.app-admin')

@section('title', isset($menu) ? 'Edit Menu Jus' : 'Tambah Menu Jus')
@section('page-title', isset($menu) ? 'Edit Menu Jus' : 'Tambah Menu Jus')
@section('page-subtitle', 'Lengkapi informasi produk minuman Anda')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 p-6 sm:p-8">
        
        <form action="{{ isset($menu) ? route('admin.menu.update', $menu->id_menu) : route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($menu))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Nama Jus --}}
                    <div>
                        <label for="nama_jus" class="block text-sm font-bold text-gray-700 mb-2">Nama Menu</label>
                        <input type="text" name="nama_jus" id="nama_jus" 
                               value="{{ old('nama_jus', $menu->nama_jus ?? '') }}" 
                               placeholder="Misal: Avocado Smoothie"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('nama_jus') border-red-500 @enderror">
                        @error('nama_jus')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="id_kategori" class="block text-sm font-bold text-gray-700 mb-2">Kategori Menu</label>
                        <select name="id_kategori" id="id_kategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('id_kategori') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $menu->id_kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Harga --}}
                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" min="0"
                               value="{{ old('harga', $menu->harga ?? '') }}" 
                               placeholder="Contoh: 25000"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('harga') border-red-500 @enderror">
                        @error('harga')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estimasi Kalori --}}
                    <div>
                        <label for="estimasi_kalori" class="block text-sm font-bold text-gray-700 mb-2">Estimasi Kalori (kcal)</label>
                        <input type="number" name="estimasi_kalori" id="estimasi_kalori" min="0"
                               value="{{ old('estimasi_kalori', $menu->estimasi_kalori ?? '') }}" 
                               placeholder="Opsional. Misal: 150"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all">
                        @error('estimasi_kalori')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              placeholder="Ceritakan tentang menu ini..."
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Status Stok --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Ketersediaan</label>
                        <div class="flex items-center gap-4 mt-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="id_status_stok" value="1" class="w-4 h-4 text-primary focus:ring-primary"
                                       {{ old('id_status_stok', $menu->id_status_stok ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700">Tersedia</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="id_status_stok" value="2" class="w-4 h-4 text-primary focus:ring-primary"
                                       {{ old('id_status_stok', $menu->id_status_stok ?? '1') == '2' ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700">Habis (Out of stock)</span>
                            </label>
                        </div>
                        @error('id_status_stok')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Produk</label>
                        @if(isset($menu) && $menu->foto)
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$menu->foto) }}" alt="Foto" class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="foto" id="foto" accept="image/png, image/jpeg, image/jpg"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-light file:text-primary hover:file:bg-orange-100 transition-all">
                        <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                        @error('foto')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.menu.index') }}" class="px-5 py-2.5 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 font-bold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Menu
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
