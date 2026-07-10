@extends('layouts.app-admin')

@section('title', 'Tambah Paket Langganan')
@section('page-title', 'Tambah Paket')
@section('page-subtitle', 'Formulir pembuatan paket langganan jus mingguan baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 p-6 sm:p-8">
        
        <form action="{{ route('admin.paket-langganan.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Nama Paket --}}
                <div>
                    <label for="nama_paket" class="block text-sm font-bold text-gray-700 mb-2">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" 
                           value="{{ old('nama_paket') }}" 
                           placeholder="Misal: Starter Pack, Healthy Pack"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('nama_paket') border-red-500 @enderror">
                    @error('nama_paket')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga & Jumlah Botol --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" 
                               value="{{ old('harga') }}" 
                               placeholder="Misal: 250000"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('harga') border-red-500 @enderror">
                        @error('harga')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="total_pengiriman" class="block text-sm font-bold text-gray-700 mb-2">Jumlah Botol/Menu</label>
                        <input type="number" name="total_pengiriman" id="total_pengiriman" 
                               value="{{ old('total_pengiriman') }}" 
                               placeholder="Misal: 6"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('total_pengiriman') border-red-500 @enderror">
                        @error('total_pengiriman')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Paket</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              placeholder="Tuliskan keterangan detail paket langganan..."
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:bg-white focus:ring-1 focus:ring-primary outline-none transition-all @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Allowed Varian (Bebas Pilih Varian) --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Varian Jus yang Diizinkan (Allowed)</label>
                    <p class="text-xs text-gray-400 mb-3">Customer hanya dapat memilih menu/jus yang dicentang di bawah ini untuk paket ini.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-48 overflow-y-auto bg-gray-50 p-4 rounded-2xl border border-gray-150">
                        @foreach($menus as $menu)
                            <label class="flex items-center gap-2 cursor-pointer p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                <input type="checkbox" name="allowed_menus[]" value="{{ $menu->id_menu }}"
                                       class="rounded text-primary focus:ring-primary h-4.5 w-4.5 border-gray-300"
                                       {{ is_array(old('allowed_menus')) && in_array($menu->id_menu, old('allowed_menus')) ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-700">{{ $menu->nama_jus }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('allowed_menus')
                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Benefit & Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                    {{-- Gratis Ongkir Checkbox --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Benefit Ongkir</label>
                        <label class="inline-flex items-center gap-2.5 cursor-pointer mt-1">
                            <input type="checkbox" name="gratis_ongkir" value="1" 
                                   class="rounded text-primary focus:ring-primary h-5 w-5 border-gray-300"
                                   {{ old('gratis_ongkir', '1') == '1' ? 'checked' : '' }}>
                            <span class="text-sm font-bold text-gray-700">Gratis Ongkos Kirim</span>
                        </label>
                        @error('gratis_ongkir')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Active --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Paket</label>
                        <div class="flex items-center gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" class="w-4 h-4 text-primary focus:ring-primary"
                                       {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-700">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" class="w-4 h-4 text-primary focus:ring-primary"
                                       {{ old('is_active', '1') == '0' ? 'checked' : '' }}>
                                <span class="text-sm font-bold text-gray-700">Nonaktif</span>
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.paket-langganan.index') }}" class="px-5 py-2.5 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 font-bold text-sm transition-all">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all active:scale-95 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Paket
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
