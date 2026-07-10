@extends('layouts.app-admin')

@section('title', 'Kelola Artikel')
@section('page-title', 'Artikel')
@section('page-subtitle', 'Manajemen daftar artikel/berita di sistem')

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
            <input type="text" placeholder="Cari artikel..." class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
        </div>
        <a href="{{ route('admin.artikel.create') }}" class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all w-full sm:w-auto justify-center">
            <i data-lucide="plus" class="w-4 h-4"></i> Tulis Artikel Baru
        </a>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-bold">Judul</th>
                        <th class="px-6 py-4 font-bold">Kategori</th>
                        <th class="px-6 py-4 font-bold">Penulis</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold">Dilihat</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($artikels as $artikel)
                    <tr class="border-b border-gray-50 hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $artikel->judul }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $artikel->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $artikel->penulis->nama_lengkap ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($artikel->id_status_artikel == 1)
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-lg">Published</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-lg">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ number_format($artikel->dilihat) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium">
                            Belum ada data artikel.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($artikels->hasPages())
    <div class="mt-6">
        {{ $artikels->links() }}
    </div>
    @endif
</div>
@endsection
