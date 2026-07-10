@extends('layouts.main')
@section('content')
    <div class="pt-[101px] pb-16 bg-gradient-to-b from-fuchsia-50 to-white min-h-screen">
        <div class="max-w-[900px] mx-auto px-4 md:px-8">

            {{-- Page Header --}}
            <div class="mb-10">
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 text-zinc-500 hover:text-amber-700 text-sm font-semibold font-['Nunito'] transition-colors mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
                </a>
                <h1 class="text-zinc-900 text-3xl md:text-4xl font-black font-['Nunito']">Profil Saya</h1>
                <p class="text-zinc-500 text-sm font-medium font-['Nunito'] mt-1">Kelola informasi akun dan keamananmu.</p>
            </div>

            {{-- Success Toast --}}
            @if(session('success'))
            <div class="mb-6 px-5 py-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 animate-fade-in-up">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <span class="text-green-800 text-sm font-semibold font-['Nunito']">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('success_password'))
            <div class="mb-6 px-5 py-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 animate-fade-in-up">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <span class="text-green-800 text-sm font-semibold font-['Nunito']">{{ session('success_password') }}</span>
            </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- ===== LEFT: Profile Card ===== --}}
                <div class="lg:w-[280px] shrink-0">
                    <div class="bg-white rounded-3xl shadow-[0px_8px_30px_rgba(0,0,0,0.06)] border border-zinc-100 p-8 flex flex-col items-center text-center sticky top-[110px]">
                        {{-- Avatar --}}
                        <div class="relative group mb-5">
                            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-amber-200 shadow-lg">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/'.$user->foto_profil) }}" alt="{{ $user->nama_lengkap }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                                        <span class="text-white text-4xl font-black font-['Nunito']">{{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            {{-- Camera overlay --}}
                            <label for="foto-input" class="absolute bottom-0 right-0 w-9 h-9 bg-amber-600 rounded-full flex items-center justify-center cursor-pointer shadow-md hover:bg-amber-700 transition-colors border-2 border-white">
                                <i data-lucide="camera" class="w-4 h-4 text-white"></i>
                            </label>
                        </div>

                        {{-- Name & Role --}}
                        <h2 class="text-zinc-900 text-xl font-bold font-['Nunito'] leading-tight">{{ $user->nama_lengkap }}</h2>
                        <span class="text-amber-600 text-xs font-bold font-['Nunito'] bg-amber-50 px-3 py-1 rounded-full mt-2">{{ $user->role->nama_role ?? 'Customer' }}</span>

                        {{-- Stats --}}
                        <div class="w-full mt-6 pt-6 border-t border-zinc-100">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-zinc-500 text-xs font-semibold font-['Nunito']">Poin Reward</span>
                                <span class="text-amber-700 text-lg font-black font-['Nunito']">{{ number_format($user->poin ?? 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-zinc-500 text-xs font-semibold font-['Nunito']">Member Sejak</span>
                                <span class="text-zinc-700 text-sm font-bold font-['Nunito']">{{ $user->created_at ? $user->created_at->format('M Y') : '-' }}</span>
                            </div>
                        </div>

                        {{-- Quick Actions --}}
                        <div class="w-full mt-6 pt-6 border-t border-zinc-100 flex flex-col gap-2">
                            <a href="{{ route('customer.riwayat') }}" class="w-full py-2.5 px-4 rounded-xl text-left text-sm font-semibold text-zinc-600 hover:bg-amber-50 hover:text-amber-700 transition-colors font-['Nunito'] flex items-center gap-3">
                                <i data-lucide="receipt" class="w-4 h-4"></i> Pesanan Saya
                            </a>
                            <a href="{{ route('customer.keranjang') }}" class="w-full py-2.5 px-4 rounded-xl text-left text-sm font-semibold text-zinc-600 hover:bg-amber-50 hover:text-amber-700 transition-colors font-['Nunito'] flex items-center gap-3">
                                <i data-lucide="shopping-bag" class="w-4 h-4"></i> Keranjang
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-left text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors font-['Nunito'] flex items-center gap-3 cursor-pointer">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ===== RIGHT: Forms ===== --}}
                <div class="flex-1 flex flex-col gap-8">

                    {{-- Poin Reward --}}
                    <div class="bg-white rounded-3xl shadow-[0px_8px_30px_rgba(0,0,0,0.06)] border border-zinc-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-zinc-100 flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                <span class="text-lg">🪙</span>
                            </div>
                            <div>
                                <h3 class="text-zinc-900 text-lg font-bold font-['Nunito']">Poin Reward</h3>
                                <p class="text-zinc-500 text-xs font-medium font-['Nunito']">Kumpulkan dan gunakan poin untuk diskon.</p>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="flex items-center gap-6 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                                    <span class="text-3xl font-black text-white">{{ number_format($user->poin ?? 0) }}</span>
                                </div>
                                <div>
                                    <p class="text-zinc-900 text-lg font-black font-['Nunito']">{{ number_format($user->poin ?? 0, 0, ',', '.') }} Poin</p>
                                    <p class="text-zinc-500 text-xs font-medium font-['Nunito']">Saldo poin aktif</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 rounded-2xl bg-green-50 border border-green-100">
                                    <p class="text-green-700 text-sm font-black font-['Nunito'] flex items-center gap-1.5">
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i> Cara Mendapatkan
                                    </p>
                                    <p class="text-green-600 text-xs font-medium font-['Nunito'] mt-1.5">Cashback 1% dari total belanja setiap kali pesanan lunas.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-orange-50 border border-orange-100">
                                    <p class="text-orange-700 text-sm font-black font-['Nunito'] flex items-center gap-1.5">
                                        <i data-lucide="shopping-cart" class="w-4 h-4"></i> Cara Menggunakan
                                    </p>
                                    <p class="text-orange-600 text-xs font-medium font-['Nunito'] mt-1.5">Tukarkan poin di halaman checkout untuk potongan harga.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informasi Pribadi --}}
                    <div class="bg-white rounded-3xl shadow-[0px_8px_30px_rgba(0,0,0,0.06)] border border-zinc-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-zinc-100 flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="user-circle" class="w-5 h-5 text-amber-600"></i>
                            </div>
                            <div>
                                <h3 class="text-zinc-900 text-lg font-bold font-['Nunito']">Informasi Pribadi</h3>
                                <p class="text-zinc-500 text-xs font-medium font-['Nunito']">Perbarui nama, email, dan nomor teleponmu.</p>
                            </div>
                        </div>
                        <form action="{{ route('customer.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                            @csrf
                            @method('PUT')

                            {{-- Hidden file input for avatar --}}
                            <input type="file" name="foto_profil" id="foto-input" class="hidden" accept="image/*" onchange="this.form.submit()">

                            {{-- Nama Lengkap --}}
                            <div class="mb-6">
                                <label for="nama_lengkap" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                                        class="w-full pl-11 pr-4 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                </div>
                                @error('nama_lengkap')
                                    <p class="mt-1 text-red-500 text-xs font-semibold font-['Nunito']">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-6">
                                <label for="email" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Email</label>
                                <div class="relative">
                                    <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                        class="w-full pl-11 pr-4 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-red-500 text-xs font-semibold font-['Nunito']">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div class="mb-8">
                                <label for="no_hp" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Nomor Telepon</label>
                                <div class="relative">
                                    <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx"
                                        class="w-full pl-11 pr-4 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                </div>
                                @error('no_hp')
                                    <p class="mt-1 text-red-500 text-xs font-semibold font-['Nunito']">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 rounded-xl text-white text-sm font-bold font-['Nunito'] transition-all active:scale-95 shadow-md shadow-amber-600/20 flex items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    {{-- Ubah Password --}}
                    <div class="bg-white rounded-3xl shadow-[0px_8px_30px_rgba(0,0,0,0.06)] border border-zinc-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-zinc-100 flex items-center gap-3">
                            <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                                <i data-lucide="lock" class="w-5 h-5 text-rose-600"></i>
                            </div>
                            <div>
                                <h3 class="text-zinc-900 text-lg font-bold font-['Nunito']">Ubah Password</h3>
                                <p class="text-zinc-500 text-xs font-medium font-['Nunito']">Pastikan passwordmu kuat dan unik.</p>
                            </div>
                        </div>
                        <form action="{{ route('customer.profil.password') }}" method="POST" class="p-8">
                            @csrf
                            @method('PUT')

                            {{-- Current Password --}}
                            <div class="mb-6">
                                <label for="current_password" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Password Lama</label>
                                <div class="relative">
                                    <i data-lucide="key-round" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="password" name="current_password" id="current_password" placeholder="••••••••"
                                        class="w-full pl-11 pr-12 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                    <button type="button" onclick="togglePassword('current_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-zinc-600">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="mt-1 text-red-500 text-xs font-semibold font-['Nunito']">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="mb-6">
                                <label for="new_password" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Password Baru</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="password" name="new_password" id="new_password" placeholder="Minimal 8 karakter"
                                        class="w-full pl-11 pr-12 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                    <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-zinc-600">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <p class="mt-1 text-red-500 text-xs font-semibold font-['Nunito']">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-8">
                                <label for="new_password_confirmation" class="block text-zinc-700 text-sm font-bold font-['Nunito'] mb-2">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-500"></i>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Ulangi password baru"
                                        class="w-full pl-11 pr-12 py-3 bg-zinc-50 rounded-xl border border-zinc-200 text-sm font-semibold font-['Nunito'] text-zinc-800 placeholder-zinc-400 outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 transition-all">
                                    <button type="button" onclick="togglePassword('new_password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-zinc-600">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="px-8 py-3 bg-rose-600 hover:bg-rose-700 rounded-xl text-white text-sm font-bold font-['Nunito'] transition-all active:scale-95 shadow-md shadow-rose-600/20 flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                                Ubah Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }
    </script>
@endsection
