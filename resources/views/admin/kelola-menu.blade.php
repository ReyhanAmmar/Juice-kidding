@extends('layouts.app-admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')
@section('page-subtitle', 'Atur menu jus yang tersedia')

@section('content')
{{-- Product Table (Section 7.12) --}}
<div class="bg-white rounded-2xl shadow-card overflow-hidden animate-fade-in-up">
    {{-- Table Header --}}
    <div class="px-4 lg:px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-gray-100">
        <h3 class="font-black text-gray-900">Daftar Produk</h3>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            {{-- Search --}}
            <div class="flex items-center bg-gray-50 rounded-xl px-3 py-2 gap-2 border-2 border-transparent focus-within:border-primary focus-within:bg-white transition-all flex-1 sm:flex-none sm:w-52">
                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                <input type="text" id="table-search" placeholder="Cari produk..." class="bg-transparent text-sm font-medium text-gray-700 outline-none placeholder-gray-300 w-full" oninput="searchTable(this.value)">
            </div>
            {{-- Add Button --}}
            <button onclick="openModal('modal-tambah')"
                    class="bg-primary hover:bg-primary-dark text-white text-sm font-bold px-4 py-2 rounded-xl shadow-btn transition-all active:scale-95 whitespace-nowrap flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span class="hidden sm:inline">Tambah Produk</span>
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="product-table">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Produk</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">Kategori</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Harga</th>
                    <th class="text-left px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Status</th>
                    <th class="text-right px-4 lg:px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="table-body">
                @php
                    $demoProducts = [
                        ['nama' => 'Jus Alpukat Susu', 'kategori' => 'Jus Buah', 'harga' => 18000, 'status' => 'tersedia', 'emoji' => '🥑'],
                        ['nama' => 'Smoothie Berry Blast', 'kategori' => 'Smoothie', 'harga' => 22000, 'status' => 'tersedia', 'emoji' => '🍓'],
                        ['nama' => 'Jus Jeruk Murni', 'kategori' => 'Jus Buah', 'harga' => 12000, 'status' => 'tersedia', 'emoji' => '🍊'],
                        ['nama' => 'Green Detox Juice', 'kategori' => 'Detox', 'harga' => 25000, 'status' => 'habis', 'emoji' => '🥬'],
                        ['nama' => 'Jus Mangga Thai', 'kategori' => 'Jus Buah', 'harga' => 16000, 'status' => 'tersedia', 'emoji' => '🥭'],
                        ['nama' => 'Kiwi Mint Splash', 'kategori' => 'Jus Buah', 'harga' => 15000, 'status' => 'tersedia', 'emoji' => '🥝'],
                    ];
                @endphp

                @foreach($demoProducts as $product)
                <tr class="hover:bg-gray-50/60 transition-colors product-row" data-name="{{ strtolower($product['nama']) }}">
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-light to-orange-100 flex items-center justify-center flex-shrink-0 text-xl">
                                {{ $product['emoji'] }}
                            </div>
                            <span class="font-bold text-gray-900">{{ $product['nama'] }}</span>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-gray-500 font-medium hidden md:table-cell">{{ $product['kategori'] }}</td>
                    <td class="px-4 lg:px-6 py-4 font-extrabold text-primary">Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                    <td class="px-4 lg:px-6 py-4 hidden sm:table-cell">
                        @if($product['status'] === 'tersedia')
                        <span class="text-[11px] font-bold text-secondary-dark bg-secondary-light px-2.5 py-1 rounded-full">Tersedia</span>
                        @else
                        <span class="text-[11px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">Habis</span>
                        @endif
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all" title="Edit">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </button>
                            <button onclick="openModal('modal-hapus')" class="p-2 rounded-xl hover:bg-red-50 text-accent-red transition-all" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Delete Confirmation Modal (Section 7.9) --}}
<div id="modal-hapus" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 hidden">
    <div class="bg-white rounded-3xl shadow-card-lg w-full max-w-sm p-6 animate-scale-in">
        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto">
            <i data-lucide="trash-2" class="w-7 h-7 text-accent-red"></i>
        </div>
        <h3 class="text-lg font-black text-gray-900 text-center mt-4">Hapus Produk?</h3>
        <p class="text-sm font-medium text-gray-500 text-center mt-2 leading-relaxed">
            Tindakan ini tidak dapat dibatalkan.<br>Produk akan dihapus secara permanen.
        </p>
        <div class="flex gap-3 mt-6">
            <button onclick="closeModal('modal-hapus')"
                class="flex-1 border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-2xl hover:bg-gray-50 text-sm transition-all">
                Batal
            </button>
            <button onclick="deleteProduct()"
                class="flex-1 bg-accent-red hover:opacity-90 text-white font-bold py-3 rounded-2xl text-sm transition-all active:scale-95">
                Hapus
            </button>
        </div>
    </div>
</div>

{{-- Add Product Modal --}}
<div id="modal-tambah" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 hidden">
    <div class="bg-white rounded-3xl shadow-card-lg w-full max-w-md p-6 animate-scale-in max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-black text-gray-900">Tambah Produk Baru</h3>
            <button onclick="closeModal('modal-tambah')" class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <form class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="prod-nama">Nama Produk</label>
                <input type="text" id="prod-nama" placeholder="Contoh: Jus Alpukat Susu"
                    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium text-gray-900 placeholder-gray-300 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15 transition-all bg-white">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="prod-kategori">Kategori</label>
                <select id="prod-kategori"
                    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15 transition-all bg-white">
                    <option value="">Pilih Kategori</option>
                    <option>Jus Buah</option>
                    <option>Smoothie</option>
                    <option>Detox</option>
                    <option>Milkshake</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="prod-harga">Harga (Rp)</label>
                    <input type="number" id="prod-harga" placeholder="15000"
                        class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium text-gray-900 placeholder-gray-300 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15 transition-all bg-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="prod-kalori">Kalori (kkal)</label>
                    <input type="number" id="prod-kalori" placeholder="120"
                        class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium text-gray-900 placeholder-gray-300 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15 transition-all bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide" for="prod-desc">Deskripsi</label>
                <textarea id="prod-desc" rows="3" placeholder="Deskripsi singkat produk..."
                    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm font-medium text-gray-900 placeholder-gray-300 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15 transition-all bg-white resize-none"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">Status Stok</label>
                <label class="relative inline-flex items-center cursor-pointer gap-3">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-12 h-6 bg-gray-200 rounded-full peer-checked:bg-secondary relative transition-colors duration-200
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5
                                after:shadow-sm after:transition-transform after:duration-200 peer-checked:after:translate-x-6"></div>
                    <span class="text-sm font-bold text-gray-700 peer-checked:text-secondary-dark">Tersedia</span>
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-tambah')"
                    class="flex-1 border-2 border-gray-200 text-gray-700 font-bold py-3 rounded-2xl hover:bg-gray-50 text-sm transition-all">
                    Batal
                </button>
                <button type="button" onclick="closeModal('modal-tambah'); showToast('Produk berhasil ditambahkan!', '✅')"
                    class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-3 rounded-2xl text-sm transition-all active:scale-95 shadow-btn">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    lucide.createIcons();
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function deleteProduct() {
    closeModal('modal-hapus');
    showToast('Produk berhasil dihapus!', '🗑️');
}

function searchTable(query) {
    query = query.toLowerCase().trim();
    document.querySelectorAll('.product-row').forEach(row => {
        const name = row.dataset.name;
        row.style.display = !query || name.includes(query) ? '' : 'none';
    });
}

// Close modal on backdrop click
document.querySelectorAll('[id^="modal-"]').forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
@endsection
