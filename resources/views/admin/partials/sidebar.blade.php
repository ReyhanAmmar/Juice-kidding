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
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto custom-scroll">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                  {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
            <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
            Dashboard
        </a>

        <a href="#"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-white/50 hover:text-white hover:bg-white/10 font-semibold text-sm">
            <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
            Kelola Artikel
        </a>

        <a href="{{ route('admin.kelola-menu') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all
                  {{ request()->routeIs('admin.kelola-menu') ? 'bg-primary text-white font-bold shadow-btn' : 'text-white/50 hover:text-white hover:bg-white/10 font-semibold' }} text-sm">
            <i data-lucide="package" class="w-4 h-4 flex-shrink-0"></i>
            Kelola Produk
        </a>

        <a href="#"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-white/50 hover:text-white hover:bg-white/10 font-semibold text-sm">
            <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
            Kelola Pengguna
        </a>

        <a href="#"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-white/50 hover:text-white hover:bg-white/10 font-semibold text-sm">
            <i data-lucide="receipt" class="w-4 h-4 flex-shrink-0"></i>
            Kelola Transaksi
        </a>
    </nav>

    {{-- User Info --}}
    <div class="px-4 py-4 border-t border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white font-black text-sm flex-shrink-0 shadow-btn">
                {{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}
            </div>
            <div class="min-w-0">
                <p class="text-white text-xs font-bold truncate">{{ Auth::user()->nama_lengkap ?? 'Admin JK' }}</p>
                <p class="text-white/30 text-[10px] truncate">{{ Auth::user()->email ?? 'admin@juicekidding.id' }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="ml-auto flex-shrink-0">
                @csrf
                <button type="submit" class="text-white/30 hover:text-accent-red transition-all" title="Logout">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
