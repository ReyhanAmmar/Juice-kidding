@extends('layouts.main')

@section('title', 'Keranjang Belanja - Juice Kidding')

@section('content')
<main class="w-full pt-32 pb-24 min-h-screen" style="background: var(--surface-page);">
    <div class="max-w-[1280px] mx-auto px-4 md:px-8">

        {{-- Page Header --}}
        <div class="flex items-center gap-4 mb-10 animate-fade-in-up">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                <i data-lucide="shopping-bag" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-zinc-900">Keranjang Belanja</h1>
                <p class="text-zinc-500 font-medium mt-0.5">{{ $keranjang->count() > 0 ? $keranjang->sum('jumlah') . ' item dipilih' : 'Belum ada item di keranjang' }}</p>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 text-green-700 rounded-2xl flex items-center gap-3 border border-green-100 font-bold animate-scale-in">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @forelse($keranjang as $index => $item)
                <div class="bg-white rounded-2xl p-5 flex flex-col sm:flex-row gap-5 relative group hover:shadow-md transition-all duration-300 stagger-item" id="cart-item-{{ $item->id_keranjang }}" style="opacity: 0; animation-delay: {{ $index * 0.08 }}s;">
                    {{-- Rainbow accent bar --}}
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500 rounded-t-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    {{-- Delete Button --}}
                    <button onclick="removeItem({{ $item->id_keranjang }})" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-zinc-50 text-zinc-400 flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all active:scale-90 sm:opacity-0 sm:group-hover:opacity-100">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>

                    {{-- Image --}}
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center shadow-inner">
                        @if($item->menu->foto)
                            <img src="{{ asset('storage/'.$item->menu->foto) }}" alt="{{ $item->menu->nama_jus }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🥤</span>
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 flex flex-col justify-between min-w-0">
                        <div>
                            <div class="flex items-start justify-between gap-2 pr-6">
                                <h3 class="text-lg font-black text-zinc-900 truncate">{{ $item->menu->nama_jus }}</h3>
                                <p class="text-lg font-black text-primary whitespace-nowrap shrink-0 sm:hidden">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-zinc-500 font-semibold text-sm mt-0.5">Rp {{ number_format($item->subtotal / $item->jumlah, 0, ',', '.') }} / porsi</p>

                            @if($item->opsi->count() > 0)
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach($item->opsi as $opsiItem)
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-amber-100 flex items-center gap-1">
                                    <i data-lucide="sparkles" class="w-3 h-3 text-amber-500"></i>
                                    {{ $opsiItem->opsi->nama_opsi }} (+Rp{{ number_format($opsiItem->opsi->harga_tambahan, 0, ',', '.') }})
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-5">
                            {{-- Quantity Selector --}}
                            <div class="flex items-center bg-zinc-50 rounded-xl border border-zinc-200/80 p-1">
                                <button onclick="updateQty({{ $item->id_keranjang }}, -1)" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-600 active:scale-90 font-bold transition-all shadow-sm border border-zinc-200/50 cursor-pointer">-</button>
                                <span class="w-10 text-center font-black text-zinc-900 text-sm" id="qty-{{ $item->id_keranjang }}">{{ $item->jumlah }}</span>
                                <button onclick="updateQty({{ $item->id_keranjang }}, 1)" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white hover:bg-zinc-100 text-zinc-600 active:scale-90 font-bold transition-all shadow-sm border border-zinc-200/50 cursor-pointer">+</button>
                            </div>
                            {{-- Item Subtotal --}}
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] text-zinc-400 font-bold uppercase tracking-widest mb-0.5">Subtotal</p>
                                <p class="text-lg font-black text-primary" id="item-subtotal-{{ $item->id_keranjang }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                {{-- Empty State --}}
                <div class="bg-white rounded-3xl p-12 md:p-16 flex flex-col items-center justify-center text-center animate-scale-in">
                    <div class="w-32 h-32 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full flex items-center justify-center mb-8 shadow-inner">
                        <span class="text-6xl animate-float-gentle">🛒</span>
                    </div>
                    <h3 class="text-2xl font-black text-zinc-900 mb-2">Keranjangmu masih kosong</h3>
                    <p class="text-zinc-500 font-medium max-w-md mb-8">Yuk, jelajahi menu jus segar kami dan temukan favoritmu!</p>
                    <a href="{{ route('menu') }}" class="px-8 py-3.5 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black rounded-full transition-all shadow-lg shadow-amber-500/25 active:scale-95 text-lg">
                        Lihat Menu
                    </a>
                </div>
                @endforelse
            </div>

            {{-- Right Column: Summary --}}
            @if($keranjang->count() > 0)
            <div class="lg:col-span-1 animate-fade-in-right" style="animation-delay: 0.2s;">
                <div class="bg-white rounded-2xl p-6 md:p-7 sticky top-32 border border-zinc-100/80 shadow-sm relative overflow-hidden">
                    {{-- Rainbow accent bar --}}
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500"></div>

                    <h3 class="text-lg font-black text-zinc-900 mb-7 flex items-center gap-2">
                        <i data-lucide="receipt-text" class="w-5 h-5 text-primary"></i>
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-500 font-medium">Subtotal</span>
                            <span class="text-zinc-900 font-black" id="summary-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-500 font-medium">Jumlah Item</span>
                            <span class="text-zinc-900 font-bold">{{ $keranjang->sum('jumlah') }} porsi</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-zinc-400 font-medium">Biaya Pengiriman</span>
                            <span class="text-zinc-400">Dihitung di checkout</span>
                        </div>
                    </div>

                    <div class="h-px w-full bg-zinc-100 mb-5"></div>

                    <div class="flex justify-between items-end mb-7">
                        <span class="text-zinc-900 font-bold">Total</span>
                        <span class="text-2xl font-black text-primary" id="summary-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('customer.checkout') }}" class="w-full py-3.5 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black rounded-xl flex items-center justify-center gap-2 transition-all shadow-lg shadow-amber-500/25 active:scale-95 text-base text-center">
                        Lanjut ke Checkout
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>

                    <div class="mt-5 flex items-start gap-3 p-3.5 bg-zinc-50 rounded-xl">
                        <i data-lucide="shield-check" class="w-4 h-4 text-zinc-400 flex-shrink-0 mt-0.5"></i>
                        <p class="text-[11px] text-zinc-500 font-medium leading-relaxed">Transaksi aman. Ongkir dan alamat dikonfirmasi di halaman checkout.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    async function updateQty(id, change) {
        const qtyElement = document.getElementById(`qty-${id}`);
        let currentQty = parseInt(qtyElement.innerText);
        let newQty = currentQty + change;

        if (newQty < 1) return;

        qtyElement.innerText = newQty;

        try {
            const response = await fetch(`/customer/keranjang/update/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ jumlah: newQty })
            });

            const data = await response.json();
            if(data.success) {
                document.getElementById(`item-subtotal-${id}`).innerText = formatRupiah(data.subtotal);
                recalculateTotal();
            }
        } catch (error) {
            console.error(error);
            qtyElement.innerText = currentQty;
        }
    }

    async function removeItem(id) {
        const itemEl = document.getElementById(`cart-item-${id}`);
        itemEl.style.opacity = '0';
        itemEl.style.transform = 'scale(0.95)';

        try {
            const response = await fetch(`/customer/keranjang/remove/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            const data = await response.json();
            if(data.success) {
                setTimeout(() => {
                    itemEl.remove();
                    recalculateTotal();
                    if(document.querySelectorAll('[id^="cart-item-"]').length === 0) {
                        window.location.reload();
                    }
                }, 300);
            } else {
                itemEl.style.opacity = '1';
                itemEl.style.transform = '';
            }
        } catch (error) {
            console.error(error);
            itemEl.style.opacity = '1';
            itemEl.style.transform = '';
        }
    }

    function recalculateTotal() {
        let total = 0;
        let totalItems = 0;
        document.querySelectorAll('[id^="item-subtotal-"]').forEach(el => {
            const val = parseInt(el.innerText.replace(/[^0-9]/g, ''));
            total += val;
        });

        document.querySelectorAll('[id^="qty-"]').forEach(el => {
            totalItems += parseInt(el.innerText);
        });

        document.getElementById('summary-subtotal').innerText = formatRupiah(total);
        document.getElementById('summary-total').innerText = formatRupiah(total);
    }

    // Stagger animation on load
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.stagger-item');
        items.forEach((el, i) => {
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.animation = 'fadeInUp 0.5s ease-out forwards';
            }, i * 80);
        });
    });
</script>
@endsection