@extends('layouts.app-customer')

@section('title', 'Keranjang — Juice Kidding')

@section('content')
<section class="px-4 pt-4 pb-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('beranda') }}" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4 text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-xl font-black text-gray-900">Keranjang</h1>
            <p class="text-xs font-medium text-gray-400">
                <span id="cart-total-items">3</span> item di keranjang
            </p>
        </div>
    </div>

    {{-- Cart Items --}}
    <div id="cart-items" class="space-y-3">

        {{-- Cart Item 1 --}}
        <div class="cart-item bg-white rounded-2xl shadow-card p-3 flex gap-3 animate-fade-in-up" data-id="1" data-price="18000">
            <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-primary-light to-orange-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                <span class="text-3xl">🥑</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-1">Jus Alpukat Susu</h3>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Regular · Dingin</p>
                    </div>
                    <button onclick="removeItem(this)" class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-300 hover:text-accent-red hover:bg-red-50 transition-all flex-shrink-0">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-primary font-extrabold text-base item-subtotal">Rp 18.000</span>
                    <div class="flex items-center gap-2 bg-gray-50 rounded-full px-1 py-0.5">
                        <button onclick="updateQty(this, -1)" class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:bg-primary-light active:scale-90 transition-all">
                            <i data-lucide="minus" class="w-3 h-3"></i>
                        </button>
                        <span class="text-sm font-bold text-gray-900 w-5 text-center item-qty">1</span>
                        <button onclick="updateQty(this, 1)" class="w-6 h-6 rounded-full bg-primary shadow-btn text-white flex items-center justify-center hover:bg-primary-dark active:scale-90 transition-all">
                            <i data-lucide="plus" class="w-3 h-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cart Item 2 --}}
        <div class="cart-item bg-white rounded-2xl shadow-card p-3 flex gap-3 animate-fade-in-up" data-id="2" data-price="15000" style="animation-delay: 80ms">
            <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                <span class="text-3xl">🥝</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-1">Jus Kiwi Mint</h3>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Regular · Dingin</p>
                    </div>
                    <button onclick="removeItem(this)" class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-300 hover:text-accent-red hover:bg-red-50 transition-all flex-shrink-0">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-primary font-extrabold text-base item-subtotal">Rp 15.000</span>
                    <div class="flex items-center gap-2 bg-gray-50 rounded-full px-1 py-0.5">
                        <button onclick="updateQty(this, -1)" class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:bg-primary-light active:scale-90 transition-all">
                            <i data-lucide="minus" class="w-3 h-3"></i>
                        </button>
                        <span class="text-sm font-bold text-gray-900 w-5 text-center item-qty">2</span>
                        <button onclick="updateQty(this, 1)" class="w-6 h-6 rounded-full bg-primary shadow-btn text-white flex items-center justify-center hover:bg-primary-dark active:scale-90 transition-all">
                            <i data-lucide="plus" class="w-3 h-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cart Item 3 --}}
        <div class="cart-item bg-white rounded-2xl shadow-card p-3 flex gap-3 animate-fade-in-up" data-id="3" data-price="20000" style="animation-delay: 160ms">
            <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-red-50 to-pink-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                <span class="text-3xl">🍓</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-1">Smoothie Berry Blast</h3>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Large · Extra Es</p>
                    </div>
                    <button onclick="removeItem(this)" class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-300 hover:text-accent-red hover:bg-red-50 transition-all flex-shrink-0">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-primary font-extrabold text-base item-subtotal">Rp 20.000</span>
                    <div class="flex items-center gap-2 bg-gray-50 rounded-full px-1 py-0.5">
                        <button onclick="updateQty(this, -1)" class="w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-primary hover:bg-primary-light active:scale-90 transition-all">
                            <i data-lucide="minus" class="w-3 h-3"></i>
                        </button>
                        <span class="text-sm font-bold text-gray-900 w-5 text-center item-qty">1</span>
                        <button onclick="updateQty(this, 1)" class="w-6 h-6 rounded-full bg-primary shadow-btn text-white flex items-center justify-center hover:bg-primary-dark active:scale-90 transition-all">
                            <i data-lucide="plus" class="w-3 h-3"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Empty State (hidden) --}}
    <div id="cart-empty" class="hidden text-center py-16">
        <img src="{{ asset('images/logo_maskot.png') }}" alt=""
             class="w-32 h-32 object-contain mx-auto opacity-60 animate-bounce-slow">
        <h3 class="text-lg font-black text-gray-900 mt-4">Keranjang Kosong</h3>
        <p class="text-sm font-medium text-gray-400 mt-1 mb-5">Yuk mulai pesan jus segar favoritmu!</p>
        <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold text-sm py-3 px-6 rounded-full shadow-btn transition-all active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Lihat Menu
        </a>
    </div>

    {{-- Order Summary --}}
    <div id="cart-summary" class="mt-6 bg-gray-50 rounded-2xl p-4 border-2 border-gray-100">
        <h3 class="text-sm font-black text-gray-900 mb-3">Ringkasan Pesanan</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Subtotal (<span id="summary-count">3</span> item)</span>
                <span class="font-bold text-gray-900" id="summary-subtotal">Rp 53.000</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Diskon</span>
                <span class="font-bold text-secondary">-Rp 0</span>
            </div>
            <div class="border-t border-gray-200 pt-2 flex justify-between">
                <span class="font-bold text-gray-900">Total</span>
                <span class="font-extrabold text-primary text-lg" id="summary-total">Rp 53.000</span>
            </div>
        </div>
    </div>

    {{-- Checkout Button --}}
    <div id="checkout-btn-wrap" class="mt-4">
        <a href="{{ route('customer.checkout') }}"
           class="w-full bg-secondary hover:bg-secondary-dark active:scale-95
                  text-white font-bold text-sm py-3.5 px-6 rounded-full shadow-btn-green
                  transition-all duration-150 flex items-center justify-center gap-2">
            <i data-lucide="shopping-bag" class="w-4 h-4"></i>
            Lanjut ke Checkout
        </a>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    updateSummary();
    lucide.createIcons();
});

