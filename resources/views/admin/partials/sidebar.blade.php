{{-- Admin Sidebar — Section 7.7 desain.md --}}
<aside id="admin-sidebar"
       class="w-64 min-h-screen bg-brand-dark flex flex-col fixed left-0 top-0 z-50
              transition-transform duration-300 ease-in-out
              -translate-x-full lg:translate-x-0">

    {{-- Logo Area --}}
    <div class="px-6 py-5 border-b border-white/10">
        <div class="flex items-center justify-between">
            <img src="{{ asset('images/nama_brand.png') }}"
                 alt="Juice Kidding"
                 class="h-7 w-auto brightness-0 invert opacity-90">
            {{-- Close button mobile --}}
            <button onclick="toggleSidebar()" class="lg:hidden w-8 h-8 rounded-lg flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <span class="block text-white/30 text-[10px] font-bold tracking-widest uppercase mt-1">
            Admin Panel
        </span>
        {{-- Rainbow bar --}}
        <div class="h-0.5 w-full mt-3 rounded-full"
             style="background:linear-gradient(90deg,#E11919,#E17D19,#E1C819,#96C84B,#194B96,#7D4B96)"></div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto custom-scroll">
        
        {{-- UTAMA --}}
        <div class="mb-2">
            <p class="px-3 py-2 text-[10px] font-bold text-white/40 uppercase tracking-widest mb-1">Utama</p>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- KATALOG & MENU --}}
        @php 
            $isKatalogActive = request()->routeIs('admin.kategori.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.tipe-opsi.*') || request()->routeIs('admin.opsi-kustomisasi.*') || request()->routeIs('admin.racik-opsi.*'); 
        @endphp
        <div class="mb-2">
            <button onclick="toggleSidebarGroup('group-katalog', 'chevron-katalog')" class="w-full flex items-center justify-between px-3 py-2 text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-white/80 transition-colors focus:outline-none">
                <span>Katalog & Menu</span>
                <i data-lucide="chevron-down" id="chevron-katalog" class="w-3.5 h-3.5 transition-transform duration-200 {{ $isKatalogActive ? '' : '-rotate-90' }}"></i>
            </button>
            <div id="group-katalog" class="space-y-1 mt-1 overflow-hidden transition-all duration-300 {{ $isKatalogActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.kategori.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="layers" class="w-4 h-4 flex-shrink-0"></i>
                    Kelola Kategori
                </a>

                <a href="{{ route('admin.menu.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.menu.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="package" class="w-4 h-4 flex-shrink-0"></i>
                    Kelola Menu Jus
                </a>
                
                <div class="pt-1">
                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-white/50 hover:text-white hover:bg-white/10 font-semibold text-sm"
                       onclick="toggleKustomisasiMenu(event)">
                        <i data-lucide="settings-2" class="w-4 h-4 flex-shrink-0"></i>
                        Kustomisasi Menu
                        <i data-lucide="chevron-down" class="w-4 h-4 flex-shrink-0 ml-auto transition-transform duration-200" id="kustomisasi-chevron"></i>
                    </a>
                    <div id="kustomisasi-submenu" class="hidden pl-8 mt-1 space-y-1">
                        <a href="{{ route('admin.tipe-opsi.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all text-sm
                                  {{ request()->routeIs('admin.tipe-opsi.*') ? 'bg-primary/20 text-primary font-bold' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            <i data-lucide="layers" class="w-3.5 h-3.5 flex-shrink-0"></i>
                            Tipe Opsi
                        </a>
                        <a href="{{ route('admin.opsi-kustomisasi.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all text-sm
                                  {{ request()->routeIs('admin.opsi-kustomisasi.*') ? 'bg-primary/20 text-primary font-bold' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            <i data-lucide="list" class="w-3.5 h-3.5 flex-shrink-0"></i>
                            Opsi Kustomisasi
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.racik-opsi.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.racik-opsi.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="flask-conical" class="w-4 h-4 flex-shrink-0"></i>
                    Racik Sendiri
                </a>
            </div>
        </div>

        {{-- LAYANAN & KONTEN --}}
        @php $isLayananActive = request()->routeIs('admin.paket-langganan.*') || request()->routeIs('admin.artikel.*'); @endphp
        <div class="mb-2">
            <button onclick="toggleSidebarGroup('group-layanan', 'chevron-layanan')" class="w-full flex items-center justify-between px-3 py-2 text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-white/80 transition-colors focus:outline-none">
                <span>Layanan & Konten</span>
                <i data-lucide="chevron-down" id="chevron-layanan" class="w-3.5 h-3.5 transition-transform duration-200 {{ $isLayananActive ? '' : '-rotate-90' }}"></i>
            </button>
            <div id="group-layanan" class="space-y-1 mt-1 overflow-hidden transition-all duration-300 {{ $isLayananActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.paket-langganan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.paket-langganan.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="sparkles" class="w-4 h-4 flex-shrink-0"></i>
                    Kelola Paket Langganan
                </a>

                <a href="{{ route('admin.artikel.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.artikel.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
                    Kelola Artikel
                </a>
            </div>
        </div>

        {{-- TRANSAKSI & LAPORAN --}}
        @php $isTransaksiActive = request()->routeIs('admin.pesanan*') || request()->routeIs('admin.laporan'); @endphp
        <div class="mb-2">
            <button onclick="toggleSidebarGroup('group-transaksi', 'chevron-transaksi')" class="w-full flex items-center justify-between px-3 py-2 text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-white/80 transition-colors focus:outline-none">
                <span>Transaksi & Laporan</span>
                <i data-lucide="chevron-down" id="chevron-transaksi" class="w-3.5 h-3.5 transition-transform duration-200 {{ $isTransaksiActive ? '' : '-rotate-90' }}"></i>
            </button>
            <div id="group-transaksi" class="space-y-1 mt-1 overflow-hidden transition-all duration-300 {{ $isTransaksiActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.pesanan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.pesanan*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="receipt" class="w-4 h-4 flex-shrink-0"></i>
                    Kelola Transaksi
                </a>

                <a href="{{ route('admin.laporan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.laporan') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 flex-shrink-0"></i>
                    Laporan Penjualan
                </a>
            </div>
        </div>

        {{-- PENGATURAN --}}
        @php $isPengaturanActive = request()->routeIs('admin.pengaturan') || request()->routeIs('admin.alamat-toko.*'); @endphp
        <div class="mb-2">
            <button onclick="toggleSidebarGroup('group-sistem', 'chevron-sistem')" class="w-full flex items-center justify-between px-3 py-2 text-[10px] font-bold text-white/40 uppercase tracking-widest hover:text-white/80 transition-colors focus:outline-none">
                <span>Sistem</span>
                <i data-lucide="chevron-down" id="chevron-sistem" class="w-3.5 h-3.5 transition-transform duration-200 {{ $isPengaturanActive ? '' : '-rotate-90' }}"></i>
            </button>
            <div id="group-sistem" class="space-y-1 mt-1 overflow-hidden transition-all duration-300 {{ $isPengaturanActive ? '' : 'hidden' }}">
                <a href="{{ route('admin.pengaturan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                          {{ request()->routeIs('admin.pengaturan') || request()->routeIs('admin.alamat-toko.*') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
                    <i data-lucide="settings" class="w-4 h-4 flex-shrink-0"></i>
                    Pengaturan Sistem
                </a>
            </div>
        </div>
    </nav>

    {{-- User Info & Profile Menu --}}
    <div class="px-3 py-4 border-t border-white/10 relative">
        {{-- Dropdown Menu (Hidden by default) --}}
        <div id="profile-menu" class="absolute bottom-full left-3 right-3 mb-2 bg-zinc-900 border border-white/10 rounded-2xl shadow-xl overflow-hidden transition-all duration-200 opacity-0 invisible translate-y-2 origin-bottom">
            <div class="p-2 space-y-1">
                <div class="px-3 py-2 text-white/50 text-[10px] font-bold uppercase tracking-widest border-b border-white/5 mb-1">
                    Menu Akun
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm font-bold text-accent-red hover:bg-white/5 rounded-xl transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>

        {{-- Toggle Button --}}
        <button onclick="toggleProfileMenu()" class="w-full flex items-center gap-3 p-2 hover:bg-white/5 rounded-2xl transition-all group focus:outline-none">
            <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white font-black text-sm flex-shrink-0 shadow-btn group-hover:scale-105 transition-transform">
                {{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}
            </div>
            <div class="min-w-0 text-left flex-1">
                <p class="text-white text-xs font-bold truncate">{{ Auth::user()->nama_lengkap ?? 'Admin JK' }}</p>
                <p class="text-white/30 text-[10px] truncate group-hover:text-white/50 transition-colors">{{ Auth::user()->email ?? 'admin@juicekidding.id' }}</p>
            </div>
            <i data-lucide="chevron-up" id="profile-chevron" class="w-4 h-4 text-white/30 group-hover:text-white/60 transition-all duration-300"></i>
        </button>
    </div>
</aside>

<script>
    // Toggle submenu kustomisasi
    function toggleKustomisasiMenu(event) {
        event.preventDefault();
        const submenu = document.getElementById('kustomisasi-submenu');
        const chevron = document.getElementById('kustomisasi-chevron');

        if (submenu && chevron) {
            const isHidden = submenu.classList.contains('hidden');
            submenu.classList.toggle('hidden');
            chevron.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    // Toggle Sidebar Group
    function toggleSidebarGroup(groupId, chevronId) {
        const group = document.getElementById(groupId);
        const chevron = document.getElementById(chevronId);
        
        if (group && chevron) {
            const isHidden = group.classList.contains('hidden');
            group.classList.toggle('hidden');
            chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(-90deg)';
        }
    }

    // Toggle Profile Menu
    function toggleProfileMenu() {
        const menu = document.getElementById('profile-menu');
        const chevron = document.getElementById('profile-chevron');
        
        if (menu && chevron) {
            const isHidden = menu.classList.contains('opacity-0');
            
            if (isHidden) {
                menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                menu.classList.add('opacity-100', 'visible', 'translate-y-0');
                chevron.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                chevron.style.transform = 'rotate(0deg)';
            }
        }
    }
    
    // Close profile menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('profile-menu');
        const button = event.target.closest('button[onclick="toggleProfileMenu()"]');
        
        if (menu && !menu.classList.contains('opacity-0') && !button && !menu.contains(event.target)) {
            menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            document.getElementById('profile-chevron').style.transform = 'rotate(0deg)';
        }
    });
</script>
