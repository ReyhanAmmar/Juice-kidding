@extends('layouts.main')

@section('content')
    {{-- ===== HERO BANNER ===== --}}
    <section class="w-full pt-[100px] pb-12 bg-gradient-to-br from-amber-100/50 to-orange-50 relative overflow-hidden">
        {{-- Decorative --}}
        <div class="size-64 absolute left-[5%] top-1/4 bg-yellow-400/20 rounded-full blur-[40px] pointer-events-none"></div>
        <div class="size-72 absolute right-[10%] bottom-0 bg-orange-400/10 rounded-full blur-[40px] pointer-events-none"></div>

        <div class="max-w-[1280px] mx-auto px-4 md:px-8 relative z-10 flex flex-col items-center text-center">
            <span class="inline-block px-3 py-1 bg-white text-amber-700 text-xs font-bold font-['Nunito'] rounded-full mb-4 tracking-wider uppercase shadow-sm">📰 Juice Journal</span>
            <h1 class="text-zinc-900 text-4xl md:text-5xl lg:text-6xl font-black font-['Nunito'] leading-tight mb-4">
                Temukan Inspirasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-600">Sehatmu!</span>
            </h1>
            <p class="text-zinc-600 text-base md:text-lg font-medium font-['Nunito'] max-w-2xl">
                Kumpulan tips gaya hidup sehat, resep rahasia racikan jus, hingga kabar terbaru dari Juice Kidding khusus untukmu.
            </p>
        </div>
    </section>

    {{-- ===== KATEGORI FILTER ===== --}}
    <section class="w-full bg-white border-b border-zinc-100 sticky top-[80px] z-40 shadow-[0px_4px_10px_rgba(0,0,0,0.02)]">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-4 flex items-center justify-between gap-4">
            {{-- Pills --}}
            <div class="flex-1 overflow-x-auto hide-scrollbar flex items-center gap-3 snap-x">
                <a href="{{ route('artikel.index') }}" class="snap-start shrink-0 px-5 py-2 {{ !request('kategori') ? 'bg-amber-800 text-white shadow-md' : 'bg-white text-zinc-600 hover:bg-zinc-50 border border-zinc-200' }} rounded-full text-sm font-bold font-['Nunito'] transition-all">
                    Semua
                </a>
                @foreach($kategoriList as $kat)
                    <a href="{{ route('artikel.index', ['kategori' => $kat->id_kategori_artikel]) }}" class="snap-start shrink-0 px-5 py-2 {{ request('kategori') == $kat->id_kategori_artikel ? 'bg-amber-800 text-white shadow-md' : 'bg-white text-zinc-600 hover:bg-zinc-50 border border-zinc-200' }} rounded-full text-sm font-bold font-['Nunito'] transition-all">
                        {{ $kat->nama_kategori }}
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <form action="{{ route('artikel.index') }}" method="GET" class="hidden md:flex relative shrink-0 w-64">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." class="w-full pl-10 pr-4 py-2 bg-zinc-50 border border-zinc-200 rounded-full text-sm font-medium font-['Nunito'] focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                <i data-lucide="search" class="w-4 h-4 text-zinc-500 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </form>
        </div>
    </section>

    {{-- ===== MAIN CONTENT ===== --}}
    <section class="w-full py-12 bg-zinc-50/50 min-h-[500px]">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            
            @if(request('search'))
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-zinc-800 font-['Nunito']">Hasil pencarian untuk: <span class="text-amber-600">"{{ request('search') }}"</span></h2>
                </div>
            @endif

            @if($artikels->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-zinc-800 text-xl font-bold font-['Nunito'] mb-2">Artikel Tidak Ditemukan</h3>
                    <p class="text-zinc-500 text-sm font-medium font-['Nunito']">Maaf, kami tidak dapat menemukan artikel yang Anda cari. Coba kata kunci lain atau pilih kategori berbeda.</p>
                    <a href="{{ route('artikel.index') }}" class="mt-6 px-6 py-2.5 bg-amber-100 text-amber-800 rounded-full text-sm font-bold font-['Nunito'] hover:bg-amber-200 transition-colors">Lihat Semua Artikel</a>
                </div>
            @else
                
                {{-- Featured Article (Hanya muncul di halaman pertama tanpa filter) --}}
                @if($featured)
                    <div class="mb-12 group cursor-pointer animate-fade-in-up" onclick="window.location.href='{{ route('artikel.detail', $featured->slug) }}'">
                        <div class="w-full bg-white rounded-[2rem] overflow-hidden flex flex-col md:flex-row border border-zinc-100 shadow-sm hover:shadow-xl transition-shadow duration-300">
                            {{-- Image --}}
                            <div class="w-full md:w-1/2 h-64 md:h-auto md:min-h-[400px] relative overflow-hidden bg-zinc-100">
                                @if($featured->thumbnail)
                                    <img src="{{ asset('storage/'.$featured->thumbnail) }}" alt="{{ $featured->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                        <i data-lucide="image" class="w-16 h-16 text-amber-200"></i>
                                    </div>
                                @endif
                                <div class="absolute top-6 left-6 px-3 py-1 bg-white/90 backdrop-blur rounded-full shadow-sm">
                                    <span class="text-amber-700 text-xs font-bold font-['Nunito'] tracking-wide uppercase">{{ $featured->kategori->nama_kategori ?? 'Umum' }}</span>
                                </div>
                            </div>
                            {{-- Content --}}
                            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                                <div class="flex items-center gap-4 text-xs font-semibold text-zinc-500 font-['Nunito'] mb-4 uppercase tracking-wider">
                                    <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="w-3.5 h-3.5"></i> {{ \Carbon\Carbon::parse($featured->created_at)->translatedFormat('d M Y') }}</span>
                                    <span class="flex items-center gap-1.5"><i data-lucide="eye" class="w-3.5 h-3.5"></i> {{ $featured->dilihat }} kali</span>
                                </div>
                                <h2 class="text-zinc-900 text-2xl md:text-4xl font-extrabold font-['Nunito'] leading-tight mb-4 group-hover:text-amber-600 transition-colors">{{ $featured->judul }}</h2>
                                <p class="text-zinc-600 text-base md:text-lg font-medium font-['Nunito'] leading-relaxed mb-8 line-clamp-3">
                                    {{ $featured->ringkasan }}
                                </p>
                                <div class="flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center text-amber-800 font-bold overflow-hidden">
                                            @if($featured->penulis && $featured->penulis->foto_profil)
                                                <img src="{{ asset('storage/'.$featured->penulis->foto_profil) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($featured->penulis->nama_lengkap ?? 'Admin', 0, 1) }}
                                            @endif
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-zinc-900 text-sm font-bold font-['Nunito']">{{ $featured->penulis->nama_lengkap ?? 'Admin Juice Kidding' }}</span>
                                            <span class="text-zinc-500 text-xs font-semibold font-['Nunito']">Penulis</span>
                                        </div>
                                    </div>
                                    <span class="text-amber-600 font-bold text-sm flex items-center gap-1 group-hover:translate-x-1 transition-transform">Baca <i data-lucide="arrow-right" class="w-4 h-4"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Grid List --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($artikels as $artikel)
                        @if($featured && $artikel->id_artikel == $featured->id_artikel && $artikels->currentPage() == 1)
                            @continue
                        @endif
                        <a href="{{ route('artikel.detail', $artikel->slug) }}" class="group bg-white rounded-[1.5rem] overflow-hidden border border-zinc-100 shadow-[0px_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0px_10px_30px_rgba(245,158,11,0.1)] transition-all duration-300 hover:-translate-y-1 flex flex-col stagger-item">
                            {{-- Image --}}
                            <div class="w-full h-56 relative overflow-hidden bg-zinc-100">
                                @if($artikel->thumbnail)
                                    <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                        <i data-lucide="image" class="w-12 h-12 text-amber-200"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-full shadow-sm">
                                    <span class="text-amber-700 text-[10px] font-bold font-['Nunito'] tracking-wider uppercase">{{ $artikel->kategori->nama_kategori ?? 'Umum' }}</span>
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex items-center gap-3 text-[11px] font-bold text-zinc-500 font-['Nunito'] mb-3 uppercase tracking-wider">
                                    <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i> {{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="text-zinc-900 text-xl font-black font-['Nunito'] leading-snug mb-3 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $artikel->judul }}</h3>
                                <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed mb-6 line-clamp-3 flex-1">
                                    {{ $artikel->ringkasan }}
                                </p>
                                
                                {{-- Footer Card --}}
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-zinc-50">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-bold overflow-hidden">
                                            @if($artikel->penulis && $artikel->penulis->foto_profil)
                                                <img src="{{ asset('storage/'.$artikel->penulis->foto_profil) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($artikel->penulis->nama_lengkap ?? 'A', 0, 1) }}
                                            @endif
                                        </div>
                                        <span class="text-zinc-600 text-xs font-bold font-['Nunito']">{{ $artikel->penulis->nama_lengkap ?? 'Admin' }}</span>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-zinc-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-zinc-500 group-hover:text-amber-600"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $artikels->links('pagination::tailwind') }}
                </div>

            @endif

        </div>
    </section>

@endsection

@section('scripts')
<style>
    .stagger-item { opacity: 0; transform: translateY(20px); }
    .stagger-item.visible { animation: fadeInUp 0.5s ease-out forwards; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.stagger-item').forEach(el => observer.observe(el));
    });
</script>
@endsection
