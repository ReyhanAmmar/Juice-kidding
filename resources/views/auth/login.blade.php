@extends('layouts.main')

@section('content')
<section class="min-h-screen relative px-8 pt-[120px] pb-12 flex items-center justify-center overflow-hidden bg-orange-50/50">
    {{-- Decorative blobs --}}
    <div class="size-96 absolute right-[-100px] top-[100px] bg-yellow-400/20 rounded-full blur-[40px] pointer-events-none"></div>
    <div class="size-64 absolute left-[-50px] bottom-[50px] bg-pink-400/20 rounded-full blur-[40px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in-up">
        {{-- Card --}}
        <div class="bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-[0_8px_40px_rgba(0,0,0,0.06)] border border-black/5">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding" class="h-20 mx-auto mb-4 animate-bounce-slow">
                <h1 class="text-3xl font-black text-zinc-900 mb-2" style="font-family: 'Nunito', sans-serif;">Selamat Datang! 🍹</h1>
                <p class="text-sm font-medium text-stone-500 font-['Nunito_Sans']">Yuk masuk ke akunmu untuk pesan jus segar favorit.</p>
            </div>

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf
                
                {{-- Email Input --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-bold text-zinc-700 ml-2 font-['Nunito_Sans']">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-zinc-400"></i>
                        </div>
                        <input type="email" name="email" id="email" placeholder="contoh@email.com" required
                               class="w-full pl-11 pr-4 py-3.5 bg-zinc-50 border-2 border-zinc-100 rounded-full text-base font-medium text-zinc-900 placeholder-zinc-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all font-['Nunito_Sans']">
                    </div>
                </div>

                {{-- Password Input --}}
                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-bold text-zinc-700 ml-2 font-['Nunito_Sans']">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-zinc-400"></i>
                        </div>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                               class="w-full pl-11 pr-4 py-3.5 bg-zinc-50 border-2 border-zinc-100 rounded-full text-base font-medium text-zinc-900 placeholder-zinc-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all font-['Nunito_Sans']">
                    </div>
                    <div class="text-right mt-1">
                        <a href="#" class="text-sm font-bold text-amber-600 hover:text-amber-800 transition-colors font-['Nunito_Sans']">Lupa Password?</a>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full py-4 mt-2 bg-gradient-to-r from-amber-600 to-orange-500 rounded-full shadow-[0px_4px_16px_rgba(225,125,25,0.35)] hover:shadow-lg active:scale-95 transition-all flex justify-center items-center gap-2 group">
                    <span class="text-white text-lg font-black tracking-wide" style="font-family: 'Nunito', sans-serif;">Masuk Sekarang</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm font-medium text-stone-500 font-['Nunito_Sans']">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-amber-600 font-bold hover:text-amber-800 transition-colors">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
