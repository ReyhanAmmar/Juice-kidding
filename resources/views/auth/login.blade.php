@extends('layouts.main', ['hideHeader' => true, 'hideFooter' => true])

@section('content')
<section class="min-h-screen relative px-8 pt-[120px] pb-12 flex items-center justify-center overflow-hidden bg-orange-50/50">
    {{-- Decorative blobs --}}
    <div class="size-96 absolute right-[-100px] top-[100px] bg-yellow-400/20 rounded-full blur-[40px] pointer-events-none"></div>
    <div class="size-64 absolute left-[-50px] bottom-[50px] bg-pink-400/20 rounded-full blur-[40px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in-up">
        {{-- Card --}}
        <div class="bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-[0_8px_40px_rgba(0,0,0,0.06)] border border-black/5">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding" class="h-20 mx-auto mb-4 animate-float-gentle">
                <h1 class="text-3xl font-black text-zinc-900 mb-2" style="font-family: 'Nunito', sans-serif;">Selamat Datang! 🍹</h1>
                <p class="text-sm font-medium text-stone-600 font-['Nunito']">Yuk masuk ke akunmu untuk pesan jus segar favorit.</p>
            </div>



                <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold border border-red-100 font-['Nunito']">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                {{-- Email Input --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-bold text-zinc-700 ml-2 font-['Nunito']">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-5 h-5 text-zinc-500"></i>
                        </div>
                        <input type="email" name="email" id="email" placeholder="contoh@email.com" required
                               class="w-full pl-11 pr-4 py-3.5 bg-zinc-50 border-2 border-zinc-100 rounded-full text-base font-medium text-zinc-900 placeholder-zinc-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all font-['Nunito']">
                    </div>
                </div>

                {{-- Password Input --}}
                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-bold text-zinc-700 ml-2 font-['Nunito']">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-5 h-5 text-zinc-500"></i>
                        </div>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                               class="w-full pl-11 pr-4 py-3.5 bg-zinc-50 border-2 border-zinc-100 rounded-full text-base font-medium text-zinc-900 placeholder-zinc-400 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/20 transition-all font-['Nunito']">
                    </div>
                    <div class="text-right mt-1">
                        <a href="#" class="text-sm font-bold text-amber-600 hover:text-amber-800 transition-colors font-['Nunito']">Lupa Password?</a>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full py-4 mt-2 bg-gradient-to-r from-amber-600 to-orange-500 rounded-full shadow-[0px_4px_16px_rgba(225,125,25,0.35)] hover:shadow-lg active:scale-95 transition-all flex justify-center items-center gap-2 group">
                    <span class="text-white text-lg font-black tracking-wide" style="font-family: 'Nunito', sans-serif;">Masuk Sekarang</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            {{-- Divider --}}
            <div class="my-6 flex items-center justify-between">
                <span class="w-1/5 border-b border-stone-200"></span>
                <span class="text-xs font-bold text-stone-500 uppercase tracking-wider">atau masuk dengan</span>
                <span class="w-1/5 border-b border-stone-200"></span>
            </div>

            {{-- Google Login Button --}}
            <a href="{{ route('google.login') }}" class="w-full py-3.5 border-2 border-stone-200 hover:border-amber-500 rounded-full flex justify-center items-center gap-3 transition-all active:scale-95 group bg-white">
                <svg class="w-5 h-5 group-hover:scale-105 transition-transform" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.6h3.24c1.9,-1.75 3,-4.32 3,-7.4C21.6,12.1 21.5,11.6 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.4c2.57,0 4.72,-0.85 6.3,-2.3l-3.24,-2.6c-0.9,0.6 -2.05,0.96 -3.06,0.96 -2.36,0 -4.36,-1.59 -5.07,-3.73H3.61v2.52C5.19,17.93 8.35,20.4 12,20.4z" fill="#34A853" />
                        <path d="M6.93,12.73c-0.18,-0.54 -0.28,-1.11 -0.28,-1.73s0.1,-1.19 0.28,-1.73V6.75H3.61c-0.6,1.2 -0.94,2.56 -0.94,4.02s0.34,2.82 0.94,4.02L6.93,12.73z" fill="#FBBC05" />
                        <path d="M12,6.38c1.4,0 2.65,0.48 3.64,1.43l2.73,-2.73C16.71,3.52 14.56,2.7 12,2.7c-3.65,0 -6.81,2.47 -8.39,5.08l3.32,2.57C7.64,7.97 9.64,6.38 12,6.38z" fill="#EA4335" />
                    </g>
                </svg>
                <span class="text-zinc-700 hover:text-amber-800 text-sm font-bold font-['Nunito']">Masuk dengan Google</span>
            </a>

            <div class="mt-8 text-center">
                <p class="text-sm font-medium text-stone-600 font-['Nunito']">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-amber-600 font-bold hover:text-amber-800 transition-colors">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
