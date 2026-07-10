@extends('layouts.main', ['hideHeader' => true, 'hideMinimalHeader' => true, 'hideFooter' => true])

@section('title', 'Stok Menu - Juice Kidding')

@section('content')
@include('mitra.partials.dapur-header')

<main class="w-full pt-14 pb-10 bg-[#F8F7FC] min-h-screen">
    <div class="max-w-[900px] mx-auto px-4 md:px-8">

        {{-- Page Header --}}
        <div class="pt-8 pb-6 mb-8 border-b border-[#E8E6F0]">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-[#1A1820] font-['Nunito']">Stok Menu</h1>
                    <p class="text-[#9B97A8] text-sm font-medium mt-1">Kelola ketersediaan dan jumlah stok menu</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-[#6E9A2A] bg-[#EEF7D8] px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#6E9A2A]"></span>
                        {{ $menus->where('id_status_stok', 1)->count() }} tersedia
                    </span>
                    <span class="flex items-center gap-1.5 text-[11px] font-bold text-[#E11919] bg-[#E11919]/10 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#E11919]"></span>
                        {{ $menus->where('id_status_stok', 2)->count() }} habis
                    </span>
                </div>
            </div>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-[#EEF7D8] border border-[#96C84B]/30 text-[#6E9A2A] rounded-xl flex items-center gap-3 alert-auto" role="alert">
            <i data-lucide="check-circle-2" class="w-5 h-5" aria-hidden="true"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Menu Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($menus as $m)
                <div class="bg-white rounded-xl shadow-[0_1px_4px_0_rgba(0,0,0,0.05)] border border-[#E8E6F0] overflow-hidden group hover:shadow-[0_4px_16px_0_rgba(0,0,0,0.08)] transition-shadow">
                    {{-- Image --}}
                    <div class="h-28 bg-[#F8F7FC] relative overflow-hidden">
                        @if($m->foto)
                            <img src="{{ asset('storage/'.$m->foto) }}" alt="{{ $m->nama_jus }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FDF3E7] to-[#FDF3E7]">
                                <span class="text-[#E17D19] text-2xl font-black">{{ substr($m->nama_jus, 0, 1) }}</span>
                            </div>
                        @endif
                        {{-- Badge --}}
                        <div class="absolute top-3 right-3">
                            @if($m->id_status_stok == 1)
                                <span class="bg-[#96C84B] text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                    <i data-lucide="check-circle" class="w-3 h-3" aria-hidden="true"></i> Tersedia
                                </span>
                            @else
                                <span class="bg-[#E11919] text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                    <i data-lucide="x-circle" class="w-3 h-3" aria-hidden="true"></i> Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="text-sm font-bold text-[#1A1820] font-['Nunito']">{{ $m->nama_jus }}</h3>
                                <p class="text-[11px] font-bold text-[#E17D19] mt-0.5">Rp {{ number_format($m->harga, 0, ',', '.') }}</p>
                            </div>
                            @if($m->kategori)
                                <span class="text-[10px] font-bold text-[#9B97A8] bg-[#F8F7FC] px-2 py-0.5 rounded-full">{{ $m->kategori->nama_kategori }}</span>
                            @endif
                        </div>

                        {{-- Stok Form --}}
                        <form action="{{ route('dapur.stok.update', $m->id_menu) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <div class="flex-1 flex items-center gap-2 bg-[#F8F7FC] rounded-lg px-3 py-1.5 border border-[#E8E6F0]">
                                <i data-lucide="package" class="w-3.5 h-3.5 text-[#9B97A8]" aria-hidden="true"></i>
                                <input type="number" name="stok" value="{{ $m->stok ?? 0 }}" min="0"
                                       class="w-full bg-transparent text-sm font-bold text-[#1A1820] outline-none font-['Nunito']"
                                       aria-label="Jumlah stok {{ $m->nama_jus }}">
                            </div>
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg text-xs font-bold font-['Nunito'] transition-all active:scale-95 cursor-pointer
                                    {{ $m->id_status_stok == 1 ? 'bg-[#E11919]/10 text-[#E11919] hover:bg-[#E11919]/20' : 'bg-[#EEF7D8] text-[#6E9A2A] hover:bg-[#EEF7D8]' }}">
                                {{ $m->id_status_stok == 1 ? 'Habis' : 'Simpan' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    // Auto-dismiss alerts
    document.querySelectorAll('.alert-auto').forEach(el => {
        setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 4000);
    });
});
</script>
@endsection