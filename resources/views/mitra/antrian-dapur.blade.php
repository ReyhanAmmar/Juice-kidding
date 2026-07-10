@extends('layouts.main', ['hideHeader' => true, 'hideMinimalHeader' => true, 'hideFooter' => true])

@section('title', 'Antrian Dapur - Juice Kidding')

@section('content')
@include('mitra.partials.dapur-header')

<main class="w-full pt-14 pb-10 bg-[#F8F7FC] min-h-screen" role="main" aria-label="Antrian pesanan dapur">
    <div class="max-w-[900px] mx-auto px-4 md:px-8">

        {{-- Page Header --}}
        <div class="pt-8 pb-6 mb-8 border-b border-[#E8E6F0]">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-black text-[#1A1820] font-['Nunito']">Antrian Pesanan</h1>
                    <p class="text-[#9B97A8] text-sm font-medium mt-1">Daftar pesanan yang menunggu untuk diracik</p>
                </div>
            </div>
        </div>

        <!-- Auto-refresh Indicator -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2 text-xs font-bold text-[#9B97A8]">
                <span id="order-count-badge" class="inline-flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full shadow-[0_2px_16px_0_rgba(0,0,0,0.07)] border border-[#E8E6F0]">
                    <span class="w-2 h-2 rounded-full bg-[#96C84B]" id="status-dot" aria-hidden="true"></span>
                    <span id="order-count-text">Memuat pesanan...</span>
                </span>
            </div>
            <div class="inline-flex items-center gap-2 bg-white px-3 py-1.5 rounded-full shadow-[0_2px_16px_0_rgba(0,0,0,0.07)] border border-[#E8E6F0]">
                <div class="relative flex h-2 w-2">
                    <span class="animate-pulse absolute inline-flex h-full w-full rounded-full bg-[#96C84B] opacity-60" aria-hidden="true"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#96C84B]" aria-hidden="true"></span>
                </div>
                <span class="text-xs font-bold text-[#9B97A8]">Auto-refresh aktif</span>
                <button id="btn-refresh-now" class="text-xs font-bold text-[#E17D19] hover:text-[#C45E0A] transition-colors ml-1 cursor-pointer focus-visible:ring-2 focus-visible:ring-[#E17D19] focus-visible:outline-none rounded px-1.5 py-0.5" aria-label="Segarkan daftar pesanan sekarang">
                    ↻ Segarkan
                </button>
            </div>
        </div>

        <!-- Alerts -->
        <div id="alert-container">
            @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-[#EEF7D8] border border-[#96C84B]/30 text-[#6E9A2A] rounded-xl flex items-center gap-3 alert-auto" role="alert">
                <i data-lucide="check-circle-2" class="w-5 h-5" aria-hidden="true"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-[#E11919]/10 border border-[#E11919]/30 text-[#E11919] rounded-xl flex items-center gap-3 alert-auto" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5" aria-hidden="true"></i>
                <span class="font-bold text-sm">{{ session('error') }}</span>
            </div>
            @endif
        </div>

        <!-- Cards Container -->
        <div id="dapur-cards-container" aria-live="polite" aria-relevant="additions removals">
            @include('mitra.partials.dapur-cards')
        </div>

    </div>
</main>

<div id="dapur-modal-container"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();

    const container = document.getElementById('dapur-cards-container');
    const orderCountText = document.getElementById('order-count-text');
    const orderCountBadge = document.getElementById('order-count-badge');
    const btnRefresh = document.getElementById('btn-refresh-now');
    let pollInterval = null;
    let isUpdating = false;

    // ===== Update order count badge =====
    function updateOrderCount() {
        const cards = container.querySelectorAll('.dapur-card');
        const count = cards.length;
        if (count > 0) {
            orderCountText.textContent = count + ' pesanan menunggu';
            orderCountBadge.classList.remove('hidden');
        } else {
            orderCountText.textContent = 'Tidak ada pesanan';
            orderCountBadge.classList.remove('hidden');
        }
    }

    // ===== Fetch orders via AJAX =====
    function fetchOrders() {
        if (isUpdating) return;
        isUpdating = true;

        fetch('{{ route("dapur.antrian.json") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Gagal mengambil data');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Preserve scroll position
                const scrollY = window.scrollY;

                container.innerHTML = data.html;

                // Re-init Lucide icons
                if (typeof lucide !== 'undefined') lucide.createIcons();

                // Restore scroll position
                window.scrollTo(0, scrollY);

                // Update count
                updateOrderCount();

                // Re-bind form handlers
                bindFormHandlers();
            }
        })
        .catch(err => {
            console.warn('Polling error:', err.message);
        })
        .finally(() => {
            isUpdating = false;
        });
    }

    // ===== Handle status update form submission =====
    function bindFormHandlers() {
        document.querySelectorAll('.dapur-status-form').forEach(form => {
            // Remove existing listener to avoid duplicates
            form.removeEventListener('submit', handleFormSubmit);
            form.addEventListener('submit', handleFormSubmit);
        });
    }

    function handleFormSubmit(e) {
        e.preventDefault();
        const form = e.currentTarget;
        const pesananId = form.dataset.pesananId;
        const status = form.querySelector('input[name="status"]').value;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;

        // Disable button and show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin" aria-hidden="true"></i> Memproses...';
        if (typeof lucide !== 'undefined') lucide.createIcons();

        fetch('{{ url("dapur/update-status") }}/' + pesananId, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: parseInt(status) })
        })
        .then(async res => {
            if (!res.ok) throw new Error('Gagal memperbarui status');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // Show success toast
                showToast(data.message || 'Status berhasil diperbarui!', '✅');

                // Refresh the card list
                setTimeout(fetchOrders, 500);
            } else {
                showToast(data.message || 'Gagal memperbarui status', '❌');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        })
        .catch(err => {
            showToast(err.message || 'Terjadi kesalahan', '❌');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHtml;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    }

    // ===== Toast notification =====
    function showToast(msg, emoji) {
        const toast = document.getElementById('toast');
        const msgEl = document.getElementById('toast-msg');
        const emojiEl = document.getElementById('toast-emoji');
        if (msgEl) msgEl.textContent = msg;
        if (emojiEl) emojiEl.textContent = emoji || '✅';
        if (toast) {
            toast.classList.remove('opacity-0', '-translate-y-16', 'pointer-events-none');
            toast.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-16', 'pointer-events-none');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }, 3000);
        }
    }

    // ===== Manual refresh =====
    btnRefresh.addEventListener('click', function(e) {
        e.preventDefault();
        showToast('Memperbarui daftar pesanan...', '↻');
        fetchOrders();
    });

    // ===== Start polling =====
    function startPolling() {
        // Initial fetch
        updateOrderCount();
        bindFormHandlers();

        // Poll every 30 seconds
        pollInterval = setInterval(fetchOrders, 30000);
    }

    // ===== Stop polling on page unload =====
    window.addEventListener('beforeunload', function() {
        if (pollInterval) {
            clearInterval(pollInterval);
            pollInterval = null;
        }
    });

    // ===== Auto-dismiss server-side alerts after 5s =====
    document.querySelectorAll('.alert-auto').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Start
    startPolling();
});

function showDetailModal(id_pesanan) {
    fetch(`{{ url('/dapur/pesanan') }}/${id_pesanan}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('dapur-modal-container').innerHTML = data.html;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            } else {
                alert('Gagal memuat detail pesanan.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem.');
        });
}

function closeDetailModal(id_pesanan) {
    const modal = document.getElementById(`detail-modal-${id_pesanan}`);
    if (modal) {
        modal.classList.add('hidden');
        setTimeout(() => {
            document.getElementById('dapur-modal-container').innerHTML = '';
        }, 300);
    }
}
</script>
@endsection