function formatRupiah(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

function updateQty(btn, delta) {
    const item = btn.closest('.cart-item');
    const qtyEl = item.querySelector('.item-qty');
    const subtotalEl = item.querySelector('.item-subtotal');
    const price = parseInt(item.dataset.price);
    let qty = parseInt(qtyEl.textContent) + delta;

    if (qty < 1) {
        removeItem(btn);
        return;
    }

    qtyEl.textContent = qty;
    subtotalEl.textContent = formatRupiah(price * qty);

    // Micro-animation on quantity change
    qtyEl.classList.add('animate-scale-in');
    setTimeout(() => qtyEl.classList.remove('animate-scale-in'), 400);

    updateSummary();
}

function removeItem(btn) {
    const item = btn.closest('.cart-item');
    item.style.transform = 'translateX(100%)';
    item.style.opacity = '0';
    item.style.transition = 'all 0.3s ease';
    setTimeout(() => {
        item.remove();
        updateSummary();
        checkEmpty();
        showToast('Item dihapus dari keranjang', '🗑️');
    }, 300);
}

function updateSummary() {
    const items = document.querySelectorAll('.cart-item');
    let totalItems = 0;
    let totalPrice = 0;

    items.forEach(item => {
        const qty = parseInt(item.querySelector('.item-qty').textContent);
        const price = parseInt(item.dataset.price);
        totalItems += qty;
        totalPrice += price * qty;
    });

    document.getElementById('cart-total-items').textContent = totalItems;
    document.getElementById('summary-count').textContent = totalItems;
    document.getElementById('summary-subtotal').textContent = formatRupiah(totalPrice);
    document.getElementById('summary-total').textContent = formatRupiah(totalPrice);
}

function checkEmpty() {
    const items = document.querySelectorAll('.cart-item');
    const empty = document.getElementById('cart-empty');
    const summary = document.getElementById('cart-summary');
    const checkoutBtn = document.getElementById('checkout-btn-wrap');

    if (items.length === 0) {
        empty.classList.remove('hidden');
        summary.classList.add('hidden');
        checkoutBtn.classList.add('hidden');
    }
}
</script>
@endsection
