@extends('layouts.main')

@section('head')
<style>
    @keyframes float-bubble {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
        50% { transform: translateY(-12px) scale(1.1); opacity: 0.6; }
    }
    @keyframes liquid-fill {
        0% { height: 0; }
    }
    @keyframes stepPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.3); }
        50% { box-shadow: 0 0 0 6px rgba(5, 150, 105, 0); }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .bubble-float { animation: float-bubble 3s ease-in-out infinite; }
    .bubble-float:nth-child(2) { animation-delay: 0.8s; }
    .bubble-float:nth-child(3) { animation-delay: 1.6s; }
    .bubble-float:nth-child(4) { animation-delay: 2.4s; }

    .step-num {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .step-card.completed .step-num {
        background: linear-gradient(135deg, #059669, #10B981) !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }
    .step-card.active .step-num {
        background: linear-gradient(135deg, #D97706, #F59E0B) !important;
        box-shadow: 0 4px 16px rgba(217, 119, 6, 0.35);
        animation: stepPulse 2s infinite;
    }
    .step-card.active { border-color: #f59e0b80 !important; box-shadow: 0 0 0 1px #f59e0b20, 0 4px 12px rgba(0,0,0,0.04); }
    .step-card.completed { border-color: #05966940 !important; }

    .option-card {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .option-card:active { transform: scale(0.97); }

    .sticky-bottom-bar {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .sticky-bottom-bar.hidden-bar { transform: translateY(100%); }
    @media (max-width: 1023px) {
        .sticky-bottom-bar { transform: translateY(0); }
        .has-sticky-bar { padding-bottom: 90px; }
    }

    .progress-fill {
        transform-origin: left;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .step-list::-webkit-scrollbar { width: 4px; }
    .step-list::-webkit-scrollbar-track { background: transparent; }
    .step-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    @media (prefers-reduced-motion: reduce) {
        .bubble-float, .step-num, .progress-fill { animation: none !important; transition: none !important; }
    }
</style>
@endsection

@section('content')
{{-- ===== HERO ===== --}}
<section class="relative px-6 sm:px-8 pt-[100px] pb-10 overflow-hidden bg-gradient-to-br from-emerald-50/80 via-white to-amber-50/40">
    <div class="absolute -right-20 -top-20 w-72 h-72 bg-emerald-300/15 rounded-full blur-[80px]"></div>
    <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-amber-300/10 rounded-full blur-[60px]"></div>
    <div class="max-w-[1280px] mx-auto relative z-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="animate-fade-in-up">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-black rounded-full mb-3 tracking-wider uppercase">
                    <i data-lucide="flask-conical" class="w-3.5 h-3.5"></i>
                    Custom Blend
                </span>
                <h1 class="text-4xl lg:text-5xl font-black text-zinc-900 leading-tight mb-1">
                    Racik <span class="text-emerald-600">Sendiri</span>
                </h1>
                <p class="text-base font-medium text-zinc-500 max-w-lg">Pilih bahan favoritmu, jadilah mixologist andalan!</p>
        </div>
    </div>
</section>

{{-- ===== MAIN ===== --}}
<div class="max-w-[1280px] mx-auto px-6 sm:px-8 py-6 has-sticky-bar">
    {{-- Progress --}}
    <div class="mb-8 animate-fade-in-up">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-emerald-600" id="step-label">Langkah 1 dari 6</span>
                <span class="text-xs text-zinc-400">—</span>
                <span class="text-xs text-zinc-500 font-medium" id="step-name-label">Pilih Ukuran Cup</span>
            </div>
            <span class="text-xs font-bold text-zinc-500" id="step-percent">0%</span>
        </div>
        <div class="w-full h-2.5 bg-zinc-100 rounded-full overflow-hidden">
            <div class="h-full w-full progress-fill rounded-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-400" id="progress-bar" style="transform: scaleX(0);"></div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        {{-- ===== LEFT: Blender Visual ===== --}}
        <div class="w-full lg:w-[300px] lg:sticky lg:top-[100px] lg:self-start flex-shrink-0">
            <div class="bg-white rounded-3xl border border-zinc-200/70 shadow-sm p-5 relative overflow-hidden">
                <div class="absolute -top-6 -right-6 w-16 h-16 bg-emerald-50 rounded-full"></div>

                <div class="flex items-center justify-between mb-4 relative">
                    <h3 class="text-sm font-black text-zinc-800 flex items-center gap-2">
                        <i data-lucide="cup-soda" class="w-4 h-4 text-emerald-500"></i>
                        Gelas Racikan
                    </h3>
                    <div class="flex items-center gap-2">
                        <span id="selected-count" class="text-[10px] font-bold text-zinc-500 bg-zinc-50 px-2 py-0.5 rounded-full">0 bahan</span>
                        <span id="liquid-pct" class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">0%</span>
                    </div>
                </div>

                {{-- Glass --}}
                <div class="w-full max-w-[180px] mx-auto">
                    <div class="relative" style="aspect-ratio: 3/4;">
                        {{-- Lid --}}
                        <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-[106%] h-6 bg-gradient-to-b from-zinc-700 to-zinc-800 rounded-t-xl z-20 shadow-sm">
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-6 h-1.5 bg-zinc-600 rounded-full"></div>
                        </div>
                        {{-- Handle --}}
                        <div class="absolute top-[18%] -right-2.5 w-5 h-[35%] bg-zinc-300/50 rounded-r-full border-2 border-l-0 border-zinc-300/70 z-10"></div>

                        {{-- Glass Body --}}
                        <div class="absolute inset-0 top-5 bottom-0 bg-white border-[3px] border-zinc-300/70 rounded-b-[36px] rounded-t-[10px] overflow-hidden shadow-inner">
                            {{-- Liquid --}}
                            <div id="liquid-layer" class="absolute bottom-0 left-0 right-0 h-0 transition-all duration-700 ease-out flex items-end justify-center"
                                 style="background: linear-gradient(to top, rgba(5,150,105,0.6), rgba(16,185,129,0.3));">
                                <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
                                    <div class="bubble-float w-2 h-2 bg-white rounded-full absolute" style="left:20%;bottom:25%;"></div>
                                    <div class="bubble-float w-2.5 h-2.5 bg-white rounded-full absolute" style="left:55%;bottom:45%;"></div>
                                    <div class="bubble-float w-1.5 h-1.5 bg-white rounded-full absolute" style="left:75%;bottom:35%;"></div>
                                    <div class="bubble-float w-2 h-2 bg-white rounded-full absolute" style="left:35%;bottom:60%;"></div>
                                </div>
                                <span id="liquid-label" class="text-white text-[10px] font-black opacity-0 mb-3 transition-opacity duration-500 drop-shadow-sm">Racikanmu</span>
                            </div>
                            {{-- Volume Scale --}}
                            <div class="absolute right-1.5 top-2 bottom-2 w-1 bg-zinc-200/40 rounded-full">
                                <div class="absolute bottom-0 w-full bg-emerald-400/50 rounded-full transition-all duration-700" id="volume-indicator" style="height:0%;"></div>
                            </div>
                            <div class="absolute left-3 right-3 border-t border-dashed border-zinc-200/40" style="top:25%;"></div>
                            <div class="absolute left-3 right-3 border-t border-dashed border-zinc-200/40" style="top:50%;"></div>
                            <div class="absolute left-3 right-3 border-t border-dashed border-zinc-200/40" style="top:75%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Fruit Chips --}}
                <div class="mt-3">
                    <div class="flex items-center justify-center gap-1.5 flex-wrap min-h-[28px]" id="fruit-chips">
                        <span class="text-[11px] text-zinc-500 font-medium">Belum ada bahan</span>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <span id="max-count" class="text-[10px] text-zinc-500 font-medium">maks. 3 bahan</span>
                </div>
            </div>

            {{-- Quick Total --}}
            <div class="mt-4 bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl border border-emerald-100 p-4 text-center">
                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-wider">Total per Gelas</span>
                <div class="text-2xl font-black text-emerald-700 mt-1">Rp<span id="sidebar-total">0</span></div>
            </div>
        </div>

        {{-- ===== RIGHT: Step Wizard ===== --}}
        <div class="flex-1 min-w-0 space-y-4 step-list" id="step-wizard">

            {{-- STEP 1: Ukuran Cup --}}
            @php $ukuranCupTipe = $tipeOpsi->firstWhere('id_tipe_opsi', 8); @endphp
            @if($ukuranCupTipe && $ukuranCupTipe->opsi->count() > 0)
            <div class="step-card active bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="1" id="step-1">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">1</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Pilih Ukuran Cup</h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Tentukan ukuran gelas untuk racikanmu</p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach($ukuranCupTipe->opsi as $opsi)
                        @php
                            $maxBahan = $opsi->id_opsi == 34 ? 3 : ($opsi->id_opsi == 35 ? 5 : 8);
                        @endphp
                        <label class="option-card relative flex flex-col items-center p-5 rounded-xl border-2 border-zinc-200 bg-white hover:border-emerald-400 hover:shadow-md transition-all cursor-pointer group active:scale-[0.98] has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:shadow-md">
                            <input type="radio" name="ukuran" value="{{ $opsi->id_opsi }}"
                                   data-max-bahan="{{ $maxBahan }}"
                                   data-harga="{{ $opsi->harga_tambahan }}"
                                   onchange="onStepChange()"
                                   class="absolute opacity-0 peer"
                                   {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 flex items-center justify-center text-sm font-black text-emerald-600 border border-emerald-100 mb-2.5">
                                @if($opsi->id_opsi == 34) S
                                @elseif($opsi->id_opsi == 35) M
                                @else L
                                @endif
                            </div>
                            <span class="text-sm font-bold text-zinc-900 text-center">{{ $opsi->nama_opsi }}</span>
                            <span class="text-[10px] text-zinc-500 font-medium mt-0.5">{{ $maxBahan }} bahan</span>
                            <span class="text-xs font-bold text-emerald-600 mt-1">
                                {{ $opsi->harga_tambahan > 0 ? '+Rp'.number_format($opsi->harga_tambahan, 0, ',', '.') : 'Gratis' }}
                            </span>
                            <div class="absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-zinc-300 flex items-center justify-center peer-checked:bg-emerald-600 peer-checked:border-emerald-600 transition-colors">
                                <i data-lucide="check" class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- STEP 2: Cairan Base --}}
            @php $cairanTipe = $tipeOpsi->firstWhere('id_tipe_opsi', 4); @endphp
            @if($cairanTipe && $cairanTipe->opsi->count() > 0)
            <div class="step-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="2" id="step-2">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-zinc-300 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">2</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Pilih Cairan Base</h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Pilih cairan dasar untuk jusmu</p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($cairanTipe->opsi as $opsi)
                        <label class="relative flex items-center justify-between gap-3 p-4 rounded-xl border-2 border-zinc-200 bg-white hover:border-emerald-400 hover:shadow-sm transition-all cursor-pointer group active:scale-[0.98] has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:shadow-md">
                            <input type="radio" name="cairan" value="{{ $opsi->id_opsi }}"
                                   data-harga="{{ $opsi->harga_tambahan }}"
                                   onchange="onStepChange()"
                                   class="absolute opacity-0 peer"
                                   {{ $loop->first ? 'checked' : '' }}>
                            <span class="text-sm font-bold text-zinc-900 block truncate">{{ $opsi->nama_opsi }}</span>
                            <span class="text-xs font-bold text-emerald-600 whitespace-nowrap">
                                {{ $opsi->harga_tambahan > 0 ? '+Rp'.number_format($opsi->harga_tambahan, 0, ',', '.') : 'Gratis' }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- STEP 3: Bahan Buah & Sayur --}}
            @php $bahanTipe = $tipeOpsi->firstWhere('id_tipe_opsi', 5); @endphp
            @if($bahanTipe && $bahanTipe->opsi->count() > 0)
            <div class="step-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="3" id="step-3">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-zinc-300 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">3</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Pilih Bahan <span class="text-emerald-600">Buah & Sayur</span></h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Pilih minimal 1, <span id="bahan-counter" class="text-emerald-600 font-bold">maks. 3 bahan</span></p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($bahanTipe->opsi as $opsi)
                        @php
                            $warnaMap = [20=>'#f59e0b',21=>'#65a30d',22=>'#ef4444',23=>'#ec4899',24=>'#eab308',25=>'#f97316',26=>'#22c55e',27=>'#dc2626'];
                            $warna = $warnaMap[$opsi->id_opsi] ?? '#f59e0b';
                        @endphp
                        <label class="relative flex items-center justify-between gap-3 p-4 rounded-xl border-2 border-zinc-200 bg-white hover:border-emerald-400 hover:shadow-sm transition-all cursor-pointer group active:scale-[0.98] has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:shadow-md bahan-label"
                               data-warna="{{ $warna }}">
                            <input type="checkbox" name="bahan" value="{{ $opsi->id_opsi }}"
                                   data-harga="{{ $opsi->harga_tambahan }}"
                                   data-warna="{{ $warna }}"
                                   data-nama="{{ $opsi->nama_opsi }}"
                                   onchange="onBahanChange(this)"
                                   class="absolute opacity-0 peer">
                            <span class="text-sm font-bold text-zinc-900 block truncate">{{ $opsi->nama_opsi }}</span>
                            <span class="text-xs font-bold text-emerald-600 whitespace-nowrap">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- STEP 4: Tambahan --}}
            @php $tambahanTipe = $tipeOpsi->firstWhere('id_tipe_opsi', 7); @endphp
            @if($tambahanTipe && $tambahanTipe->opsi->count() > 0)
            <div class="step-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="4" id="step-4">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-zinc-300 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">4</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Tambahan <span class="text-amber-500">(Opsional)</span></h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Rempah & tambahan premium untuk racikanmu</p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($tambahanTipe->opsi as $opsi)
                        <label class="relative flex items-center justify-between gap-3 p-4 rounded-xl border-2 border-zinc-200 bg-white hover:border-amber-400 hover:shadow-sm transition-all cursor-pointer group active:scale-[0.98] has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/50 has-[:checked]:shadow-md">
                            <input type="checkbox" name="tambahan" value="{{ $opsi->id_opsi }}"
                                   data-harga="{{ $opsi->harga_tambahan }}"
                                   onchange="onStepChange()"
                                   class="absolute opacity-0 peer">
                            <span class="text-sm font-bold text-zinc-900 block truncate">{{ $opsi->nama_opsi }}</span>
                            <span class="text-xs font-bold text-amber-600 whitespace-nowrap">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- STEP 5: Kustomisasi Standar --}}
            <div class="step-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="5" id="step-5">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-zinc-300 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">5</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Kustomisasi Standar</h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Atur tingkat gula, es, dan topping</p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="space-y-4">
                        @foreach($tipeOpsi->sortBy('urutan') as $tipe)
                            @if(in_array($tipe->id_tipe_opsi, [2, 9, 3, 6]))
                            <div>
                                <h4 class="text-xs font-black text-zinc-700 uppercase tracking-wider mb-2.5 flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $tipe->nama_tipe }}
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tipe->opsi as $opsi)
                                    <label class="relative inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-zinc-200 bg-white hover:border-emerald-400 hover:shadow-sm transition-all cursor-pointer active:scale-[0.98] has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 has-[:checked]:shadow-sm">
                                        <input type="{{ $tipe->pilih_banyak ? 'checkbox' : 'radio' }}"
                                               name="standar_{{ $tipe->id_tipe_opsi }}"
                                               value="{{ $opsi->id_opsi }}"
                                               data-harga="{{ $opsi->harga_tambahan }}"
                                               onchange="onStepChange()"
                                               class="absolute opacity-0 peer"
                                               {{ !$tipe->pilih_banyak && $loop->first ? 'checked' : '' }}>
                                        <span class="text-sm font-bold text-zinc-700 whitespace-nowrap">{{ $opsi->nama_opsi }}</span>
                                        @if($opsi->harga_tambahan > 0)
                                        <span class="text-[10px] font-bold text-emerald-600">+Rp{{ number_format($opsi->harga_tambahan, 0, ',', '.') }}</span>
                                        @endif
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- STEP 6: Ringkasan --}}
            <div class="step-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden transition-all duration-300" data-step="6" id="step-6">
                <div class="flex items-center gap-3 px-5 pt-5 pb-4">
                    <span class="step-num w-8 h-8 rounded-lg bg-zinc-300 text-white text-sm font-bold flex items-center justify-center shadow-sm flex-shrink-0">6</span>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-black text-zinc-900">Ringkasan Pesanan</h3>
                        <p class="text-[11px] text-zinc-500 font-medium">Periksa kembali racikanmu sebelum memesan</p>
                    </div>
                    <span class="step-status text-[10px] font-bold text-emerald-600 hidden">✓ Selesai</span>
                </div>
                <div class="px-5 pb-5">
                    <div class="bg-zinc-50 rounded-xl p-5 mb-5 space-y-2" id="order-summary">
                        <div id="summary-items" class="space-y-2">
                            <div class="text-center text-zinc-500 text-sm py-2">Belum ada pilihan</div>
                        </div>
                        <div class="border-t border-zinc-200 pt-3 flex justify-between items-center">
                            <span class="text-zinc-500 font-bold text-sm">Subtotal per Gelas</span>
                            <span id="subtotal-per-item" class="font-black text-zinc-900 text-lg">Rp0</span>
                        </div>
                        <div class="flex justify-between items-center text-xs text-zinc-500">
                            <span>Kuantitas</span>
                            <span id="racik-qty-summary">1 gelas</span>
                        </div>
                    </div>

                    {{-- Quantity --}}
                    <div class="flex items-center justify-between mb-5">
                        <span class="text-sm font-bold text-zinc-700">Kuantitas</span>
                        <div class="flex items-center bg-zinc-100 rounded-xl p-1 gap-1">
                            <button onclick="changeRacikQty(-1)" class="w-9 h-9 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-600 active:scale-90 transition-all font-bold cursor-pointer shadow-sm border border-zinc-200/50" aria-label="Kurangi">
                                <i data-lucide="minus" class="w-4 h-4"></i>
                            </button>
                            <span id="racik-qty" class="w-12 text-center font-black text-zinc-900 text-lg">1</span>
                            <button onclick="changeRacikQty(1)" class="w-9 h-9 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-600 active:scale-90 transition-all font-bold cursor-pointer shadow-sm border border-zinc-200/50" aria-label="Tambah">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="flex items-center justify-between mb-5 p-4 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                        <div>
                            <span class="text-xs font-bold text-zinc-500">Total Pembayaran</span>
                            <span id="racik-qty-total-label" class="block text-[10px] text-zinc-500 font-medium">(1 gelas)</span>
                        </div>
                        <span id="racik-total" class="text-2xl font-black text-emerald-700">Rp0</span>
                    </div>

                    @auth
                    <button onclick="submitRacik()" id="btn-racik-submit"
                            class="hidden lg:flex w-full py-4 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black rounded-xl items-center justify-center gap-3 transition-all active:scale-[0.98] shadow-lg shadow-emerald-500/25 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed text-base">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span>Tambahkan ke Keranjang</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" id="btn-racik-submit"
                            class="hidden lg:flex w-full py-4 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black rounded-xl items-center justify-center gap-3 transition-all active:scale-[0.98] shadow-lg shadow-emerald-500/25 cursor-pointer text-base">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        <span>Masuk untuk Memesan</span>
                    </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===== STICKY BOTTOM BAR (Mobile) ===== --}}
