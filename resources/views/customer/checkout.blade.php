@extends('layouts.main')

@section('title', 'Checkout - Juice Kidding')

@section('content')
{{-- Leaflet.js CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<main class="w-full pt-32 pb-24 min-h-screen" style="background: var(--surface-page);">
    <div class="max-w-[1280px] mx-auto px-4 md:px-8">

        {{-- Page Header --}}
        <div class="flex items-center gap-4 mb-10 animate-fade-in-up">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/20">
                <i data-lucide="credit-card" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-zinc-900">Checkout</h1>
                <p class="text-zinc-500 font-medium mt-0.5">Selesaikan pesananmu untuk menikmati segarnya jus pilihan</p>
            </div>
        </div>

        <form id="checkout-form" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-5 animate-fade-in-up">

                {{-- 1. Metode Penerimaan --}}
                <div class="bg-white rounded-2xl p-6 border border-zinc-100/80 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500"></div>
                    <h3 class="text-base font-black text-zinc-900 mb-5 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-primary"></i>
                        Metode Penerimaan
                    </h3>

                    <div class="flex p-1 bg-zinc-100 rounded-2xl gap-1">
                        <button type="button" id="tab-pickup" onclick="setTipePesanan(1)" class="flex-1 py-2.5 text-sm font-black rounded-xl transition-all active:scale-95 bg-primary text-white shadow-sm cursor-pointer">
                            🥡 Ambil di Toko
                        </button>
                        <button type="button" id="tab-delivery" onclick="setTipePesanan(2)" class="flex-1 py-2.5 text-sm font-black rounded-xl transition-all active:scale-95 text-zinc-500 hover:bg-white/50 cursor-pointer">
                            🛵 Antar ke Rumah
                        </button>
                    </div>
                    <input type="hidden" name="tipe_pesanan" id="input-tipe-pesanan" value="1">
                </div>

                {{-- 2. Alamat Pengiriman --}}
                <div id="section-delivery" class="bg-white rounded-2xl p-6 border border-zinc-100/80 shadow-sm relative overflow-hidden hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500"></div>
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-base font-black text-zinc-900 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4 text-primary"></i>
                            Alamat Pengiriman
                        </h3>
                        <button type="button" onclick="openModalAlamatSaya()" class="text-sm font-black text-primary hover:text-primary-dark transition-colors active:scale-95 cursor-pointer">
                            Ubah
                        </button>
                    </div>

                    {{-- Selected Address Block --}}
                    <div id="selected-address-block" class="p-5 rounded-xl bg-zinc-50 border border-zinc-100 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="map-pin" class="w-5 h-5 text-primary"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span id="display-nama" class="font-black text-zinc-900 text-sm">-</span>
                                <span class="w-1 h-1 rounded-full bg-zinc-300"></span>
                                <span id="display-hp" class="text-zinc-500 text-xs font-bold">-</span>
                                <span id="display-label" class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[9px] font-black uppercase rounded">Rumah</span>
                            </div>
                            <p id="display-alamat" class="text-zinc-600 text-xs font-medium leading-relaxed">-</p>
                        </div>
                    </div>

                    <input type="hidden" name="id_alamat" id="input-id-alamat">
                    <input type="hidden" name="latitude" id="input-latitude" value="-6.200000">
                    <input type="hidden" name="longitude" id="input-longitude" value="106.816666">
                    <input type="hidden" name="alamat_lengkap" id="input-alamat-lengkap">
                </div>

                {{-- 3. Detail Pesanan --}}
                <div class="bg-white rounded-2xl p-6 border border-zinc-100/80 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500"></div>
                    <h3 class="text-base font-black text-zinc-900 mb-5 flex items-center gap-2">
                        <i data-lucide="receipt-text" class="w-4 h-4 text-primary"></i>
                        Item Pesanan
                    </h3>

                    <div class="divide-y divide-zinc-100">
                        @foreach($keranjang as $item)
                        <div class="flex items-center gap-4 py-3.5 first:pt-0 last:pb-0">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center border border-zinc-100 overflow-hidden flex-shrink-0">
                                @if($item->menu->foto)
                                    <img src="{{ asset('storage/'.$item->menu->foto) }}" alt="{{ $item->menu->nama_jus }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-2xl">🥤</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-black text-zinc-900 text-sm truncate">{{ $item->menu->nama_jus }}</h4>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($item->opsi as $opsiItem)
                                    <span class="text-[9px] font-black bg-zinc-100 text-zinc-500 px-1.5 py-0.5 rounded">
                                        {{ $opsiItem->opsi->nama_opsi }}
                                    </span>
                                    @endforeach
                                </div>
                                <p class="text-[11px] text-zinc-500 font-bold mt-1">{{ $item->jumlah }} x Rp {{ number_format($item->subtotal/$item->jumlah, 0, ',', '.') }}</p>
                            </div>
                            <div class="font-black text-zinc-900 text-sm shrink-0">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Summary & Payment --}}
            <div class="lg:col-span-1 animate-fade-in-right" style="animation-delay: 0.15s;">
                <div class="bg-white rounded-2xl p-6 md:p-7 border border-zinc-100/80 shadow-sm sticky top-32 relative overflow-hidden">
                    {{-- Rainbow accent bar --}}
                    <div class="absolute top-0 left-0 w-full h-0.5 bg-gradient-to-r from-red-500 via-amber-500 to-pink-500"></div>

                    <h3 class="text-lg font-black text-zinc-900 mb-6 flex items-center gap-2">
                        <i data-lucide="wallet" class="w-5 h-5 text-primary"></i>
                        Ringkasan Pembayaran
                    </h3>

                    <div class="space-y-3.5 mb-5">
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-500 text-sm font-medium">Subtotal Menu</span>
                            <span class="text-zinc-900 font-black text-sm">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center text-sm" id="shipping-fee-row" style="display: none;">
                            <span class="text-zinc-500 font-medium">Ongkos Kirim</span>
                            <span id="ongkir-label" class="font-black">Rp 0</span>
                        </div>

                        <div class="flex justify-between items-center text-xs" id="jarak-info-container" style="display: none;">
                            <span class="text-zinc-400 font-medium">Estimasi Jarak</span>
                            <span id="jarak-label" class="text-zinc-500 font-semibold">0 km</span>
                        </div>
                    </div>

                    <div class="h-px w-full bg-zinc-100 mb-5"></div>

                    {{-- Diskon Poin --}}
                    <div class="mb-5 p-4 rounded-xl bg-zinc-50 border border-zinc-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                                <i data-lucide="coins" class="w-4 h-4 text-orange-600"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-zinc-900">Gunakan Poin</h4>
                                <p class="text-[11px] font-semibold text-zinc-500" id="saldo-poin-label" data-poin="{{ Auth::user()->poin ?? 0 }}">Saldo: {{ number_format(Auth::user()->poin ?? 0, 0, ',', '.') }} Poin</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="gunakan_poin" id="toggle-poin" class="sr-only peer" onchange="calculateShipping()">
                            <div class="w-10 h-5.5 bg-zinc-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[0.5px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                    <div class="flex justify-between items-center text-sm mb-4 hidden" id="diskon-poin-row">
                        <span class="text-zinc-500 font-medium">Diskon Poin</span>
                        <span id="diskon-poin-label" class="text-green-600 font-black">-Rp 0</span>
                    </div>

                    <div class="flex justify-between items-end mb-7">
                        <span class="text-zinc-900 font-bold">Total Pembayaran</span>
                        <span class="text-2xl font-black text-primary" id="total-bayar-label">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                    <input type="hidden" name="ongkir" id="input-ongkir" value="0">
                    <input type="hidden" name="total_bayar" id="input-total" value="{{ $subtotal }}">

                    <button type="submit" id="btn-submit" class="w-full py-3.5 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black rounded-xl shadow-lg shadow-amber-500/25 active:scale-95 hover:shadow-xl transition-all duration-300 text-base disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer">
                        Bayar Sekarang
                    </button>

                    <div class="mt-5 flex items-start gap-3 p-3.5 bg-zinc-50 rounded-xl">
                        <i data-lucide="lock" class="w-4 h-4 text-zinc-400 flex-shrink-0 mt-0.5"></i>
                        <p class="text-[11px] text-zinc-500 font-medium leading-relaxed">Pembayaran dienkripsi secara aman via Midtrans. Beragam metode transfer & e-wallet tersedia.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

