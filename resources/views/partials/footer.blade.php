    {{-- ===== FOOTER ===== --}}
    <footer class="w-full px-8 py-16 bg-white border-t border-zinc-100 flex flex-col justify-center items-center relative overflow-hidden mt-12">
        <div class="max-w-[1280px] w-full mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            {{-- Brand --}}
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo_maskot.png') }}" alt="Juice Kidding" class="h-10">
                    <span class="text-amber-600 text-2xl font-black font-['Nunito'] tracking-tight">Juice Kidding</span>
                </div>
                <p class="text-zinc-500 text-sm font-medium font-['Nunito'] leading-relaxed mb-6">Squeeze the day! Nikmati kesegaran jus cold-pressed 100% organik langsung di depan pintumu.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-pink-100 hover:text-pink-600 transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-green-100 hover:text-green-600 transition-colors"><i data-lucide="message-circle" class="w-5 h-5"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-600 hover:bg-blue-100 hover:text-blue-600 transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                </div>
            </div>

            {{-- Links --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito'] mb-4">Eksplorasi</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('menu') }}" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Katalog Menu</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Langganan Mingguan</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Diskon Poin</a></li>
                </ul>
            </div>

            {{-- Support & Education --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito'] mb-4">Jelajahi</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('artikel.index') }}" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Artikel & Edukasi</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-zinc-500 hover:text-amber-800 text-sm font-medium transition-colors">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- Partners --}}
            <div class="col-span-1">
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito'] mb-4">Tersedia di</h4>
                <div class="flex gap-4 mb-6">
                    <div class="w-16 h-16 bg-zinc-50 rounded-2xl border border-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-500">Gofood</div>
                    <div class="w-16 h-16 bg-zinc-50 rounded-2xl border border-zinc-200 flex items-center justify-center text-xs font-bold text-zinc-500">Grab</div>
                </div>
                <h4 class="text-zinc-900 text-lg font-bold font-['Nunito'] mb-4">Pembayaran</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">QRIS</span>
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">GoPay</span>
                    <span class="px-3 py-1 bg-zinc-100 rounded text-xs font-bold text-zinc-500">BCA</span>
                </div>
            </div>
        </div>
        <div class="w-full max-w-[1280px] mx-auto mt-12 pt-8 border-t border-zinc-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-zinc-500 text-sm font-medium font-['Nunito']">&copy; {{ date('Y') }} Juice Kidding. Squeeze the Day!</span>
            <div class="text-zinc-500 text-sm font-medium font-['Nunito'] flex items-center gap-1">
                Dibuat dengan <i data-lucide="heart" class="w-4 h-4 text-red-500 fill-red-500"></i> di Indonesia
            </div>
        </div>
    </footer>