<div class="sticky-bottom-bar fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-lg border-t border-zinc-200 px-5 py-3 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] lg:hidden">
    <div class="flex items-center justify-between gap-4">
        <div>
            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Total</span>
            <div class="text-lg font-black text-emerald-700">Rp<span id="racik-total-mobile">0</span></div>
        </div>
        @auth
        <button onclick="submitRacik()" id="btn-racik-submit-mobile"
                class="flex-1 py-3.5 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black rounded-xl flex items-center justify-center gap-2.5 transition-all active:scale-[0.98] shadow-lg shadow-emerald-500/25 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed text-sm max-w-[240px]">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
            <span>+ Keranjang</span>
        </button>
        @else
        <a href="{{ route('login') }}" id="btn-racik-submit-mobile"
                class="flex-1 py-3.5 bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black rounded-xl flex items-center justify-center gap-2.5 transition-all active:scale-[0.98] shadow-lg shadow-emerald-500/25 cursor-pointer text-sm max-w-[240px]">
            <i data-lucide="log-in" class="w-4 h-4"></i>
            <span>Login Dulu</span>
        </a>
        @endauth
    </div>
</div>
@endsection

@section('scripts')
<script>
let racikQty = 1;
const BASE_PRICE = 0;

const FRUIT_COLORS = {
    20: { bg: '#f59e0b', name: 'Mangga' },
    21: { bg: '#65a30d', name: 'Alpukat' },
    22: { bg: '#ef4444', name: 'Apel' },
    23: { bg: '#ec4899', name: 'Stroberi' },
    24: { bg: '#eab308', name: 'Pisang' },
    25: { bg: '#f97316', name: 'Wortel' },
    26: { bg: '#22c55e', name: 'Sawi' },
    27: { bg: '#dc2626', name: 'Tomat' },
};