{{-- MODAL 1: ALAMAT SAYA --}}
<div id="modal-alamat-saya" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4 hidden transition-all">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 max-h-[85vh] flex flex-col animate-scale-in">
        <div class="flex justify-between items-center pb-4 border-b border-zinc-100">
            <h3 class="text-lg font-black text-zinc-900 flex items-center gap-2">
                <i data-lucide="map-pin" class="w-5 h-5 text-primary"></i>
                Alamat Saya
            </h3>
            <button onclick="closeModalAlamatSaya()" class="w-8 h-8 rounded-full bg-zinc-100 text-zinc-500 flex items-center justify-center hover:bg-zinc-200 active:scale-90 transition-all cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto py-4 space-y-3 hide-scrollbar" id="address-list-container"></div>

        <div class="pt-4 border-t border-zinc-100">
            <button onclick="openFormAlamat(null)" class="w-full py-3 border-2 border-dashed border-primary text-primary font-black rounded-xl hover:bg-amber-50/20 active:scale-95 transition-all text-center flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Alamat Baru
            </button>
        </div>
    </div>
</div>

{{-- MODAL 2: FORM ALAMAT --}}
<div id="modal-form-alamat" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4 hidden transition-all">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 max-h-[90vh] flex flex-col animate-scale-in">
        <div class="flex justify-between items-center pb-4 border-b border-zinc-100">
            <h3 class="text-lg font-black text-zinc-900 flex items-center gap-2" id="form-alamat-title">
                <i data-lucide="edit" class="w-5 h-5 text-primary"></i>
                Alamat Baru
            </h3>
            <button onclick="closeFormAlamat()" class="w-8 h-8 rounded-full bg-zinc-100 text-zinc-500 flex items-center justify-center hover:bg-zinc-200 active:scale-90 transition-all cursor-pointer">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto py-4 space-y-4 hide-scrollbar">
            <input type="hidden" id="form-id-alamat">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-1.5">Nama Penerima</label>
                    <input type="text" id="form-nama-penerima" placeholder="Nama Penerima" class="w-full border border-zinc-200 rounded-xl px-3 py-2.5 text-xs font-bold text-zinc-900 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                    <input type="text" id="form-no-hp" placeholder="No. Telepon" class="w-full border border-zinc-200 rounded-xl px-3 py-2.5 text-xs font-bold text-zinc-900 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white">
                </div>
            </div>

            <div class="relative">
                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-1.5">Cari Lokasi</label>
                <div class="flex gap-2">
                    <input type="text" id="form-search-alamat" placeholder="Ketik nama daerah atau jalan..." class="w-full border border-zinc-200 rounded-xl px-3 py-2.5 text-xs font-bold text-zinc-900 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white">
                    <button type="button" id="form-btn-cari" class="px-4 py-2.5 bg-zinc-900 text-white text-xs font-black rounded-xl hover:bg-zinc-800 active:scale-95 transition-all cursor-pointer">Cari</button>
                </div>
                <div id="form-suggestions" class="absolute left-0 right-0 mt-1 bg-white border border-zinc-100 rounded-xl shadow-lg z-50 hidden max-h-48 overflow-y-auto divide-y divide-zinc-50"></div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider">Ketuk Peta untuk Lokasi</label>
                    <span id="form-georeverse-loading" class="text-[10px] text-zinc-500 hidden animate-pulse">Memperbarui...</span>
                </div>
                <div id="modal-map" class="w-full h-[180px] rounded-xl border border-zinc-200 shadow-inner z-10"></div>
            </div>

            <input type="hidden" id="form-latitude">
            <input type="hidden" id="form-longitude">

            <div>
                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-1.5">Detail Alamat</label>
                <textarea id="form-alamat-detail" rows="2" placeholder="Nama jalan, gedung, blok, RT/RW, patokan..." class="w-full border border-zinc-200 rounded-xl px-3 py-2.5 text-xs font-bold text-zinc-900 placeholder-zinc-300 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all bg-white resize-none"></textarea>
            </div>

            <div class="flex gap-6 items-center">
                <div class="flex-1">
                    <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-wider mb-1.5">Tandai Sebagai</label>
                    <div class="flex gap-2">
                        <button type="button" onclick="setFormLabel('Rumah')" id="label-btn-Rumah" class="flex-1 py-2 text-xs font-black rounded-lg border-2 transition-all active:scale-95 cursor-pointer">Rumah</button>
                        <button type="button" onclick="setFormLabel('Kantor')" id="label-btn-Kantor" class="flex-1 py-2 text-xs font-black rounded-lg border-2 transition-all active:scale-95 cursor-pointer">Kantor</button>
                    </div>
                    <input type="hidden" id="form-label-value" value="Rumah">
                </div>

                <div class="pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="form-is-utama" class="w-4 h-4 accent-amber-600 rounded">
                        <span class="text-xs font-bold text-zinc-700">Utama</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-zinc-100">
            <button onclick="closeFormAlamat()" class="flex-1 py-3 border border-zinc-200 text-zinc-600 font-black rounded-xl hover:bg-zinc-50 active:scale-95 transition-all text-sm cursor-pointer">Batal</button>
            <button onclick="submitAlamatForm()" class="flex-1 py-3 bg-gradient-to-br from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black rounded-xl active:scale-95 transition-all text-sm shadow-lg shadow-amber-500/20 cursor-pointer">Simpan</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Midtrans Snap Sandbox JS SDK --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    const tokoLat = {{ $konfigurasi->latitude_toko ?? -6.200000 }};
    const tokoLng = {{ $konfigurasi->longitude_toko ?? 106.816666 }};
    const maxRadius = {{ $konfigurasi->radius_maks_km ?? 7 }};
    const tarif0_3 = {{ $konfigurasi->tarif_0_3km ?? 5000 }};
    const tarif3_7 = {{ $konfigurasi->tarif_3_7km ?? 7000 }};
    const subtotal = {{ $subtotal }};

    let tipePesanan = 1;
    let currentSelectedId = null;

    let customerAddresses = [
        @foreach($alamats as $alamat)
        @php
            $namaPenerima = Auth::user()->nama_lengkap;
            $noHp = Auth::user()->no_hp;
            $alamatDetail = $alamat->alamat_lengkap;

            if (strpos($alamat->alamat_lengkap, ' | ') !== false) {
                $parts = explode(' | ', $alamat->alamat_lengkap);
                if (count($parts) >= 3) {
                    $namaPenerima = $parts[0];
                    $noHp = $parts[1];
                    $alamatDetail = $parts[2];
                }
            }
        @endphp
        {
            id_alamat: {{ $alamat->id_alamat }},
            label: "{{ addslashes($alamat->label) }}",
            alamat_lengkap: "{{ addslashes($alamatDetail) }}",
            nama_penerima: "{{ addslashes($namaPenerima) }}",
            no_hp: "{{ addslashes($noHp) }}",
            latitude: {{ $alamat->latitude ?? -6.200000 }},
            longitude: {{ $alamat->longitude ?? 106.816666 }},
            is_utama: {{ $alamat->is_utama ? 'true' : 'false' }}
        },
        @endforeach
    ];

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function setTipePesanan(tipe) {
        tipePesanan = tipe;
        document.getElementById('input-tipe-pesanan').value = tipe;

        const tabPickup = document.getElementById('tab-pickup');
        const tabDelivery = document.getElementById('tab-delivery');
        const sectionDelivery = document.getElementById('section-delivery');
        const shippingFeeRow = document.getElementById('shipping-fee-row');
        const jarakInfoContainer = document.getElementById('jarak-info-container');

        const activeClass = "flex-1 py-2.5 text-sm font-black rounded-xl transition-all active:scale-95 bg-primary text-white shadow-sm";
        const inactiveClass = "flex-1 py-2.5 text-sm font-black rounded-xl transition-all active:scale-95 text-zinc-500 hover:bg-white/50";

        if (tipe === 1) {
            tabPickup.className = activeClass;
            tabDelivery.className = inactiveClass;
            sectionDelivery.classList.add('hidden');
            shippingFeeRow.style.display = 'none';
            jarakInfoContainer.style.display = 'none';

            document.getElementById('input-ongkir').value = 0;
            document.getElementById('btn-submit').disabled = false;
            document.getElementById('btn-submit').innerText = 'Bayar Sekarang';
            calculateShipping();
        } else {
            tabPickup.className = inactiveClass;
            tabDelivery.className = activeClass;
            sectionDelivery.classList.remove('hidden');
            shippingFeeRow.style.display = 'flex';

            if (customerAddresses.length > 0) {
                const mainAddress = customerAddresses.find(a => a.is_utama) || customerAddresses[0];
                selectAddress(mainAddress.id_alamat);
            } else {
                updateAddressHeaderEmpty();
            }
        }
    }

    function selectAddress(id) {
        const addr = customerAddresses.find(a => a.id_alamat == id);
        if (!addr) return;

        currentSelectedId = id;
        document.getElementById('input-id-alamat').value = id;
        document.getElementById('input-latitude').value = addr.latitude;
        document.getElementById('input-longitude').value = addr.longitude;
        document.getElementById('input-alamat-lengkap').value = addr.alamat_lengkap;

        document.getElementById('display-nama').innerText = addr.nama_penerima;
        document.getElementById('display-hp').innerText = addr.no_hp;
        document.getElementById('display-alamat').innerText = addr.alamat_lengkap;
        document.getElementById('display-label').innerText = addr.label;

        calculateShipping();
    }

    function updateAddressHeaderEmpty() {
        document.getElementById('input-id-alamat').value = '';
        document.getElementById('display-nama').innerText = 'Belum ada alamat pengiriman';
        document.getElementById('display-hp').innerText = '';
        document.getElementById('display-alamat').innerText = 'Silakan tambahkan alamat baru.';
        document.getElementById('display-label').innerText = 'PENTING';

        const btnSubmit = document.getElementById('btn-submit');
        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Alamat Belum Dipilih';
    }

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    function deg2rad(deg) { return deg * (Math.PI/180); }

    function calculateShipping() {
        let ongkir = 0;
        let total = subtotal;

        if (tipePesanan === 2) {
            const lat = parseFloat(document.getElementById('input-latitude').value);
            const lng = parseFloat(document.getElementById('input-longitude').value);
            const btnSubmit = document.getElementById('btn-submit');
            const ongkirLabel = document.getElementById('ongkir-label');
            const jarakLabel = document.getElementById('jarak-label');
            const jarakInfoContainer = document.getElementById('jarak-info-container');

            if (!lat || !lng) {
                updateAddressHeaderEmpty();
                return;
            }

            const distanceKm = getDistanceFromLatLonInKm(tokoLat, tokoLng, lat, lng);
            jarakInfoContainer.style.display = 'flex';
            jarakLabel.innerText = distanceKm.toFixed(2) + ' km';

            if (distanceKm > maxRadius) {
                ongkirLabel.innerText = 'Di luar jangkauan!';
                ongkirLabel.classList.add('text-red-500');
                btnSubmit.disabled = true;
                btnSubmit.innerText = 'Lokasi Terlalu Jauh';
                return;
            } else {
                ongkirLabel.classList.remove('text-red-500');
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Bayar Sekarang';
            }

            if (distanceKm <= 3) {
                ongkir = tarif0_3;
            } else {
                ongkir = tarif0_3;
                const excessKm = distanceKm - 3;
                const kelipatan500m = Math.ceil(excessKm / 0.5);
                ongkir += (kelipatan500m * tarif3_7);
            }

            ongkirLabel.innerText = formatRupiah(ongkir);
            total += ongkir;
        }

        let poinDipakai = 0;
        const usePoinCheckbox = document.getElementById('toggle-poin');
        const diskonPoinRow = document.getElementById('diskon-poin-row');
        const diskonPoinLabel = document.getElementById('diskon-poin-label');

        if (usePoinCheckbox && usePoinCheckbox.checked) {
            const userPoin = parseInt(document.getElementById('saldo-poin-label').dataset.poin) || 0;
            poinDipakai = Math.min(userPoin, total);
            total -= poinDipakai;

            if(diskonPoinRow) diskonPoinRow.classList.remove('hidden');
            if(diskonPoinLabel) diskonPoinLabel.innerText = '-Rp ' + poinDipakai.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        } else {
            if(diskonPoinRow) diskonPoinRow.classList.add('hidden');
        }

        document.getElementById('total-bayar-label').innerText = formatRupiah(total);
        document.getElementById('input-ongkir').value = ongkir;
        document.getElementById('input-total').value = total;
    }

    // MODAL CONTROLS
    function openModalAlamatSaya() {
        renderAddressList();
        document.getElementById('modal-alamat-saya').classList.remove('hidden');
    }

    function closeModalAlamatSaya() {
        document.getElementById('modal-alamat-saya').classList.add('hidden');
    }

    function renderAddressList() {
        const container = document.getElementById('address-list-container');
        container.innerHTML = '';

        if (customerAddresses.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <span class="text-4xl">🗺️</span>
                    <p class="text-zinc-500 text-sm font-bold mt-2">Belum ada alamat pengiriman.</p>
                </div>
            `;
            return;
        }

        customerAddresses.forEach(addr => {
            const isChecked = addr.id_alamat == currentSelectedId;
            const div = document.createElement('div');
            div.className = `p-4 rounded-xl border-2 transition-all flex items-start gap-3 relative ${isChecked ? 'border-amber-500 bg-amber-50/30' : 'border-zinc-100 bg-white'}`;

            div.innerHTML = `
                <input type="radio" name="select_modal_addr" value="${addr.id_alamat}" class="mt-1 accent-amber-600" ${isChecked ? 'checked' : ''} onchange="selectAddress(${addr.id_alamat}); closeModalAlamatSaya();">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-black text-sm text-zinc-950">${addr.nama_penerima}</span>
                        <span class="text-zinc-500 text-xs font-semibold">${addr.no_hp}</span>
                    </div>
                    <p class="text-zinc-500 text-[11px] font-bold uppercase tracking-wider mt-1 flex items-center gap-1">
                        <span class="px-2 py-0.5 bg-zinc-100 rounded text-zinc-600">${addr.label}</span>
                        ${addr.is_utama ? '<span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded font-black">Utama</span>' : ''}
                    </p>
                    <p class="text-zinc-600 text-xs font-semibold mt-2 leading-relaxed">${addr.alamat_lengkap}</p>
                </div>
                <div class="flex flex-col gap-2 shrink-0 self-center">
                    <button type="button" onclick="openFormAlamat(${addr.id_alamat})" class="text-xs font-black text-primary hover:text-primary-dark transition-colors cursor-pointer">Ubah</button>
                    <button type="button" onclick="deleteAlamat(${addr.id_alamat})" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors cursor-pointer">Hapus</button>
                </div>
            `;
            container.appendChild(div);
        });
    }

    // FORM MODAL
    let m_map = null;
    let m_marker = null;

    function openFormAlamat(id = null) {
        document.getElementById('modal-alamat-saya').classList.add('hidden');
        document.getElementById('modal-form-alamat').classList.remove('hidden');

        document.getElementById('form-id-alamat').value = '';
        document.getElementById('form-nama-penerima').value = '';
        document.getElementById('form-no-hp').value = '';
        document.getElementById('form-search-alamat').value = '';
        document.getElementById('form-alamat-detail').value = '';
        document.getElementById('form-latitude').value = tokoLat;
        document.getElementById('form-longitude').value = tokoLng;
        document.getElementById('form-is-utama').checked = false;
        setFormLabel('Rumah');

        if (id) {
            document.getElementById('form-alamat-title').innerHTML = '<i data-lucide="edit" class="w-5 h-5 text-primary"></i> Ubah Alamat';
            const addr = customerAddresses.find(a => a.id_alamat == id);
            if (addr) {
                document.getElementById('form-id-alamat').value = addr.id_alamat;
                document.getElementById('form-nama-penerima').value = addr.nama_penerima;
                document.getElementById('form-no-hp').value = addr.no_hp;
                document.getElementById('form-alamat-detail').value = addr.alamat_lengkap;
                document.getElementById('form-latitude').value = addr.latitude;
                document.getElementById('form-longitude').value = addr.longitude;
                document.getElementById('form-is-utama').checked = addr.is_utama;
                setFormLabel(addr.label);
                initModalMap(addr.latitude, addr.longitude);
            }
        } else {
            document.getElementById('form-alamat-title').innerHTML = '<i data-lucide="plus" class="w-5 h-5 text-primary"></i> Alamat Baru';
            document.getElementById('form-nama-penerima').value = "{{ Auth::user()->nama_lengkap }}";
            document.getElementById('form-no-hp').value = "{{ Auth::user()->no_hp ?? '' }}";
            initModalMap(tokoLat, tokoLng);
        }

        if (typeof lucide !== 'undefined') setTimeout(() => lucide.createIcons(), 50);
    }

    function closeFormAlamat() {
        document.getElementById('modal-form-alamat').classList.add('hidden');
        document.getElementById('modal-alamat-saya').classList.remove('hidden');
    }

    function setFormLabel(lbl) {
        document.getElementById('form-label-value').value = lbl;
        const btnRumah = document.getElementById('label-btn-Rumah');
        const btnKantor = document.getElementById('label-btn-Kantor');

        const active = "flex-1 py-2 text-xs font-black rounded-lg border-2 border-amber-500 bg-amber-50/30 text-amber-700 transition-all active:scale-95";
        const inactive = "flex-1 py-2 text-xs font-black rounded-lg border-2 border-zinc-200 bg-white text-zinc-500 transition-all active:scale-95";

        if (lbl === 'Rumah') {
            btnRumah.className = active;
            btnKantor.className = inactive;
        } else {
            btnRumah.className = inactive;
            btnKantor.className = active;
        }
    }

    function initModalMap(lat, lng) {
        setTimeout(() => {
            if (!m_map) {
                m_map = L.map('modal-map').setView([lat, lng], 15);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap &copy; CARTO',
                    maxZoom: 20
                }).addTo(m_map);

                m_marker = L.marker([lat, lng], { draggable: true }).addTo(m_map);

                m_map.on('click', function(e) {
                    const newLat = e.latlng.lat;
                    const newLng = e.latlng.lng;
                    m_marker.setLatLng([newLat, newLng]);
                    updateModalCoordinates(newLat, newLng);
                    reverseGeocodeModal(newLat, newLng);
                });

                m_marker.on('dragend', function(e) {
                    const pos = m_marker.getLatLng();
                    updateModalCoordinates(pos.lat, pos.lng);
                    reverseGeocodeModal(pos.lat, pos.lng);
                });
            } else {
                m_map.setView([lat, lng], 15);
                m_marker.setLatLng([lat, lng]);
            }
            m_map.invalidateSize();
        }, 200);
    }

    function updateModalCoordinates(lat, lng) {
        document.getElementById('form-latitude').value = lat;
        document.getElementById('form-longitude').value = lng;
    }

    function reverseGeocodeModal(lat, lng) {
        const loading = document.getElementById('form-georeverse-loading');
        loading.classList.remove('hidden');

        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(res => res.json())
            .then(data => {
                loading.classList.add('hidden');
                if (data.display_name) {
                    document.getElementById('form-search-alamat').value = data.display_name;
                    document.getElementById('form-alamat-detail').value = data.display_name;
                }
            })
            .catch(err => {
                loading.classList.add('hidden');
                console.error(err);
            });
    }

    // Autocomplete
    const modalSearchInput = document.getElementById('form-search-alamat');
    const modalSuggestions = document.getElementById('form-suggestions');
    const modalSearchBtn = document.getElementById('form-btn-cari');
    let modalTimer;

    modalSearchInput.addEventListener('input', function() {
        clearTimeout(modalTimer);
        const query = this.value;
        if (query.length < 3) {
            modalSuggestions.classList.add('hidden');
            return;
        }
        modalTimer = setTimeout(() => { fetchModalSuggestions(query); }, 500);
    });

    modalSearchBtn.addEventListener('click', () => fetchModalSuggestions(modalSearchInput.value));

    function fetchModalSuggestions(query) {
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`;
        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(res => res.json())
            .then(data => {
                modalSuggestions.innerHTML = '';
                if (data.length === 0) { modalSuggestions.classList.add('hidden'); return; }
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'p-3 hover:bg-amber-50/50 cursor-pointer text-xs font-bold text-zinc-700 transition-colors';
                    div.textContent = item.display_name;
                    div.addEventListener('click', function () {
                        modalSearchInput.value = item.display_name;
                        document.getElementById('form-alamat-detail').value = item.display_name;
                        modalSuggestions.classList.add('hidden');
                        const lat = parseFloat(item.lat);
                        const lon = parseFloat(item.lon);
                        m_map.setView([lat, lon], 15);
                        m_marker.setLatLng([lat, lon]);
                        updateModalCoordinates(lat, lon);
                    });
                    modalSuggestions.appendChild(div);
                });
                modalSuggestions.classList.remove('hidden');
            })
            .catch(err => console.error(err));
    }

    // AJAX SUBMIT
    function submitAlamatForm() {
        const id_alamat = document.getElementById('form-id-alamat').value;
        const nama_penerima = document.getElementById('form-nama-penerima').value;
        const no_hp = document.getElementById('form-no-hp').value;
        const label = document.getElementById('form-label-value').value;
        const alamat_lengkap = document.getElementById('form-alamat-detail').value;
        const latitude = document.getElementById('form-latitude').value;
        const longitude = document.getElementById('form-longitude').value;
        const is_utama = document.getElementById('form-is-utama').checked ? 1 : 0;

        if (!nama_penerima || !no_hp || !alamat_lengkap || !latitude || !longitude) {
            alert('Silakan lengkapi formulir alamat Anda.');
            return;
        }

        fetch("{{ route('customer.alamat.simpan') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                id_alamat: id_alamat || null,
                nama_penerima: nama_penerima,
                no_hp: no_hp,
                label: label,
                alamat_lengkap: alamat_lengkap,
                latitude: latitude,
                longitude: longitude,
                is_utama: is_utama
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                customerAddresses = data.alamats.map(a => {
                    let namaPenerima = "{{ Auth::user()->nama_lengkap }}";
                    let noHp = "{{ Auth::user()->no_hp ?? '' }}";
                    let alamatDetail = a.alamat_lengkap;
                    if (a.alamat_lengkap.includes(' | ')) {
                        let parts = a.alamat_lengkap.split(' | ');
                        if (parts.length >= 3) {
                            namaPenerima = parts[0];
                            noHp = parts[1];
                            alamatDetail = parts[2];
                        }
                    }
                    return {
                        id_alamat: a.id_alamat,
                        label: a.label,
                        alamat_lengkap: alamatDetail,
                        nama_penerima: namaPenerima,
                        no_hp: noHp,
                        latitude: parseFloat(a.latitude),
                        longitude: parseFloat(a.longitude),
                        is_utama: a.is_utama
                    };
                });
                const targetId = id_alamat || customerAddresses[0].id_alamat;
                document.getElementById('modal-form-alamat').classList.add('hidden');
                selectAddress(targetId);
            } else {
                alert(data.message || 'Gagal menyimpan alamat.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Kesalahan saat menyimpan alamat.');
        });
    }

    // AJAX DELETE
    function deleteAlamat(id) {
        if (!confirm('Hapus alamat pengiriman ini?')) return;

        fetch(`/customer/alamat/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                customerAddresses = data.alamats.map(a => {
                    let namaPenerima = "{{ Auth::user()->nama_lengkap }}";
                    let noHp = "{{ Auth::user()->no_hp ?? '' }}";
                    let alamatDetail = a.alamat_lengkap;
                    if (a.alamat_lengkap.includes(' | ')) {
                        let parts = a.alamat_lengkap.split(' | ');
                        if (parts.length >= 3) {
                            namaPenerima = parts[0];
                            noHp = parts[1];
                            alamatDetail = parts[2];
                        }
                    }
                    return {
                        id_alamat: a.id_alamat,
                        label: a.label,
                        alamat_lengkap: alamatDetail,
                        nama_penerima: namaPenerima,
                        no_hp: noHp,
                        latitude: parseFloat(a.latitude),
                        longitude: parseFloat(a.longitude),
                        is_utama: a.is_utama
                    };
                });
                if (currentSelectedId == id) {
                    if (customerAddresses.length > 0) {
                        selectAddress(customerAddresses[0].id_alamat);
                    } else {
                        updateAddressHeaderEmpty();
                    }
                }
                renderAddressList();
            }
        })
        .catch(err => console.error(err));
    }

    // SUBMIT CHECKOUT
    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const btnSubmit = document.getElementById('btn-submit');
        const initialText = btnSubmit.innerText;
        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Memproses...';

        fetch("{{ route('customer.checkout.proses') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                tipe_pesanan: tipePesanan,
                id_alamat: document.getElementById('input-id-alamat').value || null,
                alamat_lengkap: document.getElementById('input-alamat-lengkap').value || null,
                latitude: document.getElementById('input-latitude').value || null,
                longitude: document.getElementById('input-longitude').value || null,
                subtotal: subtotal
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.error || 'Gagal memproses pesanan'); });
            }
            return response.json();
        })
        .then(data => {
            if (data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function (result) {
                        window.location.href = `/customer/tracking?id=${data.id_pesanan}&status=success`;
                    },
                    onPending: function (result) {
                        window.location.href = `/customer/tracking?id=${data.id_pesanan}&status=pending`;
                    },
                    onError: function (result) {
                        alert("Gagal melakukan pembayaran. Silakan coba lagi.");
                        btnSubmit.disabled = false;
                        btnSubmit.innerText = initialText;
                    },
                    onClose: function () {
                        window.location.href = `/customer/tracking?id=${data.id_pesanan}&status=pending`;
                    }
                });
            } else {
                throw new Error("Token pembayaran gagal diterima.");
            }
        })
        .catch(error => {
            alert(error.message);
            btnSubmit.disabled = false;
            btnSubmit.innerText = initialText;
        });
    });

    window.addEventListener('DOMContentLoaded', () => {
        setTipePesanan(1);
    });
</script>
@endsection