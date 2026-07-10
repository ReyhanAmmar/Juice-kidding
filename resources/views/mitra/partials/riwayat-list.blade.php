@if($riwayat->count() > 0)
    @foreach($riwayat as $order)
    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F8F7FC] transition-colors">
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <div class="flex-shrink-0">
                @php
                    $statusIcons = [
                        3 => ['icon' => 'package-check', 'bg' => 'bg-[#FDF3E7]', 'color' => 'text-[#E17D19]'],
                        4 => ['icon' => 'truck', 'bg' => 'bg-[#194B96]/10', 'color' => 'text-[#194B96]'],
                        5 => ['icon' => 'map-pin', 'bg' => 'bg-[#194B96]/10', 'color' => 'text-[#194B96]'],
                        6 => ['icon' => 'check', 'bg' => 'bg-[#EEF7D8]', 'color' => 'text-[#6E9A2A]'],
                    ];
                    $s = $statusIcons[$order->id_status_pesanan] ?? ['icon' => 'circle', 'bg' => 'bg-[#F8F7FC]', 'color' => 'text-[#9B97A8]'];
                @endphp
                <div class="w-7 h-7 rounded-full {{ $s['bg'] }} flex items-center justify-center">
                    <i data-lucide="{{ $s['icon'] }}" class="w-3.5 h-3.5 {{ $s['color'] }}" aria-hidden="true"></i>
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-[#E17D19]">#{{ $order->kode_pesanan }}</span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ $order->id_tipe_pesanan == 1 ? 'bg-[#194B96]/10 text-[#194B96]' : 'bg-[#96C84B]/15 text-[#6E9A2A]' }}">
                        {{ $order->id_tipe_pesanan == 1 ? 'Pick-up' : 'Delivery' }}
                    </span>
                </div>
                <span class="text-[11px] text-[#9B97A8] truncate block mt-0.5">
                    {{ $order->detail_pesanan->pluck('nama_menu_snapshot')->take(2)->join(', ') }}
                    @if($order->detail_pesanan->count() > 2)
                        <span class="text-[#9B97A8]">+{{ $order->detail_pesanan->count() - 2 }} lagi</span>
                    @endif
                </span>
            </div>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            @if($order->durasi_menit !== null)
                <span class="text-[10px] font-bold text-[#6E9A2A] bg-[#EEF7D8] px-2 py-0.5 rounded-full flex items-center gap-1 whitespace-nowrap">
                    <i data-lucide="timer" class="w-3 h-3" aria-hidden="true"></i>
                    {{ $order->durasi_menit }} mnt
                </span>
            @endif
            <span class="text-[11px] text-[#9B97A8] whitespace-nowrap">
                {{ \Carbon\Carbon::parse($order->updated_at)->format('d/m H:i') }}
            </span>
            <span class="text-[10px] font-bold whitespace-nowrap
                {{ $order->id_status_pesanan == 6 ? 'text-[#6E9A2A]' : ($order->id_status_pesanan == 3 ? 'text-[#E17D19]' : 'text-[#194B96]') }}">
                {{ ['Siap', 'Diantar', 'Sampai', 'Selesai'][$order->id_status_pesanan - 3] ?? '-' }}
            </span>
        </div>
    </div>
    @endforeach
@else
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="w-12 h-12 bg-[#F8F7FC] rounded-full flex items-center justify-center mb-3">
            <i data-lucide="clipboard-list" class="w-6 h-6 text-[#9B97A8]" aria-hidden="true"></i>
        </div>
        <p class="text-[#1A1820] text-sm font-bold">Belum Ada Riwayat</p>
        <p class="text-[#9B97A8] text-xs mt-1">Pesanan yang sudah diproses akan muncul di sini.</p>
    </div>
@endif