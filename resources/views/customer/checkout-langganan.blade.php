@extends('layouts.main')

@section('title', 'Checkout Langganan — Juice Kidding')

@section('content')
<main class="w-full pt-[81px] min-h-screen bg-gradient-to-b from-amber-50/40 via-white to-lime-50/30">
    {{-- Decorative blobs --}}
    <div class="fixed -top-32 -right-32 w-96 h-96 bg-amber-200/20 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="fixed -bottom-40 -left-32 w-[500px] h-[500px] bg-lime-200/20 rounded-full blur-[80px] pointer-events-none"></div>

    <div class="max-w-2xl mx-auto px-4 py-10 md:py-16 relative z-10">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('langganan.index') }}" class="inline-flex items-center gap-2 text-zinc-500 hover:text-amber-600 text-sm font-bold transition-colors mb-4 group">
                <span class="w-8 h-8 rounded-full bg-white shadow-sm border border-zinc-200 flex items-center justify-center group-hover:border-amber-300 group-hover:bg-amber-50 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </span>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-zinc-900 font-['Nunito']">Checkout Langganan</h1>
                <p class="text-zinc-500 text-sm font-medium mt-1">Konfigurasi jadwal & pengiriman paket Anda</p>
            </div>
        </div>

        {{-- Error Container --}}
        <div id="error-alert" class="mb-6 px-4 py-3.5 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 hidden animate-pop-in" role="alert">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
            <span id="error-message" class="font-bold text-xs"></span>
        </div>

        {{-- Package Summary Card --}}
        <div class="bg-white rounded-3xl p-6 md:p-7 border border-zinc-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] mb-6">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full">Paket Pilihan</span>
                @if($paket->gratis_ongkir)
                <span class="text-[10px] font-black uppercase tracking-wider text-lime-700 bg-lime-50 px-2.5 py-1 rounded-full">Gratis Ongkir</span>
                @endif
            </div>
            <div class="flex items-center justify-between mt-3">
                <div>
                    <h3 class="text-xl font-black text-zinc-900 font-['Nunito']">{{ $paket->nama_paket }}</h3>
                    @if($paket->deskripsi)
                    <p class="text-xs text-zinc-500 font-medium mt-1 max-w-sm">{{ $paket->deskripsi }}</p>
                    @endif
                </div>
                <div class="text-right flex-shrink-0">
                    <span class="text-2xl font-black text-amber-600 font-['Nunito']">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-zinc-100 flex items-center gap-6 text-xs">
                <div class="flex items-center gap-1.5">
                    <i data-lucide="bottle" class="w-3.5 h-3.5 text-amber-500"></i>
                    <span class="font-bold text-zinc-600">{{ $paket->total_pengiriman }} botol/minggu</span>
                </div>
                @if($paket->total_pengiriman > 0)
                <div class="flex items-center gap-1.5">
                    <i data-lucide="tag" class="w-3.5 h-3.5 text-lime-500"></i>
                    <span class="font-bold text-zinc-600">≈ Rp {{ number_format(intval($paket->harga / $paket->total_pengiriman), 0, ',', '.') }}/botol</span>
                </div>
                @endif
            </div>
        </div>

        @if($alamats->isEmpty())
        {{-- No Address Warning --}}
        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="map-pin" class="w-7 h-7 text-amber-600"></i>
            </div>
            <h3 class="text-base font-black text-zinc-800 font-['Nunito'] mb-2">Alamat Belum Terdaftar</h3>
            <p class="text-xs text-zinc-500 font-medium mb-6 max-w-xs mx-auto leading-relaxed">Anda harus mendaftarkan alamat pengiriman terlebih dahulu di profil Anda untuk memesan langganan.</p>
            <a href="{{ route('customer.alamat') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white text-xs font-bold rounded-full hover:bg-amber-700 transition-all active:scale-95 shadow-lg shadow-amber-600/25">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Alamat Baru
            </a>
        </div>
        @else
        {{-- Checkout Form --}}
        <form id="subscription-checkout-form" class="space-y-5">
            @csrf
            <input type="hidden" name="id_paket" id="input-id-paket" value="{{ $paket->id_paket }}">

            {{-- 1. Choose Address --}}
            <div class="bg-white rounded-3xl p-6 md:p-7 border border-zinc-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)]">
                <div class="flex items-center gap-2.5 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                        <i data-lucide="map-pin" class="w-4 h-4 text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-zinc-800 font-['Nunito']">Alamat Pengiriman</h3>
                        <p class="text-[10px] text-zinc-400 font-medium">Pilih alamat untuk pengiriman rutin</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($alamats as $alamat)
                    @php
                        $parts = explode(' | ', $alamat->alamat_lengkap);
                        $penerima = count($parts) > 1 ? $parts[0] : Auth::user()->nama_lengkap;
                        $noHp = count($parts) > 2 ? $parts[1] : Auth::user()->no_hp;
                        $alamatAsli = count($parts) > 2 ? implode(' | ', array_slice($parts, 2)) : $alamat->alamat_lengkap;
                    @endphp
                    <label class="block relative cursor-pointer group">
                        <input type="radio" name="id_alamat" id="input-id-alamat-{{ $alamat->id_alamat }}" value="{{ $alamat->id_alamat }}"
                               class="peer sr-only"
                               {{ $alamat->is_utama ? 'checked' : '' }}>
                        <div class="flex items-start gap-3.5 p-4 rounded-2xl border-2 border-zinc-100 bg-white transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50/30 hover:border-zinc-300 group-hover:shadow-sm">
                            <div class="mt-0.5 w-5 h-5 rounded-full border-2 border-zinc-300 flex items-center justify-center flex-shrink-0 peer-checked:border-amber-600 peer-checked:bg-amber-600 transition-all">
                                <div class="w-2 h-2 rounded-full bg-white scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="text-sm font-bold text-zinc-800 font-['Nunito']">{{ $alamat->label }}</span>
                                    @if($alamat->is_utama)
                                    <span class="bg-amber-100 text-amber-700 text-[8px] px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Utama</span>
                                    @endif
                                </div>
                                <p class="text-[10px] text-zinc-400 font-bold mt-0.5">{{ $penerima }} · {{ $noHp }}</p>
                                <p class="text-xs text-zinc-500 mt-1 leading-relaxed line-clamp-2">{{ $alamatAsli }}</p>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- 2. Choose Delivery Days --}}
            <div class="bg-white rounded-3xl p-6 md:p-7 border border-zinc-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)]">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-lime-100 flex items-center justify-center">
                        <i data-lucide="calendar" class="w-4 h-4 text-lime-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-zinc-800 font-['Nunito']">Jadwal Hari Pengiriman</h3>
                    </div>
                </div>
                <p class="text-[10px] text-zinc-400 font-medium mb-4 ml-[44px]">Pilih hari apa saja jus Anda akan diantarkan setiap minggunya.</p>

                <div class="grid grid-cols-3 gap-2.5">
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                    <label class="day-chip flex items-center justify-center p-3.5 rounded-2xl border-2 border-zinc-100 cursor-pointer text-xs font-bold text-zinc-600 bg-white hover:border-amber-300 hover:bg-amber-50/30 transition-all select-none has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 has-[:checked]:text-amber-700 active:scale-95">
                        <input type="checkbox" name="hari_pengiriman[]" value="{{ $hari }}" class="sr-only">
                        <span>{{ $hari }}</span>
                    </label>
                    @endforeach
                </div>
                <p id="day-counter" class="text-[10px] text-zinc-400 mt-2 text-center font-medium">0 hari dipilih</p>
            </div>

            {{-- 3. Choose Default Juice Variant --}}
            <div class="bg-white rounded-3xl p-6 md:p-7 border border-zinc-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)]">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-pink-100 flex items-center justify-center">
                        <i data-lucide="juice" class="w-4 h-4 text-pink-600" style="transform: rotate(15deg);"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-zinc-800 font-['Nunito']">Varian Jus Default</h3>
                    </div>
                </div>
                <p class="text-[10px] text-zinc-400 font-medium mb-4 ml-[44px]">Jus default yang akan dikirim secara rutin sesuai jadwal Anda.</p>

                <div class="relative">
                    <select name="id_menu_default" id="input-id-menu-default"
                            class="w-full bg-zinc-50 border-2 border-zinc-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-zinc-700 outline-none appearance-none cursor-pointer focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
                        <option value="" disabled selected>Pilih varian jus default</option>
                        @foreach($paket->menus as $menu)
                            <option value="{{ $menu->id_menu }}">{{ $menu->nama_jus }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-400">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>

            {{-- 4. Payment Summary & Submission --}}
            <div class="bg-white rounded-3xl p-6 md:p-7 border border-zinc-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)]">
                {{-- Price breakdown --}}
                <div class="space-y-2.5 mb-6 pb-5 border-b border-zinc-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-zinc-500 font-medium">Harga Paket</span>
                        <span class="text-zinc-800 font-bold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                    </div>
                    @if($paket->gratis_ongkir)
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-zinc-500 font-medium">Ongkos Kirim</span>
                        <span class="text-lime-600 font-bold flex items-center gap-1">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i> Gratis
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center text-base pt-2">
                        <span class="text-zinc-800 font-black">Total Dibayar</span>
                        <span class="text-2xl font-black text-amber-600 font-['Nunito']">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" id="btn-submit"
                        class="w-full py-4 bg-gradient-to-r from-amber-600 to-orange-500 hover:from-amber-700 hover:to-orange-600 text-white font-black rounded-2xl shadow-lg shadow-amber-600/25 active:scale-[0.98] hover:scale-[1.01] transition-all duration-300 text-sm disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer flex items-center justify-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Bayar Sekarang
                </button>

                <div class="mt-4 flex items-start gap-3 p-4 bg-zinc-50 rounded-xl border border-zinc-200/60">
                    <i data-lucide="shield-check" class="w-4.5 h-4.5 text-zinc-400 flex-shrink-0 mt-0.5"></i>
                    <p class="text-[10px] text-zinc-500 font-medium leading-relaxed">Pembayaran aman dengan enkripsi SSL via Midtrans. Layanan ini mendukung Transfer Bank, QRIS, & e-Wallet.</p>
                </div>
            </div>
        </form>
        @endif

    </div>
</main>

{{-- Midtrans Snap SDK --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // Day checkbox selection with counter
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="hari_pengiriman[]"]');
    const dayCounter = document.getElementById('day-counter');

    function updateDayCounter() {
        const checked = document.querySelectorAll('input[type="checkbox"][name="hari_pengiriman[]"]:checked').length;
        if (dayCounter) {
            dayCounter.textContent = checked + ' hari dipilih';
        }
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateDayCounter);
    });
    updateDayCounter();

    // Style radio buttons for address
    document.querySelectorAll('input[type="radio"][name="id_alamat"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // The CSS peer-checked handles the styling
        });
    });

    // Submit checkout form
    const form = document.getElementById('subscription-checkout-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const alertContainer = document.getElementById('error-alert');
            const alertMsg = document.getElementById('error-message');
            alertContainer.classList.add('hidden');

            const btnSubmit = document.getElementById('btn-submit');
            const initialText = btnSubmit.innerHTML;
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Memproses...';
            if (typeof lucide !== 'undefined') lucide.createIcons();

            // Gather selected days
            const selectedDays = [];
            checkboxes.forEach(cb => {
                if (cb.checked) selectedDays.push(cb.value);
            });

            const selectedAddress = document.querySelector('input[name="id_alamat"]:checked');
            const defaultJuice = document.getElementById('input-id-menu-default').value;

            // Validation
            if (!selectedAddress) {
                alertContainer.classList.remove('hidden');
                alertMsg.innerText = 'Silakan pilih alamat pengiriman.';
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = initialText;
                if (typeof lucide !== 'undefined') lucide.createIcons();
                return;
            }

            if (selectedDays.length === 0) {
                alertContainer.classList.remove('hidden');
                alertMsg.innerText = 'Silakan pilih minimal 1 hari pengiriman.';
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = initialText;
                if (typeof lucide !== 'undefined') lucide.createIcons();
                return;
            }

            if (!defaultJuice) {
                alertContainer.classList.remove('hidden');
                alertMsg.innerText = 'Silakan pilih varian jus default Anda.';
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = initialText;
                if (typeof lucide !== 'undefined') lucide.createIcons();
                return;
            }

            fetch("{{ route('customer.langganan.proses') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    id_paket: document.getElementById('input-id-paket').value,
                    id_alamat: selectedAddress.value,
                    hari_pengiriman: selectedDays,
                    id_menu_default: defaultJuice
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Gagal memproses pembelian langganan'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('customer.riwayat') }}?status=success_sub";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('customer.riwayat') }}?status=pending_sub";
                        },
                        onError: function (result) {
                            alertContainer.classList.remove('hidden');
                            alertMsg.innerText = 'Pembayaran gagal. Silakan coba kembali.';
                            btnSubmit.disabled = false;
                            btnSubmit.innerHTML = initialText;
                            if (typeof lucide !== 'undefined') lucide.createIcons();
                        },
                        onClose: function () {
                            alertContainer.classList.remove('hidden');
                            alertMsg.innerText = 'Pembayaran dibatalkan oleh Anda.';
                            btnSubmit.disabled = false;
                            btnSubmit.innerHTML = initialText;
                            if (typeof lucide !== 'undefined') lucide.createIcons();
                        }
                    });
                } else {
                    throw new Error('Midtrans snap token tidak diterima.');
                }
            })
            .catch(error => {
                alertContainer.classList.remove('hidden');
                alertMsg.innerText = error.message;
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = initialText;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        });
    }
});
</script>
@endsection