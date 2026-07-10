<nav id="dapur-navbar" class="fixed top-0 left-0 right-0 z-50 bg-[#1A1820]/95 backdrop-blur-md shadow-[0_2px_24px_0_rgba(0,0,0,0.15)]">
    {{-- Rainbow accent bar --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-[#E11919] via-[#E17D19] via-[#E1C819] via-[#96C84B] via-[#194B96] via-[#7D4B96] to-[#E14B7D]"></div>

    <div class="max-w-[900px] mx-auto px-4 md:px-8 h-14 flex items-center justify-between gap-4">
        {{-- Logo + Brand (static) --}}
        <div class="flex items-center gap-3 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#E17D19] to-[#C45E0A] flex items-center justify-center shadow-sm">
                    <span class="text-white text-sm font-black">JK</span>
                </div>
                <span class="text-[10px] font-bold text-[#E17D19] tracking-wider">DAPUR</span>
            </div>
        </div>

        {{-- Nav tabs --}}
        <div class="flex items-center gap-1">
            @if(request()->routeIs('dapur.dashboard'))
                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] bg-white/15 text-white flex items-center gap-1.5">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Dashboard
                </span>
            @else
                <a href="{{ route('dapur.dashboard') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] transition-all text-white/50 hover:text-white hover:bg-white/10 flex items-center gap-1.5">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Dashboard
                </a>
            @endif

            @if(request()->routeIs('dapur.antrian'))
                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] bg-white/15 text-white flex items-center gap-1.5">
                    <i data-lucide="receipt" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Antrian
                </span>
            @else
                <a href="{{ route('dapur.antrian') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] transition-all text-white/50 hover:text-white hover:bg-white/10 flex items-center gap-1.5">
                    <i data-lucide="receipt" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Antrian
                </a>
            @endif

            @if(request()->routeIs('dapur.stok'))
                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] bg-white/15 text-white flex items-center gap-1.5">
                    <i data-lucide="package" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Stok
                </span>
            @else
                <a href="{{ route('dapur.stok') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] transition-all text-white/50 hover:text-white hover:bg-white/10 flex items-center gap-1.5">
                    <i data-lucide="package" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Stok
                </a>
            @endif

            @if(request()->routeIs('dapur.riwayat'))
                <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] bg-white/15 text-white flex items-center gap-1.5">
                    <i data-lucide="clipboard-list" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Riwayat
                </span>
            @else
                <a href="{{ route('dapur.riwayat') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] transition-all text-white/50 hover:text-white hover:bg-white/10 flex items-center gap-1.5">
                    <i data-lucide="clipboard-list" class="w-3.5 h-3.5" aria-hidden="true"></i>
                    Riwayat
                </a>
            @endif

            @if(Auth::user() && in_array(Auth::user()->id_role, [1, 4]))
                @if(request()->routeIs('driver.pengantaran'))
                    <span class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] bg-white/15 text-white flex items-center gap-1.5">
                        <i data-lucide="truck" class="w-3.5 h-3.5" aria-hidden="true"></i>
                        Pengantaran
                    </span>
                @else
                    <a href="{{ route('driver.pengantaran') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold font-['Nunito'] transition-all text-white/50 hover:text-white hover:bg-white/10 flex items-center gap-1.5">
                        <i data-lucide="truck" class="w-3.5 h-3.5" aria-hidden="true"></i>
                        Pengantaran
                    </a>
                @endif
            @endif
        </div>

        {{-- User --}}
        <div class="flex items-center gap-2 shrink-0">
            <div class="relative" id="dapur-user-dropdown-wrapper">
                <button id="dapur-user-dropdown-btn" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-white/10 transition-colors cursor-pointer group">
                    <div class="w-7 h-7 rounded-full overflow-hidden ring-2 ring-[#E17D19]/40 group-hover:ring-[#E17D19]/70 transition-all">
                        @if(Auth::user() && Auth::user()->foto_profil)
                            <img src="{{ asset('storage/'.Auth::user()->foto_profil) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#E17D19] to-[#C45E0A] flex items-center justify-center">
                                <span class="text-white text-[10px] font-black">{{ Auth::user() ? strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) : '?' }}</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-white/80 text-xs font-bold font-['Nunito'] hidden sm:block">{{ Auth::user() ? Auth::user()->nama_lengkap : 'User' }}</span>
                    <i data-lucide="chevron-down" class="w-3 h-3 text-white/30" aria-hidden="true"></i>
                </button>
                {{-- Dropdown --}}
                <div id="dapur-user-dropdown-menu" class="absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-[0px_10px_40px_rgba(0,0,0,0.15)] border border-[#E8E6F0] py-2 opacity-0 invisible translate-y-2 transition-all duration-200 z-50">
                    <div class="px-4 py-2.5 border-b border-[#E8E6F0]">
                        <p class="text-[#1A1820] text-sm font-bold font-['Nunito'] truncate">{{ Auth::user() ? Auth::user()->nama_lengkap : 'User' }}</p>
                        <p class="text-[#9B97A8] text-xs font-medium truncate">{{ Auth::user() ? Auth::user()->email : '' }}</p>
                    </div>
                    <div class="border-t border-[#E8E6F0] pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-[#E11919]/5 transition-colors cursor-pointer">
                                <i data-lucide="log-out" class="w-4 h-4 text-[#E11919]" aria-hidden="true"></i>
                                <span class="text-[#E11919] text-sm font-bold font-['Nunito']">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
    const ddBtn = document.getElementById('dapur-user-dropdown-btn');
    const ddMenu = document.getElementById('dapur-user-dropdown-menu');
    if (ddBtn && ddMenu) {
        ddBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = !ddMenu.classList.contains('invisible');
            if (isOpen) {
                ddMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                ddMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            } else {
                ddMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                ddMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
            }
        });
        document.addEventListener('click', function(e) {
            if (!document.getElementById('dapur-user-dropdown-wrapper')?.contains(e.target)) {
                ddMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                ddMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            }
        });
    }
});
</script>