const STEP_LABELS = {
    1: 'Pilih Ukuran Cup', 2: 'Pilih Cairan Base', 3: 'Pilih Bahan Buah & Sayur',
    4: 'Tambahan (Opsional)', 5: 'Kustomisasi Standar', 6: 'Ringkasan Pesanan',
};

document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    onStepChange();
    updateProgress();
});

function onStepChange() {
    updateSummary();
    updateBlender();
    updateProgress();
    updateStepStatuses();
}

function updateStepStatuses() {
    setStepStatus(1, !!document.querySelector('input[name="ukuran"]:checked'));
    setStepStatus(2, !!document.querySelector('input[name="cairan"]:checked'));
    setStepStatus(3, document.querySelectorAll('input[name="bahan"]:checked').length > 0);
    setStepStatus(4, true); // optional
    setStepStatus(5, true);
}

function setStepStatus(step, completed) {
    const card = document.getElementById('step-' + step);
    if (!card) return;
    const statusEl = card.querySelector('.step-status');
    const numEl = card.querySelector('.step-num');

    if (completed) {
        card.classList.add('completed');
        card.classList.remove('active');
        if (statusEl) statusEl.classList.remove('hidden');
        if (numEl) numEl.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i>';
    } else {
        card.classList.remove('completed');
        if (statusEl) statusEl.classList.add('hidden');
        if (numEl) numEl.innerHTML = step;
    }
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function updateProgress() {
    let completed = 0;
    for (let i = 1; i <= 6; i++) {
        const card = document.getElementById('step-' + i);
        if (card && card.classList.contains('completed')) completed++;
    }
    const pct = Math.round((completed / 6) * 100);
    const bar = document.getElementById('progress-bar');
    if (bar) bar.style.transform = 'scaleX(' + (Math.min(pct, 100) / 100) + ')';
    const pctEl = document.getElementById('step-percent');
    if (pctEl) pctEl.textContent = Math.min(pct, 100) + '%';
    const label = document.getElementById('step-label');
    if (label) label.textContent = 'Langkah ' + Math.min(completed + 1, 6) + ' dari 6';
    const nameLabel = document.getElementById('step-name-label');
    if (nameLabel) nameLabel.textContent = STEP_LABELS[Math.min(completed + 1, 6)] || '';
}

function onBahanChange(el) {
    const maxBahan = getMaxBahan();
    const checked = document.querySelectorAll('input[name="bahan"]:checked');
    if (checked.length > maxBahan) {
        el.checked = false;
        showToast('Maksimal ' + maxBahan + ' bahan untuk ukuran ini', '');
        return;
    }
    document.getElementById('bahan-counter').textContent = 'Dipilih ' + checked.length + ' dari ' + maxBahan + ' bahan';
    document.getElementById('selected-count').textContent = checked.length + ' bahan';
    onStepChange();
}

function getMaxBahan() {
    const ukuran = document.querySelector('input[name="ukuran"]:checked');
    return ukuran ? parseInt(ukuran.dataset.maxBahan) : 3;
}

function updateBlender() {
    const checked = document.querySelectorAll('input[name="bahan"]:checked');
    const liquid = document.getElementById('liquid-layer');
    const label = document.getElementById('liquid-label');
    const volume = document.getElementById('volume-indicator');
    const chips = document.getElementById('fruit-chips');
    const pctEl = document.getElementById('liquid-pct');
    const maxBahan = getMaxBahan();
    const pct = checked.length > 0 ? Math.min(20 + (checked.length / maxBahan) * 60, 80) : 0;

    liquid.style.height = pct + '%';
    if (pctEl) pctEl.textContent = Math.round(pct) + '%';

    if (checked.length > 0) {
        const last = checked[checked.length - 1];
        const color = FRUIT_COLORS[parseInt(last.value)]?.bg || '#059669';
        liquid.style.background = `linear-gradient(to top, ${color}dd, ${color}88)`;
        label.classList.remove('opacity-0');
        label.textContent = 'Racikanmu';
    } else {
        liquid.style.background = 'linear-gradient(to top, rgba(5,150,105,0.4), rgba(16,185,129,0.2))';
        label.classList.add('opacity-0');
    }
    volume.style.height = pct + '%';

    chips.innerHTML = '';
    if (checked.length > 0) {
        checked.forEach(cb => {
            const id = parseInt(cb.value);
            const info = FRUIT_COLORS[id];
            if (info) {
                const chip = document.createElement('span');
                chip.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold';
                chip.style.background = info.bg + '22';
                chip.style.color = info.bg;
                chip.textContent = info.name;
                chips.appendChild(chip);
            }
        });
    } else {
        chips.innerHTML = '<span class="text-[11px] text-zinc-500 font-medium">Belum ada bahan</span>';
    }
}

function updateSummary() {
    let totalOpsi = 0;
    const summaryItems = document.getElementById('summary-items');
    summaryItems.innerHTML = '';
    const allSelections = [];

    function getOptionName(el, fallback) {
        if (el.dataset.nama) return el.dataset.nama;
        const label = el.closest('label');
        const nameEl = label?.querySelector('.text-sm.font-bold');
        if (nameEl) return nameEl.textContent.trim();
        return fallback;
    }

    const ukuran = document.querySelector('input[name="ukuran"]:checked');
    if (ukuran) allSelections.push({ label: getOptionName(ukuran, 'Ukuran'), harga: parseInt(ukuran.dataset.harga || 0) });
    const cairan = document.querySelector('input[name="cairan"]:checked');
    if (cairan) allSelections.push({ label: getOptionName(cairan, 'Cairan'), harga: parseInt(cairan.dataset.harga || 0) });
    document.querySelectorAll('input[name="bahan"]:checked').forEach(cb => {
        allSelections.push({ label: getOptionName(cb, 'Bahan'), harga: parseInt(cb.dataset.harga || 0) });
    });
    document.querySelectorAll('input[name="tambahan"]:checked').forEach(cb => {
        allSelections.push({ label: getOptionName(cb, 'Tambahan'), harga: parseInt(cb.dataset.harga || 0) });
    });
    document.querySelectorAll('[name^="standar_"]:checked').forEach(cb => {
        const harga = parseInt(cb.dataset.harga || 0);
        if (harga > 0) allSelections.push({ label: getOptionName(cb, 'Opsi'), harga });
    });

    allSelections.forEach(item => {
        totalOpsi += item.harga;
        const div = document.createElement('div');
        div.className = 'flex justify-between items-center text-sm';
        div.innerHTML = `
            <span class="text-zinc-500 font-medium">${item.label}</span>
            <span class="font-bold text-zinc-900">${item.harga > 0 ? '+Rp' + item.harga.toLocaleString('id-ID') : 'Gratis'}</span>`;
        summaryItems.appendChild(div);
    });
    if (allSelections.length === 0) {
        summaryItems.innerHTML = '<div class="text-center text-zinc-500 text-sm py-2">Belum ada pilihan</div>';
    }

    const subtotal = BASE_PRICE + totalOpsi;
    document.getElementById('subtotal-per-item').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('racik-total').textContent = 'Rp ' + (subtotal * racikQty).toLocaleString('id-ID');
    document.getElementById('sidebar-total').textContent = subtotal.toLocaleString('id-ID');
    document.getElementById('racik-qty-summary').textContent = racikQty + ' gelas';
    document.getElementById('racik-qty-total-label').textContent = '(' + racikQty + ' gelas)';
    const mobileTotal = document.getElementById('racik-total-mobile');
    if (mobileTotal) mobileTotal.textContent = (subtotal * racikQty).toLocaleString('id-ID');
    const headerTotal = document.getElementById('live-total-header');
    if (headerTotal) headerTotal.textContent = 'Rp ' + (subtotal * racikQty).toLocaleString('id-ID');
}

function changeRacikQty(change) {
    racikQty = Math.max(1, racikQty + change);
    document.getElementById('racik-qty').textContent = racikQty;
    updateSummary();
}

function submitRacik() {
    const btn = document.getElementById('btn-racik-submit');
    const btnMobile = document.getElementById('btn-racik-submit-mobile');

    const setLoading = (loading) => {
        [btn, btnMobile].filter(Boolean).forEach(b => {
            if (!b) return;
            b.disabled = loading;
            b.innerHTML = loading
                ? '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i><span>Memproses...</span>'
                : '<i data-lucide="shopping-bag" class="w-5 h-5"></i><span>Tambahkan ke Keranjang</span>';
        });
    };

    setLoading(true);

    if (document.querySelectorAll('input[name="bahan"]:checked').length === 0) {
        showToast('Pilih minimal 1 bahan buah atau sayur', '');
        setLoading(false);
        return;
    }

    const selectedOpsi = [];
    document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked').forEach(input => {
        if (input.name.startsWith('standar_') || ['ukuran', 'cairan', 'bahan', 'tambahan'].includes(input.name)) {
            selectedOpsi.push(parseInt(input.value));
        }
    });

    fetch('/customer/keranjang/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ id_menu: 3, jumlah: racikQty, opsi: selectedOpsi })
    })
    .then(async res => {
        if (!res.ok) {
            if (res.status === 401) { window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname); return; }
            const err = await res.json().catch(() => ({}));
            throw new Error(err.message || 'Gagal menambahkan ke keranjang');
        }
        return res.json();
    })
    .then(data => {
        if (data && data.success) {
            showToast('Berhasil ditambahkan ke keranjang', '');
            if (typeof bounceFloatingCart === 'function') bounceFloatingCart();
            setTimeout(() => { window.location.href = '{{ route("customer.keranjang") }}'; }, 1200);
        } else if (data) {
            showToast(data.message || 'Gagal', '');
        }
    })
    .catch(err => { showToast(err.message, ''); })
    .finally(() => { setLoading(false); if (typeof lucide !== 'undefined') lucide.createIcons(); });
}
</script>
@endsection