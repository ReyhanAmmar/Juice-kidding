@extends('layouts.app-admin')

@section('title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')
@section('page-subtitle', 'Formulir data kategori menu produk')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 p-6 sm:p-8">
        
        <form action="{{ isset($kategori) ? route('admin.kategori.update', $kategori->id_kategori) : route('admin.kategori.store') }}" method="POST">
            @csrf
            @if(isset($kategori))
                @method('PUT')
            @endif

            <div class="space-y-6">
                {{-- Nama Kategori --}}
                <div>
                    <label for="nama_kategori" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" 
                           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" 
                           placeholder="Misal: Smoothies, Booster"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('nama_kategori') border-red-500 @enderror">
                    @error('nama_kategori')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Kategori</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="1" class="w-4 h-4 text-primary focus:ring-primary"
                                   {{ old('is_active', $kategori->is_active ?? '1') == '1' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="w-4 h-4 text-primary focus:ring-primary"
                                   {{ old('is_active', $kategori->is_active ?? '1') == '0' ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Nonaktif</span>
                        </label>
                    </div>
                    @error('is_active')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.kategori.index') }}" class="px-5 py-2.5 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 font-bold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Kategori
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
