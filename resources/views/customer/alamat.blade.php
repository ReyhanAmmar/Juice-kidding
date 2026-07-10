@extends('layouts.main')

@section('title', 'Kelola Alamat - Juice Kidding')

@section('content')
<main class="w-full pt-32 pb-24 bg-gray-50 min-h-screen">
    <div class="max-w-[800px] mx-auto px-4 md:px-8">
        
        <div class="mb-8">
            <a href="{{ route('customer.profil') }}" class="inline-flex items-center gap-2 text-zinc-500 hover:text-amber-600 font-medium text-sm mb-4 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Profil
            </a>
            <h1 class="text-3xl font-black text-zinc-900 font-['Nunito']">Alamat Pengiriman</h1>
            <p class="text-zinc-500 font-medium mt-2">Kelola alamat pengiriman Anda untuk pesanan delivery.</p>
        </div>

        {{-- Success Toast --}}
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 animate-fade-in-up">
            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
            </div>
            <span class="text-sm font-bold text-green-700">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Existing Addresses --}}
        @if($alamats->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($alamats as $alamat)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-zinc-100 flex items-start justify-between gap-4 hover:shadow-md transition-shadow">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-zinc-900">{{ $alamat->label }}</span>
                        @if($alamat->is_utama)
                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold uppercase rounded">Utama</span>
                        @endif
                    </div>
                    <p class="text-sm text-zinc-500 leading-relaxed">{{ $alamat->alamat_lengkap }}</p>
                    <p class="text-xs text-zinc-500 mt-1 font-mono">{{ $alamat->latitude }}, {{ $alamat->longitude }}</p>
                </div>
                <form action="{{ route('customer.alamat.hapus', $alamat->id_alamat) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-100 text-red-500 flex items-center justify-center transition-all">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-zinc-100 text-center mb-8">
            <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="map-pin" class="w-8 h-8 text-amber-400"></i>
            </div>
            <p class="text-zinc-500 font-medium">Anda belum memiliki alamat tersimpan.</p>
        </div>
        @endif

        {{-- Add New Address Form --}}
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-zinc-100">
            <h3 class="text-xl font-bold text-zinc-900 font-['Nunito'] mb-6 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5 text-amber-600"></i> Tambah Alamat Baru
            </h3>

            <form action="{{ route('customer.alamat.simpan') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-zinc-700 mb-1.5">Label Alamat</label>
                    <input type="text" name="label" value="{{ old('label') }}" placeholder="Contoh: Rumah, Kantor, Kos"
                        class="w-full border-2 border-zinc-200 rounded-xl px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all bg-white"
                        required>
                    @error('label') <p class="text-xs font-semibold text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-zinc-700 mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" placeholder="Jl. Merdeka No. 10, RT 01/RW 02, Kel. Cideng, Kec. Gambir, Jakarta Pusat"
                        class="w-full border-2 border-zinc-200 rounded-xl px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all bg-white resize-none"
                        required>{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap') <p class="text-xs font-semibold text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-1.5">Latitude</label>
                        <input type="number" step="any" name="latitude" value="{{ old('latitude', '-6.200000') }}" placeholder="-6.200000"
                            class="w-full border-2 border-zinc-200 rounded-xl px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all bg-white"
                            required>
                        @error('latitude') <p class="text-xs font-semibold text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-zinc-700 mb-1.5">Longitude</label>
                        <input type="number" step="any" name="longitude" value="{{ old('longitude', '106.816666') }}" placeholder="106.816666"
                            class="w-full border-2 border-zinc-200 rounded-xl px-4 py-3 text-sm font-medium text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/15 transition-all bg-white"
                            required>
                        @error('longitude') <p class="text-xs font-semibold text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_utama" value="1" id="is_utama" class="w-4 h-4 accent-amber-500">
                    <label for="is_utama" class="text-sm font-medium text-zinc-700">Jadikan alamat utama</label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-2xl transition-all shadow-[0_4px_16px_rgba(245,158,11,0.35)] active:scale-[0.98]">
                    Simpan Alamat
                </button>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
