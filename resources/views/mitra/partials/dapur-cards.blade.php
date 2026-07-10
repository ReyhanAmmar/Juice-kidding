@if($pesanan->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($pesanan as $p)
        <div class="bg-white rounded-2xl shadow-[0_2px_16px_0_rgba(0,0,0,0.07)] border border-[#E8E6F0] {{ $p->id_tipe_pesanan == 2 && $p->detail_pesanan->contains(function($d) { return $d->menu->id_kategori == 3; }) ? 'shadow-[0_4px_16px_0_rgba(125,75,150,0.12)]' : '' }} overflow-hidden flex flex-col dapur-card">
            <!-- Card Header -->
            <div class="px-5 py-4 border-b border-[#E8E6F0] flex justify-between items-center {{ $p->id_status_pesanan == 1 ? 'bg-[#194B96]/5' : 'bg-[#FDF3E7]' }}">
                <div>
                    <span class="text-lg font-black text-[#E17D19]">
                        #{{ $p->kode_pesanan }}
                        @if($p->metode_pembayaran == 'Langganan')
                            <span class="ml-1 text-[9px] bg-[#7D4B96] text-white px-2 py-0.5 rounded-full font-black uppercase inline-flex items-center gap-0.5 align-middle">
                                <i data-lucide="sparkles" class="w-2.5 h-2.5"></i> Langganan
                            </span>
                        @endif
                    </span>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $p->id_tipe_pesanan == 1 ? 'bg-[#194B96]/10 text-[#194B96]' : 'bg-[#96C84B]/15 text-[#6E9A2A]' }}">
                            <i data-lucide="{{ $p->id_tipe_pesanan == 1 ? 'store' : 'bike' }}" class="w-3 h-3" aria-hidden="true"></i>
                            {{ $p->id_tipe_pesanan == 1 ? 'Pick-up' : 'Delivery' }}
                        </span>
                        <span class="text-xs font-bold text-[#9B97A8] flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3" aria-hidden="true"></i>
                            {{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('H:i') }}
                        </span>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $p->id_status_pesanan == 1 ? 'bg-[#194B96]/10 border-[#194B96]/30 text-[#194B96]' : 'bg-[#FDF3E7] border-[#E17D19]/30 text-[#C45E0A]' }}">
                    {{ $p->id_status_pesanan == 1 ? 'Pesanan Baru' : 'Sedang Diproses' }}
                </span>
            </div>

            <!-- Items List -->
            <div class="p-5 flex-1 bg-white">
                <ul class="space-y-4">
                    @foreach($p->detail_pesanan as $detail)
                    @php
                        $isRacikSendiri = $detail->menu && $detail->menu->id_kategori == 3;
                    @endphp
                    <li class="flex items-start gap-3 p-3 rounded-xl {{ $isRacikSendiri ? 'bg-[#7D4B96]/5 border border-[#7D4B96]/20' : 'bg-[#F8F7FC] border border-[#E8E6F0]' }}">
                        <div class="w-8 h-8 rounded-lg {{ $isRacikSendiri ? 'bg-[#7D4B96]/20 text-[#7D4B96]' : 'bg-[#E8E6F0] text-[#3D3A4A]' }} flex items-center justify-center shrink-0 font-bold text-sm">
                            {{ $detail->jumlah }}x
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-[#1A1820] {{ $isRacikSendiri ? 'text-[#7D4B96]' : '' }}">
                                {{ $detail->nama_menu_snapshot }}
                                @if($isRacikSendiri)
                                    <span class="ml-1 text-[10px] bg-[#7D4B96]/25 text-[#7D4B96] px-1.5 py-0.5 rounded font-bold uppercase">Racikan</span>
                                @endif
                            </h4>

                            @if($detail->opsi && $detail->opsi->count() > 0)
                                <div class="mt-1.5 flex flex-wrap gap-1.5">
                                    @foreach($detail->opsi as $opsi)
                                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-md bg-white border border-[#E8E6F0] text-[#3D3A4A] shadow-sm">
                                        {{ $opsi->nama_opsi_snapshot }}
                                    </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>

                @if($p->catatan)
                    <div class="mt-4 p-3 bg-[#FDF3E7] border border-[#E17D19]/20 rounded-xl flex gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-[#C45E0A] shrink-0 mt-0.5" aria-hidden="true"></i>
                        <p class="text-xs font-medium text-[#C45E0A] italic">"{{ $p->catatan }}"</p>
                    </div>
                @endif
            </div>

            <!-- Action Footer -->
            <div class="p-4 border-t border-[#E8E6F0] bg-[#F8F7FC] flex gap-2">
                <button type="button" onclick="showDetailModal({{ $p->id_pesanan }})" class="p-2.5 bg-white border border-[#E8E6F0] text-[#3D3A4A] rounded-xl hover:bg-[#F8F7FC] transition-all active:scale-[0.98] shadow-sm flex items-center justify-center">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </button>
                <form class="dapur-status-form flex-1" data-pesanan-id="{{ $p->id_pesanan }}">
                    @csrf
                    @method('PUT')
                    @if($p->id_status_pesanan == 1)
                        <input type="hidden" name="status" value="2">
                        <button type="submit" class="w-full py-2.5 bg-[#E17D19] hover:bg-[#C45E0A] text-white rounded-xl font-bold font-['Nunito'] transition-all active:scale-95 flex items-center justify-center gap-2 shadow-[0_4px_16px_0_rgba(225,125,25,0.35)] focus-visible:ring-2 focus-visible:ring-[#E17D19] focus-visible:outline-none">
                            <i data-lucide="play-circle" class="w-4 h-4" aria-hidden="true"></i> Mulai Proses
                        </button>
                    @elseif($p->id_status_pesanan == 2)
                        <input type="hidden" name="status" value="3">
                        <button type="submit" class="w-full py-2.5 bg-[#96C84B] hover:bg-[#6E9A2A] text-white rounded-xl font-bold font-['Nunito'] transition-all active:scale-95 flex items-center justify-center gap-2 shadow-[0_4px_16px_0_rgba(150,200,75,0.35)] focus-visible:ring-2 focus-visible:ring-[#96C84B] focus-visible:outline-none">
                            <i data-lucide="check-circle" class="w-4 h-4" aria-hidden="true"></i> Tandai Siap
                        </button>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-3xl p-12 shadow-[0_2px_16px_0_rgba(0,0,0,0.07)] border border-[#E8E6F0] text-center flex flex-col items-center">
        <div class="w-20 h-20 bg-[#EEF7D8] rounded-full flex items-center justify-center mb-4">
            <i data-lucide="sparkles" class="w-10 h-10 text-[#96C84B]" aria-hidden="true"></i>
        </div>
        <h3 class="text-xl font-black text-[#1A1820] font-['Nunito'] mb-2 text-wrap-balance">Semua Pesanan Selesai!</h3>
        <p class="text-[#9B97A8] font-medium mb-6">Belum ada pesanan baru masuk saat ini. Waktunya istirahat sejenak.</p>
        <div class="flex items-center gap-3">
            <a href="{{ route('dapur.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#E17D19] hover:bg-[#C45E0A] text-white text-sm font-bold rounded-xl transition-all active:scale-95 shadow-[0_4px_16px_0_rgba(225,125,25,0.35)] focus-visible:ring-2 focus-visible:ring-[#E17D19] focus-visible:outline-none">
                <i data-lucide="layout-dashboard" class="w-4 h-4" aria-hidden="true"></i>
                Lihat Dashboard
            </a>
            <a href="{{ route('dapur.stok') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-[#FDF3E7] text-[#E17D19] text-sm font-bold rounded-xl border-2 border-[#E8E6F0] hover:border-[#E17D19] transition-all active:scale-95 focus-visible:ring-2 focus-visible:ring-[#E17D19] focus-visible:outline-none">
                <i data-lucide="package" class="w-4 h-4" aria-hidden="true"></i>
                Cek Stok Bahan
            </a>
        </div>
    </div>
@endif