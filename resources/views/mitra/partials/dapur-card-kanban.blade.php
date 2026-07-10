@php
    $isRacik = $order->detail_pesanan->contains(fn($d) => $d->menu && $d->menu->id_kategori == 3);
    $statusLabel = $order->id_status_pesanan == 1 ? 'Pesanan Baru' : ($order->id_status_pesanan == 2 ? 'Diproses' : 'Siap');
    $statusBadge = $order->id_status_pesanan == 1 ? 'bg-blue-100 text-blue-700' : ($order->id_status_pesanan == 2 ? 'bg-amber-100 text-amber-700' : 'bg-purple-100 text-purple-700');
    $isDelivery = $order->id_tipe_pesanan == 2;
@endphp

<div class="kanban-card bg-white rounded-2xl border border-zinc-200/70 shadow-sm overflow-hidden hover:shadow-md">
    {{-- Header: Order code + status badge --}}
    <div class="px-4 py-3 flex items-center justify-between gap-2 border-b border-zinc-100">
        <div class="flex items-center gap-2 min-w-0">
            <span class="text-sm font-black text-amber-700 truncate">#{{ $order->kode_pesanan }}</span>
            @if($order->metode_pembayaran == 'Langganan')
                <span class="text-[8px] bg-purple-600 text-white px-1.5 py-0.5 rounded font-black uppercase">SUB</span>
            @endif
            <span class="text-[10px] font-bold text-zinc-400 flex items-center gap-1 whitespace-nowrap">
                <i data-lucide="clock" class="w-3 h-3" aria-hidden="true"></i>
                {{ \Carbon\Carbon::parse($order->tanggal_pesan)->format('H:i') }}
            </span>
        </div>
        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $statusBadge }} whitespace-nowrap">{{ $statusLabel }}</span>
    </div>

    {{-- Body: Items --}}
    <div class="px-4 py-3 space-y-2.5">
        @foreach($order->detail_pesanan as $detail)
        @php
            $isRacikItem = $detail->menu && $detail->menu->id_kategori == 3;
        @endphp
        <div class="{{ $isRacikItem ? 'bg-purple-50 border border-purple-200' : 'bg-zinc-50 border border-zinc-100' }} rounded-xl p-3">
            {{-- Menu name — very large and clear --}}
            <div class="flex items-start justify-between gap-2">
                <h4 class="text-base font-black text-zinc-900 leading-tight {{ $isRacikItem ? 'text-purple-800' : '' }}">
                    {{ $detail->jumlah }}× {{ $detail->nama_menu_snapshot }}
                    @if($isRacikItem)
                        <span class="text-[9px] bg-purple-200 text-purple-700 px-1.5 py-0.5 rounded font-black uppercase align-middle ml-1">Racik</span>
                    @endif
                </h4>
                @if($isDelivery && $order->customer)
                <span class="text-[10px] font-bold text-zinc-400 whitespace-nowrap flex-shrink-0">
                    <i data-lucide="bike" class="w-3 h-3 inline" aria-hidden="true"></i>
                    Delivery
                </span>
                @endif
            </div>

            {{-- Customizations — HIGHLIGHTED with colored bg --}}
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
        @endforeach

        {{-- Customer note --}}
        @if($order->catatan)
        <div class="flex items-start gap-2 p-2.5 bg-amber-50 border border-amber-200 rounded-xl">
            <i data-lucide="message-square" class="w-3.5 h-3.5 text-amber-600 shrink-0 mt-0.5" aria-hidden="true"></i>
            <p class="text-[11px] font-medium text-amber-700 italic">"{{ $order->catatan }}"</p>
        </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="px-4 py-3 border-t border-zinc-100 bg-zinc-50/50 flex gap-2">
        <button type="button" onclick="showDetailModal({{ $order->id_pesanan }})" class="p-3 bg-white border border-zinc-200 text-zinc-600 rounded-xl hover:bg-zinc-50 transition-all active:scale-[0.98] shadow-sm flex items-center justify-center">
            <i data-lucide="info" class="w-4 h-4"></i>
        </button>

        @if($order->id_status_pesanan == 1)
        <form action="{{ route('dapur.update-status', $order->id_pesanan) }}" method="POST" class="dapur-status-form flex-1" data-pesanan-id="{{ $order->id_pesanan }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="2">
            <button type="submit" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-black rounded-xl text-sm transition-all active:scale-[0.98] shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="play-circle" class="w-4 h-4" aria-hidden="true"></i>
                Mulai Proses
            </button>
        </form>
        @elseif($order->id_status_pesanan == 2)
        <form action="{{ route('dapur.update-status', $order->id_pesanan) }}" method="POST" class="dapur-status-form flex-1" data-pesanan-id="{{ $order->id_pesanan }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="3">
            <button type="submit" class="w-full py-3 bg-lime-500 hover:bg-lime-600 text-white font-black rounded-xl text-sm transition-all active:scale-[0.98] shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="check-circle" class="w-4 h-4" aria-hidden="true"></i>
                Tandai Siap
            </button>
        </form>
        @elseif($order->id_status_pesanan == 3)
        <div class="flex-1 py-3 bg-purple-100 text-purple-700 font-black rounded-xl text-sm flex items-center justify-center gap-2">
            <i data-lucide="package-check" class="w-4 h-4" aria-hidden="true"></i>
            Menunggu Driver
        </div>
        @endif
    </div>
</div>