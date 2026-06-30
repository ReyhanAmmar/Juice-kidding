<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel — Juice Kidding">
    <title>@yield('title', 'Dashboard') — Admin Juice Kidding</title>

    {{-- Google Fonts: Nunito --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary:   { DEFAULT: '#E17D19', light: '#FDF3E7', dark: '#C45E0A' },
                    secondary: { DEFAULT: '#96C84B', light: '#EEF7D8', dark: '#6E9A2A' },
                    accent: {
                        red: '#E11919', yellow: '#E1C819',
                        blue: '#194B96', purple: '#7D4B96',
                        pink: '#E14B7D', green: '#AFC84B',
                    },
                    brand: { dark: '#1A1820' },
                },
                fontFamily: { sans: ['Nunito', 'sans-serif'] },
                boxShadow: {
                    card:      '0 2px 16px 0 rgba(0,0,0,0.07)',
                    'card-lg': '0 8px 32px 0 rgba(0,0,0,0.10)',
                    btn:       '0 4px 16px 0 rgba(225,125,25,0.35)',
                    'btn-green':'0 4px 16px 0 rgba(150,200,75,0.35)',
                    nav:       '0 -2px 16px 0 rgba(0,0,0,0.08)',
                },
                borderRadius: { '2xl':'1rem','3xl':'1.5rem','4xl':'2rem' },
            }
        }
    }
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.35s ease-out forwards; }

        @keyframes scaleIn {
            from { transform: scale(0.7); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }
        .animate-scale-in { animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }

        /* Custom scrollbar */
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 999px; }

        /* Sidebar transition */
        .sidebar-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
    </style>

    @yield('head')
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- Mobile Sidebar Overlay --}}
        <div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main Content Area --}}
        <div class="flex-1 lg:ml-64 flex flex-col overflow-hidden">

            {{-- Topbar --}}
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-3">
                    {{-- Mobile hamburger --}}
                    <button onclick="toggleSidebar()" class="lg:hidden w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-all">
                        <i data-lucide="menu" class="w-5 h-5 text-gray-600"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-black text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-[11px] text-gray-400 font-medium hidden sm:block">@yield('page-subtitle', 'Selamat datang di panel admin')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Search desktop --}}
                    <div class="hidden md:flex items-center bg-gray-50 rounded-xl px-3 py-2 gap-2 border-2 border-transparent focus-within:border-primary focus-within:bg-white transition-all">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        <input type="text" placeholder="Cari..." class="bg-transparent text-sm font-medium text-gray-700 outline-none placeholder-gray-300 w-44">
                    </div>
                    {{-- Notification --}}
                    <button class="relative w-9 h-9 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-all">
                        <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-accent-red rounded-full border-2 border-white"></span>
                    </button>
                    {{-- Avatar --}}
                    <div class="w-9 h-9 rounded-full bg-primary text-white font-black text-sm flex items-center justify-center shadow-btn">
                        {{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-4 lg:px-8 py-6 custom-scroll">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div id="toast"
         class="fixed top-4 left-1/2 -translate-x-1/2 z-[60]
                bg-brand-dark text-white text-sm font-bold
                px-5 py-3 rounded-2xl shadow-card-lg
                flex items-center gap-2.5 min-w-max
                opacity-0 -translate-y-16 pointer-events-none transition-all duration-300 ease-out"
         aria-live="polite">
        <span class="text-base" id="toast-emoji">🔔</span>
        <span id="toast-msg">Notifikasi</span>
        <div class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full"
             style="background:linear-gradient(90deg,#E11919,#E17D19,#96C84B,#194B96,#7D4B96)"></div>
    </div>

    <script>lucide.createIcons();</script>

    <script>
    // Toggle sidebar mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('active');
    }

    // Toast
    function showToast(msg, emoji = '🔔', duration = 3500) {
        const t = document.getElementById('toast');
        document.getElementById('toast-msg').textContent = msg;
        document.getElementById('toast-emoji').textContent = emoji;
        t.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
        t.classList.add('opacity-100', 'translate-y-0');
        setTimeout(() => {
            t.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
            t.classList.remove('opacity-100', 'translate-y-0');
        }, duration);
    }
    </script>

    @yield('scripts')
</body>
</html>
