@extends('layouts.main')

@section('content')
    <div class="bg-zinc-50 min-h-screen pt-[100px] pb-20">
        
        {{-- Breadcrumb --}}
        <div class="max-w-[800px] mx-auto px-4 md:px-8 mb-6">
            <nav class="flex text-xs font-semibold font-['Nunito'] text-zinc-500">
                <a href="{{ route('beranda') }}" class="hover:text-amber-600 transition-colors">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('artikel.index') }}" class="hover:text-amber-600 transition-colors">Jurnal</a>
                <span class="mx-2">/</span>
                <span class="text-zinc-600 truncate">{{ $artikel->judul }}</span>
            </nav>
        </div>

        {{-- Main Article Wrapper --}}
        <article class="max-w-[800px] mx-auto px-4 md:px-8 bg-white md:rounded-[2rem] md:shadow-[0px_10px_40px_rgba(0,0,0,0.03)] border border-zinc-100 overflow-hidden relative">
            
            {{-- Header --}}
            <header class="pt-10 md:pt-14 px-4 md:px-12 text-center relative z-10">
                <div class="inline-block px-4 py-1.5 bg-amber-100 text-amber-700 text-xs font-bold font-['Nunito'] rounded-full mb-6 tracking-wider uppercase">
                    {{ $artikel->kategori->nama_kategori ?? 'Umum' }}
                </div>
                
                <h1 class="text-zinc-900 text-3xl md:text-5xl font-black font-['Nunito'] leading-tight mb-8">
                    {{ $artikel->judul }}
                </h1>

                <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-semibold text-zinc-500 font-['Nunito'] pb-8 border-b border-zinc-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-bold overflow-hidden">
                            @if($artikel->penulis && $artikel->penulis->foto_profil)
                                <img src="{{ asset('storage/'.$artikel->penulis->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($artikel->penulis->nama_lengkap ?? 'A', 0, 1) }}
                            @endif
                        </div>
                        <span class="text-zinc-700">{{ $artikel->penulis->nama_lengkap ?? 'Admin' }}</span>
                    </div>
                    <span class="flex items-center gap-2"><i data-lucide="calendar" class="w-4 h-4"></i> {{ \Carbon\Carbon::parse($artikel->created_at)->translatedFormat('d M Y') }}</span>
                    <span class="flex items-center gap-2"><i data-lucide="eye" class="w-4 h-4"></i> {{ $artikel->dilihat }} Dilihat</span>
                </div>
            </header>

            {{-- Cover Image --}}
            <div class="w-full mt-8 px-4 md:px-12">
                <div class="w-full aspect-[16/9] md:aspect-[2/1] rounded-2xl md:rounded-[2rem] overflow-hidden bg-zinc-100 relative shadow-inner">
                    @if($artikel->thumbnail)
                        <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-amber-50">
                            <i data-lucide="image" class="w-20 h-20 text-amber-200"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <div class="px-4 md:px-12 py-10 md:py-16">
                <div class="prose prose-lg prose-zinc max-w-none font-['Nunito'] prose-headings:font-extrabold prose-headings:text-zinc-900 prose-a:text-amber-600 prose-img:rounded-2xl">
                    {!! $artikel->konten !!}
                </div>

                {{-- Share & Tags --}}
                <div class="mt-12 pt-8 border-t border-zinc-100 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-zinc-500 uppercase tracking-wider font-['Nunito']">Bagikan:</span>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->judul . ' - ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition-colors">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($artikel->judul) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')" class="w-10 h-10 rounded-full bg-zinc-100 text-zinc-600 flex items-center justify-center hover:bg-zinc-200 transition-colors">
                            <i data-lucide="link" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- CTA Banner --}}
            <div class="px-4 md:px-12 pb-12">
                <div class="w-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl md:rounded-[2rem] p-8 md:p-10 text-center relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-yellow-300/20 rounded-full blur-xl"></div>
                    <h3 class="text-white text-2xl md:text-3xl font-black font-['Nunito'] mb-4 relative z-10">Haus setelah membaca?</h3>
                    <p class="text-amber-50 text-base font-medium font-['Nunito'] mb-6 max-w-lg mx-auto relative z-10">Yuk segarkan dirimu dengan racikan jus sehat pilihanmu sekarang. Kami yang blender, kamu yang nikmati!</p>
                    <a href="{{ route('customer.racik') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-orange-600 rounded-full font-bold font-['Nunito'] hover:scale-105 active:scale-95 transition-all shadow-lg relative z-10">
                        Racik Jus Sekarang
                    </a>
                </div>
            </div>
            
        </article>

        {{-- Related Articles --}}
        @if($related->count() > 0)
        <div class="max-w-[1280px] mx-auto px-4 md:px-8 mt-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-zinc-900 font-['Nunito']">Baca Juga</h2>
                <a href="{{ route('artikel.index') }}" class="text-amber-600 font-bold text-sm hover:underline font-['Nunito'] flex items-center gap-1">Semua Artikel <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($related as $rel)
                    <a href="{{ route('artikel.detail', $rel->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-zinc-100 flex flex-col hover:-translate-y-1">
                        <div class="w-full h-48 relative overflow-hidden bg-zinc-100">
                            @if($rel->thumbnail)
                                <img src="{{ asset('storage/'.$rel->thumbnail) }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-amber-50">
                                    <i data-lucide="image" class="w-8 h-8 text-amber-200"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-white/90 backdrop-blur rounded-full shadow-sm">
                                <span class="text-amber-700 text-[10px] font-bold font-['Nunito'] uppercase tracking-wider">{{ $rel->kategori->nama_kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-lg font-bold text-zinc-900 font-['Nunito'] leading-snug mb-3 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $rel->judul }}</h3>
                            <p class="text-zinc-500 text-sm font-medium font-['Nunito'] line-clamp-2 mt-auto">{{ $rel->ringkasan }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
@endsection
