@extends('layouts.app-admin')

@section('title', 'Kelola Menu Jus')
@section('page-title', 'Menu Jus')
@section('page-subtitle', 'Manajemen daftar produk minuman Anda')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline font-bold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="relative w-full sm:w-72">
            <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" placeholder="Cari menu jus..." class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
        </div>
        <a href="{{ route('admin.menu.create') }}" class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all w-full sm:w-auto justify-center">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Menu
        </a>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-bold w-20">Foto</th>
                        <th class="px-6 py-4 font-bold">Detail Menu</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold">Harga</th>
                        <th class="px-6 py-4 font-bold">Stok</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($menus as $m)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex items-center justify-center">
                                @if($m->foto)
                                    <img src="{{ asset('storage/'.$m->foto) }}" alt="{{ $m->nama_jus }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-700">{{ $m->nama_jus }}</p>
                            <p class="text-xs text-gray-400 font-medium">{{ Str::limit($m->deskripsi, 40) }}</p>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-500">
                            {{ $m->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-black text-primary">
                            Rp {{ number_format($m->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($m->id_status_stok == 1)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200">Habis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.menu.edit', $m->id_menu) }}" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 inline-flex items-center justify-center transition-colors">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.menu.destroy', $m->id_menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 inline-flex items-center justify-center transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada menu jus yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($menus->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $menus->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
