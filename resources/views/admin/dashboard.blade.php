@extends('layouts.app-admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas hari ini')

@section('content')
{{-- Stat Cards (Section 7.8) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-6">

    {{-- Card 1: Pesanan Hari Ini --}}
    <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-primary animate-fade-in-up">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pesanan Hari Ini</p>
                <p class="text-3xl font-black text-gray-900 mt-1">142</p>
                <p class="text-xs font-semibold text-secondary mt-1">▲ 12% dari kemarin</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-primary-light flex items-center justify-center">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-primary"></i>
            </div>
        </div>
    </div>

    {{-- Card 2: Pendapatan --}}
    <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-secondary animate-fade-in-up" style="animation-delay: 80ms">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pendapatan</p>
                <p class="text-3xl font-black text-gray-900 mt-1">2,4jt</p>
                <p class="text-xs font-semibold text-secondary mt-1">▲ 8% dari kemarin</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-secondary-light flex items-center justify-center">
                <i data-lucide="trending-up" class="w-5 h-5 text-secondary-dark"></i>
            </div>
        </div>
    </div>

    {{-- Card 3: Pick-up --}}
    <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-accent-blue animate-fade-in-up" style="animation-delay: 160ms">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pick-up</p>
                <p class="text-3xl font-black text-gray-900 mt-1">89</p>
                <p class="text-xs font-semibold text-gray-400 mt-1">→ Sama seperti kemarin</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center">
                <i data-lucide="store" class="w-5 h-5 text-accent-blue"></i>
            </div>
        </div>
    </div>

    {{-- Card 4: Delivery --}}
    <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-accent-purple animate-fade-in-up" style="animation-delay: 240ms">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Delivery</p>
                <p class="text-3xl font-black text-gray-900 mt-1">53</p>
                <p class="text-xs font-semibold text-secondary mt-1">▲ 5% dari kemarin</p>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-purple-50 flex items-center justify-center">
                <i data-lucide="truck" class="w-5 h-5 text-accent-purple"></i>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders Table --}}
<div class="bg-white rounded-2xl shadow-card overflow-hidden animate-fade-in-up" style="animation-delay: 320ms">
    <div class="px-4 lg:px-6 py-4 flex items-center justify-between border-b border-gray-100">
        <h3 class="font-black text-gray-900">Pesanan Terbaru</h3>
        <span class="text-xs font-bold text-gray-400">Hari ini</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Kode</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Customer</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Tipe</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                    <th class="text-right px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                {{-- Row 1 --}}
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-6 py-4 font-bold text-primary">JK-001</td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-accent-blue text-white text-[10px] font-black flex items-center justify-center flex-shrink-0">R</div>
                            <span class="font-bold text-gray-900">Reyhan</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden sm:table-cell">
                        <span class="flex items-center gap-1"><i data-lucide="bike" class="w-3 h-3"></i> Delivery</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp 53.000</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-blue bg-blue-100 px-2.5 py-1 rounded-full">● Baru</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

                {{-- Row 2 --}}
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-6 py-4 font-bold text-primary">JK-002</td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-accent-pink text-white text-[10px] font-black flex items-center justify-center flex-shrink-0">S</div>
                            <span class="font-bold text-gray-900">Sarah</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden sm:table-cell">
                        <span class="flex items-center gap-1"><i data-lucide="store" class="w-3 h-3"></i> Pick-up</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp 35.000</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">● Diproses</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

                {{-- Row 3 --}}
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-6 py-4 font-bold text-primary">JK-003</td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-secondary text-white text-[10px] font-black flex items-center justify-center flex-shrink-0">A</div>
                            <span class="font-bold text-gray-900">Ahmad</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden sm:table-cell">
                        <span class="flex items-center gap-1"><i data-lucide="bike" class="w-3 h-3"></i> Delivery</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp 72.000</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-secondary-dark bg-secondary-light px-2.5 py-1 rounded-full">● Selesai</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

                {{-- Row 4 --}}
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-6 py-4 font-bold text-primary">JK-004</td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-accent-purple text-white text-[10px] font-black flex items-center justify-center flex-shrink-0">D</div>
                            <span class="font-bold text-gray-900">Diana</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden sm:table-cell">
                        <span class="flex items-center gap-1"><i data-lucide="store" class="w-3 h-3"></i> Pick-up</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp 18.000</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-accent-red bg-red-100 px-2.5 py-1 rounded-full">● Dibatalkan</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>

                {{-- Row 5 --}}
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-4 lg:px-6 py-4 font-bold text-primary">JK-005</td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-primary text-white text-[10px] font-black flex items-center justify-center flex-shrink-0">B</div>
                            <span class="font-bold text-gray-900">Budi</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden sm:table-cell">
                        <span class="flex items-center gap-1"><i data-lucide="bike" class="w-3 h-3"></i> Delivery</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp 45.000</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">● Diproses</span>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
