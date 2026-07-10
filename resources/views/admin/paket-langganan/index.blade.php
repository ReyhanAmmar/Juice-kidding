@extends('layouts.app-admin')

@section('title', 'Kelola Paket Langganan')
@section('page-title', 'Paket Langganan')
@section('page-subtitle', 'Manajemen paket langganan jus mingguan beserta benefitnya')

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
            <input type="text" placeholder="Cari paket..." class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
        </div>
        <a href="{{ route('admin.paket-langganan.create') }}" class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-btn flex items-center gap-2 transition-all w-full sm:w-auto justify-center active:scale-95">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Paket
        </a>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-3xl shadow-card border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4 font-bold">ID</th>
                        <th class="px-6 py-4 font-bold">Nama Paket</th>
                        <th class="px-6 py-4 font-bold">Harga</th>
                        <th class="px-6 py-4 font-bold">Jumlah Botol/Menu</th>
                        <th class="px-6 py-4 font-bold">Benefit Ongkir</th>
                        <th class="px-6 py-4 font-bold">Daftar Varian</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($pakets as $p)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-400">#{{ $p->id_paket }}</td>
                        <td class="px-6 py-4 text-gray-700 font-bold">
                            <p class="font-extrabold text-gray-800">{{ $p->nama_paket }}</p>
                            @if($p->deskripsi)
                                <p class="text-xs text-gray-400 font-normal mt-0.5 line-clamp-1 max-w-[200px]">{{ $p->deskripsi }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-[#E17D19]">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-600">{{ $p->total_pengiriman }} Botol</td>
                        <td class="px-6 py-4">
                            @if($p->gratis_ongkir)
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold border border-blue-100">Gratis Ongkir</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-zinc-50 text-zinc-500 rounded-lg text-xs font-medium border border-zinc-150">Bayar Ongkir</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->menus->count() > 0)
                                <div class="flex flex-wrap gap-1 max-w-[250px]">
                                    @foreach($p->menus as $menu)
                                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 rounded-md text-[10px] font-bold border border-amber-100">
                                            {{ $menu->nama_jus }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Semua varian</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-bold border border-gray-200">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('admin.paket-langganan.edit', $p->id_paket) }}" class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 inline-flex items-center justify-center transition-colors active:scale-90">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.paket-langganan.destroy', $p->id_paket) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket langganan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 inline-flex items-center justify-center transition-colors active:scale-90 cursor-pointer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada paket langganan yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
