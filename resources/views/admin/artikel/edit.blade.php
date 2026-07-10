@extends('layouts.app-admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')
@section('page-subtitle', 'Ubah konten atau status publikasi artikel')

@section('content')
<div class="bg-white rounded-3xl shadow-card border border-gray-100 p-6 sm:p-8">
    <form action="{{ route('admin.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold border border-red-100">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Bagian Utama --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Judul --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Judul Artikel</label>
                    <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" required class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>

                {{-- Ringkasan --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Ringkasan Singkat</label>
                    <textarea name="ringkasan" rows="3" required class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">{{ old('ringkasan', $artikel->ringkasan) }}</textarea>
                </div>

                {{-- Konten --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700">Isi Artikel</label>
                    <textarea name="konten" rows="12" required class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">{{ old('konten', $artikel->konten) }}</textarea>
                </div>
            </div>

            {{-- Sidebar Form --}}
            <div class="space-y-6">
                {{-- Status --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200">
                    <label class="text-sm font-bold text-gray-700 mb-3 block">Status Publikasi</label>
                    <select name="id_status_artikel" class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary outline-none transition-all">
                        <option value="1" {{ old('id_status_artikel', $artikel->id_status_artikel) == 1 ? 'selected' : '' }}>Publikasikan</option>
                        <option value="2" {{ old('id_status_artikel', $artikel->id_status_artikel) == 2 ? 'selected' : '' }}>Simpan sebagai Draft</option>
                    </select>
                </div>

                {{-- Kategori --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200">
                    <label class="text-sm font-bold text-gray-700 mb-3 block">Kategori</label>
                    <select name="id_kategori_artikel" required class="w-full bg-white border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-primary outline-none transition-all">
                        <option value="">Pilih Kategori...</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori_artikel }}" {{ old('id_kategori_artikel', $artikel->id_kategori_artikel) == $kategori->id_kategori_artikel ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Thumbnail --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200">
                    <label class="text-sm font-bold text-gray-700 mb-3 block">Foto/Thumbnail Baru</label>
                    
                    @if($artikel->thumbnail)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Thumbnail saat ini:</p>
                        <img src="{{ asset('uploads/artikel/' . $artikel->thumbnail) }}" alt="Thumbnail" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                    @endif
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-100 transition-colors">
                        <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 text-center">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG/PNG, Maks. 2MB.</p>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.artikel.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm text-gray-500 hover:bg-gray-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-btn transition-all active:scale-95 flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
