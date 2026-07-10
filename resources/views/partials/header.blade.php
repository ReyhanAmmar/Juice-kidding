    {{-- ===== NAVBAR ===== --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/70 backdrop-blur-md shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] border-b border-zinc-200/50">
        {{-- Rainbow bar --}}
        <div class="h-1 w-full bg-gradient-to-r from-red-600 via-amber-600 via-16% to-pink-500"></div>

        <div class="w-full max-w-[1280px] mx-auto h-20 px-8 flex justify-between items-center gap-8">
            {{-- Logo --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('beranda') }}">
                    <img class="h-10 w-auto hover:scale-105 transition-transform" src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding Logo">
                </a>
                <a href="{{ route('beranda') }}" class="flex items-center hover:opacity-90 transition-opacity">
                    <span class="text-[34px] font-black tracking-tight pt-1 flex items-center leading-none" style="font-family: 'Nunito', sans-serif;">
                        <span class="text-[#E92429]">J</span>
                        <span class="text-[#F47920]">u</span>
                        <span class="text-[#FDC310]">i</span>
                        <span class="text-[#9BCA3C]">c</span>
                        <span class="text-[#9BCA3C]">e</span>
                        <span class="w-2"></span>
                        <span class="text-[#1B5B9C]">K</span>
                        <span class="text-[#466EB4]">i</span>
                        <span class="text-[#8C4799]">d</span>
                        <span class="text-[#E73E86]">d</span>
                        <span class="text-[#F05A28]">i</span>
                        <span class="text-[#F58220]">n</span>
                        <span class="text-[#9BCA3C]">g</span>
                    </span>
                </a>
            </div>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-[480px]">
                <div class="w-full relative flex justify-center items-center">
                    <div class="w-full pl-11 pr-4 py-2.5 bg-white rounded-full shadow-sm border border-zinc-200 overflow-hidden focus-within:ring-2 focus-within:ring-amber-500/20 focus-within:border-amber-500 transition-all">
                        <input type="text" placeholder="Cari jus favoritmu..."
                               class="w-full bg-transparent text-sm font-medium font-['Nunito'] text-gray-900 placeholder-gray-400 outline-none">
                    </div>
                    <div class="absolute left-4">
                        <i data-lucide="search" class="w-4 h-4 text-zinc-500"></i>
                    </div>
                </div>
            </div>

            {{-- Nav Links & Actions --}}
            <div class="flex items-center gap-8 shrink-0">
                {{-- Nav Links --}}
                <div class="flex items-center gap-6">
                    <a href="{{ route('menu') }}" class="py-1 group">
                        <span class="text-stone-600 group-hover:text-amber-800 text-[15px] font-bold font-['Nunito'] transition-colors">Menu</span>
                    </a>
                    <a href="{{ route('customer.racik') }}" class="py-1 group">
                        <span class="text-stone-600 group-hover:text-amber-800 text-[15px] font-bold font-['Nunito'] transition-colors">Racik Sendiri</span>
                    </a>
                    <a href="{{ route('langganan.index') }}" class="py-1 group">
                        <span class="text-stone-600 group-hover:text-amber-800 text-[15px] font-bold font-['Nunito'] transition-colors">Langganan</span>
                    </a>
                </div>

                <div class="w-px h-6 bg-zinc-200"></div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    @auth
                        @php
                            $cartCount = 0;
                            if (Auth::user()->id_role == 2) {
                                $cartCount = \App\Models\Keranjang::where('id_customer', Auth::id())->sum('jumlah');
                            }
                        @endphp
                        @if(Auth::user()->id_role == 2)
                        <a href="{{ route('customer.keranjang') }}" class="w-9 h-9 rounded-full flex justify-center items-center hover:bg-amber-50 transition-colors relative">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-amber-800"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @endif
                        {{-- User Dropdown --}}
                        <div class="relative" id="user-dropdown-wrapper">
                            <button id="user-dropdown-btn" class="flex items-center gap-2 px-2 py-1.5 rounded-full hover:bg-amber-50 transition-colors cursor-pointer">
                                <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-amber-300 shadow-sm">
                                    @if(Auth::user()->foto_profil)
                                        <img src="{{ asset('storage/'.Auth::user()->foto_profil) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                                            <span class="text-white text-xs font-black">{{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-zinc-500"></i>
                            </button>
                            {{-- Dropdown Menu --}}
                            <div id="user-dropdown-menu" class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-[0px_10px_40px_rgba(0,0,0,0.12)] border border-zinc-100 py-2 opacity-0 invisible translate-y-2 transition-all duration-200 z-50">
                                {{-- User Info --}}
                                <div class="px-4 py-3 border-b border-zinc-100">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <p class="text-zinc-900 text-sm font-bold font-['Nunito'] truncate">{{ Auth::user()->nama_lengkap }}</p>
                                        @if(Auth::user()->id_role == 2)
                                        <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded text-[10px] font-black border border-amber-200 shrink-0">
                                            <i data-lucide="award" class="w-3 h-3"></i> {{ Auth::user()->poin ?? 0 }} Poin
                                        </span>
                                        @endif
                                    </div>
                                    <p class="text-zinc-500 text-xs font-medium font-['Nunito'] truncate">{{ Auth::user()->email }}</p>
                                </div>
                                {{-- Links --}}
                                <div class="py-1">
                                    @if(Auth::user()->id_role == 1)
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Dashboard Admin</span>
                                        </a>
                                    @elseif(Auth::user()->id_role == 3)
                                        <a href="{{ route('dapur.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="layout-dashboard" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Dashboard Dapur</span>
                                        </a>
                                    @elseif(Auth::user()->id_role == 4)
                                        <a href="{{ route('driver.pengantaran') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="truck" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Pengantaran Driver</span>
                                        </a>
                                    @else
                                        <a href="{{ route('customer.profil') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="user-circle" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Profil Saya</span>
                                        </a>
                                        <a href="{{ route('customer.riwayat') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="receipt" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Pesanan Saya</span>
                                        </a>
                                        <a href="{{ route('customer.tracking') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors">
                                            <i data-lucide="map-pin" class="w-4 h-4 text-zinc-500"></i>
                                            <span class="text-zinc-700 text-sm font-semibold font-['Nunito']">Lacak Pesanan</span>
                                        </a>
                                    @endif
                                </div>
                                {{-- Logout --}}
                                <div class="border-t border-zinc-100 pt-1">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors cursor-pointer">
                                            <i data-lucide="log-out" class="w-4 h-4 text-red-400"></i>
                                            <span class="text-red-500 text-sm font-semibold font-['Nunito']">Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('customer.keranjang') ?? '#' }}" class="w-9 h-9 rounded-full flex justify-center items-center hover:bg-amber-50 transition-colors">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-amber-800"></i>
                        </a>
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-amber-600 rounded-full text-white text-sm font-bold font-['Nunito'] hover:bg-amber-700 transition-all active:scale-95 shadow-sm flex items-center gap-2">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            Masuk
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>
