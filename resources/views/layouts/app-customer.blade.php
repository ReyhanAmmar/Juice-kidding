<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Juice Kidding')</title>

    {{-- Google Fonts: Nunito (brand primary) + Nunito Sans (fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400..900;1,400..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
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
                fontFamily: { sans: ['Nunito', 'Nunito Sans', 'sans-serif'] },
                boxShadow: {
                    card:      '0 2px 16px 0 rgba(0,0,0,0.07)',
                    'card-lg': '0 8px 32px 0 rgba(0,0,0,0.10)',
                    btn:       '0 4px 16px 0 rgba(225,125,25,0.35)',
                    'btn-green':'0 4px 16px 0 rgba(150,200,75,0.35)',
                    nav:       '0 -2px 16px 0 rgba(0,0,0,0.08)',
                },
            }
        }
    }
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * { font-family: 'Nunito', 'Nunito Sans', sans-serif; }

        /* ===== Design Tokens ===== */
        :root {
            --color-primary: #E17D19;
            --color-primary-dark: #C45E0A;
            --color-primary-light: #FDF3E7;
            --color-secondary: #96C84B;
            --color-success: #16A34A;
            --color-error: #DC2626;
            --color-warning: #D97706;
            --color-info: #2563EB;
            --text-body: #27272a;
            --text-secondary: #52525b;
            --text-muted: #71717a;
            --text-inverse: #ffffff;
            --surface-elevated: #fafafa;
            --border-subtle: #e4e4e7;
            --z-toast: 100;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-scale-in { animation: scaleIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen md:pb-0 pb-16">

    @php
        $isDapur = Auth::check() && Auth::user()->id_role == 3;
    @endphp

    {{-- Container: Wide for Dapur on desktop, restricted for Driver/mobile --}}
    <div class="{{ $isDapur ? 'w-full max-w-full md:max-w-6xl' : 'max-w-md' }} mx-auto bg-white min-h-screen shadow-lg relative flex flex-col justify-between">
        
        {{-- Header Bar --}}
        <header class="bg-white border-b border-zinc-100 px-4 py-4 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo_maskot.png') }}" alt="Logo" class="h-8">
                <span class="text-primary font-black text-lg font-['Nunito']" style="font-family: 'Nunito', sans-serif;">Juice Kidding</span>
            </div>
            
            {{-- Desktop Dapur Navigation Links inside Header --}}
            @if($isDapur)
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('dapur.dashboard') }}" class="text-xs font-black uppercase tracking-wider flex items-center gap-1.5 {{ request()->routeIs('dapur.dashboard') ? 'text-primary' : 'text-zinc-500 hover:text-primary transition-colors' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                </a>
                <a href="{{ route('dapur.antrian') }}" class="text-xs font-black uppercase tracking-wider flex items-center gap-1.5 {{ request()->routeIs('dapur.antrian') ? 'text-primary' : 'text-zinc-500 hover:text-primary transition-colors' }}">
                    <i data-lucide="chef-hat" class="w-4 h-4"></i> Antrian Dapur
                </a>
                <a href="{{ route('dapur.stok') }}" class="text-xs font-black uppercase tracking-wider flex items-center gap-1.5 {{ request()->routeIs('dapur.stok') ? 'text-primary' : 'text-zinc-500 hover:text-primary transition-colors' }}">
                    <i data-lucide="package" class="w-4 h-4"></i> Kelola Stok
                </a>
            </div>
            @endif
            
            <div class="flex items-center gap-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-red-50 text-red-500 flex items-center gap-1 text-xs font-black hover:bg-red-500 hover:text-white transition-all active:scale-95 cursor-pointer" title="Logout">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span class="hidden md:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Main Page Content --}}
        <main class="flex-1 @yield('main-class')">
            @yield('content')
        </main>

        {{-- Bottom navigation bar for partners --}}
        <nav class="bg-white border-t border-zinc-100 fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md z-40 h-16 flex items-center justify-around px-2 shadow-nav md:hidden">
            @if(Auth::check() && Auth::user()->id_role == 3)
                {{-- Dapur Navigation --}}
                <a href="{{ route('dapur.dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('dapur.dashboard') ? 'text-primary font-bold' : 'text-zinc-500 font-semibold' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="text-[10px] mt-0.5">Dashboard</span>
                </a>
                <a href="{{ route('dapur.antrian') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('dapur.antrian') ? 'text-primary font-bold' : 'text-zinc-500 font-semibold' }}">
                    <i data-lucide="chef-hat" class="w-5 h-5"></i>
                    <span class="text-[10px] mt-0.5">Antrian Dapur</span>
                </a>
                <a href="{{ route('dapur.stok') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('dapur.stok') ? 'text-primary font-bold' : 'text-zinc-500 font-semibold' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span class="text-[10px] mt-0.5">Kelola Stok</span>
                </a>
            @elseif(Auth::check() && Auth::user()->id_role == 4)
                {{-- Driver Navigation --}}
                <a href="{{ route('driver.pengantaran') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('driver.pengantaran') ? 'text-primary font-bold' : 'text-zinc-500 font-semibold' }}">
                    <i data-lucide="truck" class="w-5 h-5"></i>
                    <span class="text-[10px] mt-0.5">Pengantaran</span>
                </a>
            @endif
        </nav>
    </div>

    {{-- Toast notification --}}
    <div id="toast" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] bg-zinc-900 text-white shadow-lg rounded-2xl px-5 py-3.5 flex items-center gap-2.5 pointer-events-none opacity-0 -translate-y-16 transition-all duration-300">
        <span id="toast-emoji" class="text-base">👨‍🍳</span>
        <span id="toast-msg" class="text-xs font-bold font-['Nunito']"></span>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    function showToast(msg, emoji = '👨‍🍳', duration = 3000) {
        const t = document.getElementById('toast');
        const m = document.getElementById('toast-msg');
        const e = document.getElementById('toast-emoji');
        if (m) m.textContent = msg;
        if (e) e.textContent = emoji;
        if (t) {
            t.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
            t.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                t.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
                t.classList.remove('opacity-100', 'translate-y-0');
            }, duration);
        }
    }
    </script>

    @yield('scripts')
</body>
</html>
