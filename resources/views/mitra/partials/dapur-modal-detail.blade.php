<div id="detail-modal-{{ $pesanan->id_pesanan }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh] animate-scale-in">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-zinc-100 flex items-center justify-between sticky top-0 bg-white z-10">
            <div>
                <h3 class="text-xl font-black text-zinc-900">Detail Pesanan</h3>
                <p class="text-xs font-bold text-amber-600 mt-0.5">#{{ $pesanan->kode_pesanan }}</p>
            </div>
            <button type="button" onclick="closeDetailModal({{ $pesanan->id_pesanan }})" class="p-2 text-zinc-400 hover:text-zinc-600 hover:bg-zinc-100 rounded-xl transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 overflow-y-auto custom-scrollbar">
            {{-- Info Pelanggan & Waktu --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-zinc-50 p-3.5 rounded-2xl border border-zinc-100">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block mb-1">Pelanggan</span>
                    <p class="text-sm font-black text-zinc-900 truncate">{{ $pesanan->customer->nama_lengkap ?? 'Guest' }}</p>
                </div>
                <div class="bg-zinc-50 p-3.5 rounded-2xl border border-zinc-100">
                    <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-wider block mb-1">Waktu Pesan</span>
                    <p class="text-sm font-black text-zinc-900">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M, H:i') }}</p>
                </div>
            </div>

            {{-- Tipe Pesanan --}}
            <div class="mb-6">
                <h4 class="text-xs font-black text-zinc-900 uppercase tracking-wider mb-3">Tipe Pengiriman</h4>
                <div class="flex items-start gap-3 p-4 rounded-2xl border {{ $pesanan->id_tipe_pesanan == 2 ? 'bg-purple-50/50 border-purple-100' : 'bg-blue-50/50 border-blue-100' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $pesanan->id_tipe_pesanan == 2 ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                        <i data-lucide="{{ $pesanan->id_tipe_pesanan == 2 ? 'bike' : 'store' }}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black {{ $pesanan->id_tipe_pesanan == 2 ? 'text-purple-900' : 'text-blue-900' }}">
                            {{ $pesanan->id_tipe_pesanan == 2 ? 'Delivery' : 'Pick-up' }}
                        </p>
                        <p class="text-xs font-medium mt-1 {{ $pesanan->id_tipe_pesanan == 2 ? 'text-purple-700/70' : 'text-blue-700/70' }}">
                            @if($pesanan->id_tipe_pesanan == 2)
                                {{ $pesanan->alamat_snapshot ?? ($pesanan->alamat->alamat_lengkap ?? 'Alamat tidak ditemukan') }}
                            @else
                                Pelanggan akan mengambil pesanan di toko.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Daftar Menu --}}
            <div>
                <h4 class="text-xs font-black text-zinc-900 uppercase tracking-wider mb-3">Item Pesanan ({{ $pesanan->detail_pesanan->sum('jumlah') }})</h4>
                <div class="space-y-3">
                    @foreach($pesanan->detail_pesanan as $detail)
                    @php
                        $isRacikItem = $detail->menu && $detail->menu->id_kategori == 3;
                    @endphp
                    <div class="p-4 rounded-2xl border {{ $isRacikItem ? 'bg-purple-50/30 border-purple-100' : 'bg-white border-zinc-200' }}">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $isRacikItem ? 'bg-purple-100 text-purple-700' : 'bg-zinc-100 text-zinc-700' }} flex items-center justify-center shrink-0 font-black text-sm">
                                {{ $detail->jumlah }}x
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="text-sm font-black text-zinc-900 leading-tight">
                                    {{ $detail->nama_menu_snapshot }}
                                    @if($isRacikItem)
                                        <span class="text-[9px] bg-purple-200 text-purple-700 px-1.5 py-0.5 rounded font-black uppercase align-middle ml-1">Racik</span>
                                    @endif
                                </h5>
                                
                                @if($detail->opsi && $detail->opsi->count() > 0)
                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    @foreach($detail->opsi as $opsi)
                                    <span class="inline-flex items-center text-[10px] font-bold px-2 py-1 rounded-lg {{ $isRacikItem ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-700' }}">
                                        {{ $opsi->nama_opsi_snapshot }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Catatan Tambahan --}}
            @if($pesanan->catatan)
            <div class="mt-6">
                <h4 class="text-xs font-black text-zinc-900 uppercase tracking-wider mb-2">Catatan Pembeli</h4>
                <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                    <i data-lucide="message-square" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5"></i>
                    <p class="text-sm font-bold text-amber-800 italic">"{{ $pesanan->catatan }}"</p>
                </div>
            </div>
            @endif
        </div>
        
        {{-- Footer --}}
        <div class="px-6 py-5 border-t border-zinc-100 bg-zinc-50 sticky bottom-0 text-right">
            <button type="button" onclick="closeDetailModal({{ $pesanan->id_pesanan }})" class="px-6 py-2.5 bg-zinc-200 hover:bg-zinc-300 text-zinc-700 font-bold rounded-xl transition-all active:scale-95 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
