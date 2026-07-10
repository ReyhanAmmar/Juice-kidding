<div class="flex items-center gap-2.5 mb-4 px-1">
    <div class="w-8 h-8 rounded-lg bg-{{ $color }}-100 flex items-center justify-center">
        <i data-lucide="{{ $icon }}" class="w-4 h-4 text-{{ $color }}-600" aria-hidden="true"></i>
    </div>
    <div>
        <h2 class="text-sm font-black text-zinc-900">{{ $label }}</h2>
        <span class="text-[11px] text-zinc-400 font-medium">{{ $count }} menunggu</span>
    </div>
</div>

<div class="space-y-3 flex-1" id="column-{{ $status }}">
    @forelse($orders as $order)
    @include('mitra.partials.dapur-card-kanban', ['order' => $order, 'status' => $status])
    @empty
    <div class="bg-white rounded-2xl border border-dashed border-zinc-200 p-8 text-center">
        <div class="w-12 h-12 bg-zinc-50 rounded-full flex items-center justify-center mx-auto mb-3">
            <i data-lucide="{{ $status == 1 ? 'check-circle-2' : ($status == 2 ? 'chef-hat' : 'package-check') }}" class="w-6 h-6 text-zinc-300" aria-hidden="true"></i>
        </div>
        <p class="text-sm font-bold text-zinc-400">{{ $status == 1 ? 'Tidak ada' : ($status == 2 ? 'Tidak ada' : 'Belum ada') }}</p>
    </div>
    @endforelse

    <div class="h-4"></div>
</div>