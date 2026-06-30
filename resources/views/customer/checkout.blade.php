@extends('layouts.app-customer')

@section('title', 'Checkout — Juice Kidding')

@section('content')
<section class="px-4 pt-4 pb-6">
    {{-- Page Header --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('customer.keranjang') }}" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4 text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-xl font-black text-gray-900">Checkout</h1>
            <p class="text-xs font-medium text-gray-400">Konfirmasi pesananmu</p>
        </div>
    </div>

    {{-- Delivery Type Toggle --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="truck" class="w-4 h-4 text-primary"></i>
            Tipe Pesanan
        </h3>
        <div class="flex gap-2">
            <button id="btn-pickup" onclick="setDeliveryType('pickup')"
                    class="delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95
                           bg-primary text-white shadow-btn">
                <i data-lucide="store" class="w-4 h-4 inline-block mr-1"></i>
                Pick-up
            </button>
            <button id="btn-delivery" onclick="setDeliveryType('delivery')"
                    class="delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95
                           bg-gray-100 text-gray-500 hover:bg-gray-200">
                <i data-lucide="bike" class="w-4 h-4 inline-block mr-1"></i>
                Delivery
            </button>
        </div>
    </div>

    {{-- Delivery Address (hidden for pickup) --}}
    <div id="delivery-form" class="bg-white rounded-2xl shadow-card p-4 mb-4 hidden" style="animation: fadeInUp 0.35s ease-out forwards">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-4 h-4 text-accent-red"></i>
            Alamat Pengiriman
        </h3>
        <div class="mb-3">
            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="alamat">
                Alamat Lengkap
            </label>
            <textarea id="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman..."
                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                       text-sm font-medium text-gray-900 placeholder-gray-300
                       focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                       transition-all bg-white resize-none"></textarea>
        </div>
        <div class="flex gap-3">
            <div class="flex-1">
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="jarak">
                    Jarak (km)
                </label>
                <input type="number" id="jarak" placeholder="0" min="0" step="0.5" value="2"
                    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                           text-sm font-medium text-gray-900 placeholder-gray-300
                           focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                           transition-all bg-white"
                    onchange="calculateOngkir()">
            </div>
            <div class="flex-1">
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
                    Ongkos Kirim
                </label>
                <div class="border-2 border-gray-100 rounded-2xl px-4 py-3 bg-gray-50 text-sm font-extrabold text-accent-blue" id="ongkir-display">
                    Rp 5.000
                </div>
            </div>
        </div>
    </div>

    {{-- Pickup Time --}}
    <div id="pickup-form" class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up" style="animation-delay: 80ms">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="clock" class="w-4 h-4 text-accent-blue"></i>
            Waktu Pengambilan
        </h3>
        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="waktu">
                Pilih waktu
            </label>
            <input type="datetime-local" id="waktu"
                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                       text-sm font-medium text-gray-900
                       focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                       transition-all bg-white">
        </div>
    </div>

    {{-- Contact Info --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up" style="animation-delay: 160ms">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="user" class="w-4 h-4 text-accent-purple"></i>
            Informasi Pemesan
        </h3>
        <div class="mb-3">
            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="nama">Nama</label>
            <input type="text" id="nama" value="{{ Auth::user()->nama_lengkap ?? '' }}" placeholder="Nama lengkap"
                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                       text-sm font-medium text-gray-900 placeholder-gray-300
                       focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                       transition-all bg-white">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="phone">No. Telepon</label>
            <input type="tel" id="phone" value="{{ Auth::user()->no_hp ?? '' }}" placeholder="08xxxxxxxxxx"
                class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                       text-sm font-medium text-gray-900 placeholder-gray-300
                       focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                       transition-all bg-white">
        </div>
    </div>

    {{-- Payment Method --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up" style="animation-delay: 240ms">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="wallet" class="w-4 h-4 text-secondary"></i>
            Metode Pembayaran
        </h3>
        <div class="space-y-2">
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-primary bg-primary-light cursor-pointer transition-all payment-option">
                <input type="radio" name="payment" value="cash" checked class="sr-only peer">
                <div class="w-5 h-5 rounded-full border-2 border-primary flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900">Bayar di Tempat (COD)</p>
                    <p class="text-[11px] font-medium text-gray-400">Bayar saat terima pesanan</p>
                </div>
                <span class="text-lg">💵</span>
            </label>
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-primary hover:bg-primary-light transition-all payment-option">
                <input type="radio" name="payment" value="transfer" class="sr-only peer">
                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-primary">
                    <div class="w-2.5 h-2.5 rounded-full bg-transparent peer-checked:bg-primary"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900">Transfer Bank</p>
                    <p class="text-[11px] font-medium text-gray-400">BCA / Mandiri / BNI</p>
                </div>
                <span class="text-lg">🏦</span>
            </label>
            <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 cursor-pointer hover:border-primary hover:bg-primary-light transition-all payment-option">
                <input type="radio" name="payment" value="ewallet" class="sr-only peer">
                <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900">E-Wallet</p>
                    <p class="text-[11px] font-medium text-gray-400">GoPay / OVO / Dana</p>
                </div>
                <span class="text-lg">📱</span>
            </label>
        </div>
    </div>

    {{-- Notes --}}
    <div class="bg-white rounded-2xl shadow-card p-4 mb-4 animate-fade-in-up" style="animation-delay: 320ms">
        <h3 class="text-sm font-black text-gray-900 mb-3 flex items-center gap-2">
            <i data-lucide="message-square" class="w-4 h-4 text-gray-400"></i>
            Catatan
        </h3>
        <textarea rows="2" placeholder="Tambah catatan (opsional)..."
            class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
                   text-sm font-medium text-gray-900 placeholder-gray-300
                   focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
                   transition-all bg-white resize-none"></textarea>
    </div>

    {{-- Order Summary --}}
    <div class="bg-gray-50 rounded-2xl p-4 border-2 border-gray-100 mb-4 animate-fade-in-up" style="animation-delay: 400ms">
        <h3 class="text-sm font-black text-gray-900 mb-3">Ringkasan Pembayaran</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Subtotal (3 item)</span>
                <span class="font-bold text-gray-900">Rp 53.000</span>
            </div>
            <div class="flex justify-between" id="ongkir-row" style="display: none;">
                <span class="font-medium text-gray-500">Ongkos Kirim</span>
                <span class="font-bold text-gray-900" id="ongkir-summary">Rp 5.000</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-500">Diskon</span>
                <span class="font-bold text-secondary">-Rp 0</span>
            </div>
            <div class="border-t-2 border-gray-200 pt-3 flex justify-between">
                <span class="font-bold text-gray-900 text-base">Total Bayar</span>
                <span class="font-extrabold text-primary text-xl" id="checkout-total">Rp 53.000</span>
            </div>
        </div>
    </div>

    {{-- Confirm Button --}}
    <button onclick="confirmOrder()"
            id="btn-confirm"
            class="w-full bg-secondary hover:bg-secondary-dark active:scale-95
                   text-white font-bold text-sm py-3.5 px-6 rounded-full shadow-btn-green
                   transition-all duration-150 flex items-center justify-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        Konfirmasi Pesanan
    </button>
</section>

{{-- Success Modal --}}
<div id="modal-success" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 hidden">
    <div class="bg-white rounded-3xl shadow-card-lg w-full max-w-sm p-6 text-center animate-scale-in">
        <img src="{{ asset('images/logo_maskot.png') }}" alt="Sukses"
             class="w-24 h-24 object-contain mx-auto animate-bounce-slow">
        <h3 class="text-xl font-black text-gray-900 mt-4">Pesanan Berhasil! 🎉</h3>
        <p class="text-sm font-medium text-gray-500 mt-2 leading-relaxed">
            Terima kasih! Pesananmu sedang diproses.<br>Kamu bisa melacak status pesanan.
        </p>
        {{-- Rainbow dots --}}
        <div class="flex gap-1.5 justify-center mt-4">
            <span class="w-2 h-2 rounded-full bg-accent-red"></span>
            <span class="w-2 h-2 rounded-full bg-primary"></span>
            <span class="w-2 h-2 rounded-full bg-accent-yellow"></span>
            <span class="w-2 h-2 rounded-full bg-secondary"></span>
            <span class="w-2 h-2 rounded-full bg-accent-blue"></span>
            <span class="w-2 h-2 rounded-full bg-accent-purple"></span>
        </div>
        <div class="flex gap-3 mt-6">
            <a href="{{ route('beranda') }}" class="flex-1 border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-2xl hover:bg-gray-50 text-sm transition-all text-center">
                Kembali
            </a>
            <a href="{{ route('beranda') }}" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-3 rounded-2xl text-sm transition-all text-center active:scale-95 shadow-btn">
                Lacak Pesanan
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let deliveryType = 'pickup';

function setDeliveryType(type) {
    deliveryType = type;
    const pickupBtn = document.getElementById('btn-pickup');
    const deliveryBtn = document.getElementById('btn-delivery');
    const deliveryForm = document.getElementById('delivery-form');
    const pickupForm = document.getElementById('pickup-form');
    const ongkirRow = document.getElementById('ongkir-row');

    if (type === 'pickup') {
        pickupBtn.className = 'delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95 bg-primary text-white shadow-btn';
        deliveryBtn.className = 'delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95 bg-gray-100 text-gray-500 hover:bg-gray-200';
        deliveryForm.classList.add('hidden');
        pickupForm.classList.remove('hidden');
        ongkirRow.style.display = 'none';
    } else {
        deliveryBtn.className = 'delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95 bg-primary text-white shadow-btn';
        pickupBtn.className = 'delivery-type flex-1 py-3 rounded-xl font-bold text-sm transition-all active:scale-95 bg-gray-100 text-gray-500 hover:bg-gray-200';
        deliveryForm.classList.remove('hidden');
        pickupForm.classList.add('hidden');
        ongkirRow.style.display = 'flex';
        calculateOngkir();
    }
    lucide.createIcons();
}

function calculateOngkir() {
    const jarak = parseFloat(document.getElementById('jarak').value) || 0;
    const ongkir = Math.ceil(jarak) * 2500;
    document.getElementById('ongkir-display').textContent = formatRupiah(ongkir);
    document.getElementById('ongkir-summary').textContent = formatRupiah(ongkir);

    const subtotal = 53000;
    document.getElementById('checkout-total').textContent = formatRupiah(subtotal + ongkir);
}

function formatRupiah(num) {
    return 'Rp ' + num.toLocaleString('id-ID');
}

// Payment option UI
document.querySelectorAll('.payment-option').forEach(opt => {
    opt.addEventListener('click', () => {
        document.querySelectorAll('.payment-option').forEach(o => {
            o.classList.remove('border-primary', 'bg-primary-light');
            o.classList.add('border-gray-200');
            o.querySelector('div > div').classList.remove('bg-primary');
            o.querySelector('div > div').classList.add('bg-transparent');
            o.querySelector('.rounded-full').classList.remove('border-primary');
            o.querySelector('.rounded-full').classList.add('border-gray-300');
        });
        opt.classList.add('border-primary', 'bg-primary-light');
        opt.classList.remove('border-gray-200');
        const dot = opt.querySelector('div > div');
        dot.classList.add('bg-primary');
        dot.classList.remove('bg-transparent');
        opt.querySelector('.rounded-full').classList.add('border-primary');
        opt.querySelector('.rounded-full').classList.remove('border-gray-300');
    });
});

function confirmOrder() {
    const btn = document.getElementById('btn-confirm');
    btn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Memproses...';
    btn.disabled = true;
    btn.classList.add('opacity-75', 'cursor-not-allowed');

    setTimeout(() => {
        document.getElementById('modal-success').classList.remove('hidden');
        btn.innerHTML = '<i data-lucide="check-circle" class="w-4 h-4"></i> Konfirmasi Pesanan';
        btn.disabled = false;
        btn.classList.remove('opacity-75', 'cursor-not-allowed');
        lucide.createIcons();
    }, 1500);
}

document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
