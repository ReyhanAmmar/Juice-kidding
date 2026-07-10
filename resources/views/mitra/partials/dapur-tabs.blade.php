<div class="flex items-center gap-2 mb-8 overflow-x-auto pb-2 hide-scrollbar">
    @if(Auth::user() && in_array(Auth::user()->id_role, [1, 3]))
    <a href="{{ route('dapur.dashboard') }}" class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full font-bold font-['Nunito'] transition-all {{ request()->routeIs('dapur.dashboard') ? 'bg-[#E17D19] text-white shadow-[0_4px_16px_0_rgba(225,125,25,0.35)]' : 'bg-white text-[#9B97A8] hover:bg-[#FDF3E7] hover:text-[#E17D19] border border-[#E8E6F0]' }}">
        <i data-lucide="layout-dashboard" class="w-4 h-4" aria-hidden="true"></i>
        Dashboard
    </a>
    <a href="{{ route('dapur.antrian') }}" class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full font-bold font-['Nunito'] transition-all {{ request()->routeIs('dapur.antrian') ? 'bg-[#E17D19] text-white shadow-[0_4px_16px_0_rgba(225,125,25,0.35)]' : 'bg-white text-[#9B97A8] hover:bg-[#FDF3E7] hover:text-[#E17D19] border border-[#E8E6F0]' }}">
        <i data-lucide="receipt" class="w-4 h-4" aria-hidden="true"></i>
        Antrian Pesanan
    </a>
    <a href="{{ route('dapur.stok') }}" class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full font-bold font-['Nunito'] transition-all {{ request()->routeIs('dapur.stok') ? 'bg-[#E17D19] text-white shadow-[0_4px_16px_0_rgba(225,125,25,0.35)]' : 'bg-white text-[#9B97A8] hover:bg-[#FDF3E7] hover:text-[#E17D19] border border-[#E8E6F0]' }}">
        <i data-lucide="package" class="w-4 h-4" aria-hidden="true"></i>
        Stok Bahan
    </a>
    <a href="{{ route('dapur.riwayat') }}" class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full font-bold font-['Nunito'] transition-all {{ request()->routeIs('dapur.riwayat') ? 'bg-[#E17D19] text-white shadow-[0_4px_16px_0_rgba(225,125,25,0.35)]' : 'bg-white text-[#9B97A8] hover:bg-[#FDF3E7] hover:text-[#E17D19] border border-[#E8E6F0]' }}">
        <i data-lucide="clipboard-list" class="w-4 h-4" aria-hidden="true"></i>
        Riwayat
    </a>
    @endif

    @if(Auth::user() && in_array(Auth::user()->id_role, [1, 4]))
    <a href="{{ route('driver.pengantaran') }}" class="shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full font-bold font-['Nunito'] transition-all {{ request()->routeIs('driver.pengantaran') ? 'bg-[#96C84B] text-white shadow-[0_4px_16px_0_rgba(150,200,75,0.35)]' : 'bg-white text-[#9B97A8] hover:bg-[#EEF7D8] hover:text-[#96C84B] border border-[#E8E6F0]' }}">
        <i data-lucide="truck" class="w-4 h-4" aria-hidden="true"></i>
        Pengantaran
    </a>
    @endif
</div>