@extends('layouts.app-admin')

@section('title', 'Pengaturan Sistem & Lokasi Toko')

@section('content')
<!-- Leaflet.js CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 font-['Nunito']">Pengaturan Sistem</h1>
            <p class="text-zinc-500 mt-1 font-medium">Atur lokasi toko dan konfigurasi ongkos kirim pengantaran.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-2xl flex items-center gap-3 border border-green-100 animate-scale-in">
        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="bg-white rounded-3xl border border-zinc-150 p-8 shadow-sm relative overflow-hidden">
        @csrf
        @method('PUT')

        {{-- Accent top color line --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-500 to-orange-500"></div>

        <h3 class="text-xl font-black text-zinc-900 mb-6 flex items-center gap-2 font-['Nunito']">
            <i data-lucide="map-pin" class="w-5 h-5 text-amber-600"></i> Lokasi Toko (Pusat Toko)
        </h3>
        
        <div class="space-y-6 mb-10">
            {{-- Autocomplete / Search input --}}
            <div class="relative">
                <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Cari Alamat Toko</label>
                <div class="flex gap-2">
                    <input type="text" id="cari-alamat-toko" placeholder="Masukkan jalan, kecamatan, atau kota..." class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-amber-500 font-semibold text-zinc-900 placeholder-zinc-300 transition-all">
                    <button type="button" id="btn-cari" class="px-6 py-3 bg-zinc-950 text-white font-black rounded-2xl hover:bg-zinc-800 active:scale-95 transition-all text-sm">Cari</button>
                </div>
                <div id="daftar-saran" class="absolute left-0 right-0 mt-1 bg-white border border-zinc-200 rounded-2xl shadow-lg z-50 hidden max-h-60 overflow-y-auto divide-y divide-zinc-150"></div>
            </div>

            {{-- Leaflet click-to-pin Map container --}}
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider">Ketuk Peta atau Geser Pin untuk Presisi</label>
                    <span id="georeverse-loading" class="text-xs text-zinc-500 hidden animate-pulse font-bold">Mendeteksi alamat...</span>
                </div>
                <div id="map" class="w-full h-[300px] rounded-2xl border border-zinc-250 shadow-inner z-10"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Latitude</label>
                    <input type="text" name="latitude_toko" id="latitude_toko" value="{{ old('latitude_toko', $konfigurasi->latitude_toko) }}" required readonly class="w-full px-4 py-3 bg-zinc-100 border border-zinc-200 rounded-2xl font-bold text-zinc-600 focus:outline-none">
                    @error('latitude_toko') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Longitude</label>
                    <input type="text" name="longitude_toko" id="longitude_toko" value="{{ old('longitude_toko', $konfigurasi->longitude_toko) }}" required readonly class="w-full px-4 py-3 bg-zinc-100 border border-zinc-200 rounded-2xl font-bold text-zinc-600 focus:outline-none">
                    @error('longitude_toko') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Alamat Toko Lengkap (Text)</label>
                <textarea name="alamat_toko" id="alamat_toko" rows="3" required placeholder="Alamat jalan lengkap toko..." class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-amber-500 font-semibold text-zinc-900 placeholder-zinc-300 transition-all resize-none">{{ old('alamat_toko', $konfigurasi->alamat_toko) }}</textarea>
                @error('alamat_toko') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <hr class="border-zinc-100 mb-10">

        <h3 class="text-xl font-black text-zinc-900 mb-6 flex items-center gap-2 font-['Nunito']">
            <i data-lucide="truck" class="w-5 h-5 text-amber-600"></i> Tarif & Jarak Pengiriman
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Tarif Flat (0 - 3 km)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-zinc-500 font-black text-sm">Rp</span>
                    <input type="number" name="tarif_0_3km" value="{{ old('tarif_0_3km', $konfigurasi->tarif_0_3km) }}" required class="w-full pl-12 pr-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-amber-500 font-bold text-zinc-900">
                </div>
                @error('tarif_0_3km') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Tarif Tambahan (> 3 km)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-zinc-500 font-black text-sm">Rp</span>
                    <input type="number" name="tarif_3_7km" value="{{ old('tarif_3_7km', $konfigurasi->tarif_3_7km) }}" required class="w-full pl-12 pr-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-amber-500 font-bold text-zinc-900">
                </div>
                <p class="text-[10px] text-zinc-500 font-bold mt-2">Dikenakan per kelipatan 500 meter setelah 3 km.</p>
                @error('tarif_3_7km') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Radius Batas Maksimal</label>
                <div class="relative">
                    <input type="number" step="0.1" name="radius_maks_km" value="{{ old('radius_maks_km', $konfigurasi->radius_maks_km) }}" required class="w-full pl-4 pr-12 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-amber-500 font-bold text-zinc-900">
                    <span class="absolute right-4 top-3.5 text-zinc-500 font-black text-sm">km</span>
                </div>
                @error('radius_maks_km') <p class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end mt-10">
            <button type="submit" class="px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-2xl transition-all shadow-md active:scale-95">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

{{-- ===== CRUD ALAMAT TOKO ===== --}}
<div class="bg-white rounded-3xl border border-zinc-150 p-8 shadow-sm relative overflow-hidden mt-8">
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-lime-500 to-emerald-500"></div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-black text-zinc-900 flex items-center gap-2">
                <i data-lucide="map-pin" class="w-5 h-5 text-emerald-600"></i> Daftar Alamat Toko / Cabang
            </h3>
            <p class="text-sm text-zinc-500 font-medium mt-1">Kelola multi-alamat untuk pengiriman dan referensi cabang</p>
        </div>
        <button onclick="openAlamatModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-xl shadow-sm transition-all active:scale-95">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Tambah Alamat
        </button>
    </div>

    @if(session('error_alamat'))
    <div class="mb-4 p-3.5 bg-red-50 text-red-700 rounded-2xl flex items-center gap-3 border border-red-100">
        <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
        <p class="font-bold text-sm">{{ session('error_alamat') }}</p>
    </div>
    @endif

    @if($alamatToko->count() > 0)
    <div class="space-y-3">
        @foreach($alamatToko as $a)
        <div class="flex items-start gap-4 p-4 rounded-2xl border border-zinc-100 hover:border-zinc-200 transition-all {{ $a->is_active ? 'bg-white' : 'bg-zinc-50/50 opacity-70' }}">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-black text-sm flex-shrink-0 shadow-sm">
                {{ strtoupper(substr($a->label, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-black text-zinc-900">{{ $a->label }}</span>
                    @if($a->is_active)
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                    @else
                    <span class="text-[10px] font-bold text-zinc-400 bg-zinc-100 px-2 py-0.5 rounded-full">Nonaktif</span>
                    @endif
                </div>
                <p class="text-sm text-zinc-600 font-medium mt-1 truncate" title="{{ $a->alamat_lengkap }}">{{ $a->alamat_lengkap }}</p>
                <p class="text-[11px] text-zinc-400 font-mono font-bold mt-0.5">{{ $a->latitude }}, {{ $a->longitude }}</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button onclick="editAlamat({{ $a->id_alamat_toko }})" class="px-3 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold rounded-xl text-xs transition-all active:scale-95 flex items-center gap-1">
                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                </button>
                <form action="{{ route('admin.alamat-toko.destroy', $a->id_alamat_toko) }}" method="POST" onsubmit="return confirm('Hapus alamat {{ $a->label }}?')" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded-xl text-xs transition-all active:scale-95 flex items-center gap-1">
                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="py-10 text-center border border-dashed border-zinc-200 rounded-2xl">
        <div class="w-14 h-14 rounded-2xl bg-zinc-50 flex items-center justify-center mx-auto mb-3">
            <i data-lucide="map-pin" class="w-7 h-7 text-zinc-300"></i>
        </div>
        <p class="text-sm font-black text-zinc-500">Belum Ada Alamat Toko</p>
        <p class="text-xs text-zinc-400 mt-1">Tambahkan alamat cabang atau lokasi toko pertama.</p>
    </div>
    @endif
</div>

{{-- Modal Alamat Toko --}}
<div id="alamat-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white w-full max-w-lg rounded-3xl overflow-hidden shadow-2xl animate-scale-in max-h-[90vh] flex flex-col">
        <form id="alamat-form" method="POST" action="{{ route('admin.alamat-toko.store') }}" class="flex flex-col max-h-[90vh]">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id_alamat_toko" id="input-id">

            <div class="p-6 pb-4 border-b border-zinc-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-zinc-900" id="modal-title">Tambah Alamat Toko</h3>
                    <p class="text-sm text-zinc-400 font-medium">Lengkapi data lokasi toko / cabang</p>
                </div>
                <button type="button" onclick="closeAlamatModal()" class="w-10 h-10 rounded-full bg-zinc-50 hover:bg-zinc-100 flex items-center justify-center text-zinc-500 transition-all active:scale-90 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-5 flex-1">
                <div>
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Label / Nama</label>
                    <input type="text" name="label" id="input-label" required placeholder="Pusat, Cabang A, Gudang..."
                           class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-emerald-500 font-bold text-zinc-900 placeholder-zinc-300 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" id="input-alamat" rows="3" required placeholder="Jalan, kelurahan, kota..."
                              class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-emerald-500 font-semibold text-zinc-900 placeholder-zinc-300 transition-all resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Pilih Lokasi di Peta</label>
                    <div id="modal-map" class="w-full h-[200px] rounded-2xl border border-zinc-250 shadow-inner z-10 mb-2"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Latitude</label>
                        <input type="text" name="latitude" id="input-lat" required placeholder="-6.200000"
                               class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-emerald-500 font-bold text-zinc-900 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-zinc-500 uppercase tracking-wider mb-2">Longitude</label>
                        <input type="text" name="longitude" id="input-lng" required placeholder="106.816666"
                               class="w-full px-4 py-3 bg-zinc-50 border-2 border-zinc-200 rounded-2xl focus:outline-none focus:border-emerald-500 font-bold text-zinc-900 font-mono">
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="input-active" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-zinc-200 rounded-full peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:w-5 after:h-5 after:bg-white after:rounded-full after:shadow after:transition-all peer-checked:after:translate-x-4"></div>
                    </label>
                    <span class="text-sm font-bold text-zinc-700">Aktif</span>
                </div>
            </div>

            <div class="p-6 pt-4 border-t border-zinc-100 flex justify-end gap-3">
                <button type="button" onclick="closeAlamatModal()" class="px-6 py-2.5 border-2 border-zinc-200 text-zinc-600 font-bold rounded-xl hover:bg-zinc-50 transition-all active:scale-95 text-sm">Batal</button>
                <button type="submit" class="px-8 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-sm transition-all active:scale-95 text-sm flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const alamatData = @json($alamatToko);
    let modalMap;
    let modalMarker;

    function initModalMap(lat, lng) {
        lat = parseFloat(lat) || latDefault;
        lng = parseFloat(lng) || lngDefault;

        if (!modalMap) {
            modalMap = L.map('modal-map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 20
            }).addTo(modalMap);

            modalMarker = L.marker([lat, lng], { draggable: true }).addTo(modalMap);

            modalMap.on('click', function(e) {
                const newLat = e.latlng.lat;
                const newLng = e.latlng.lng;
                modalMarker.setLatLng([newLat, newLng]);
                document.getElementById('input-lat').value = newLat.toFixed(8);
                document.getElementById('input-lng').value = newLng.toFixed(8);
            });

            modalMarker.on('dragend', function(e) {
                const pos = modalMarker.getLatLng();
                document.getElementById('input-lat').value = pos.lat.toFixed(8);
                document.getElementById('input-lng').value = pos.lng.toFixed(8);
            });
        } else {
            modalMap.setView([lat, lng], 15);
            modalMarker.setLatLng([lat, lng]);
        }
        
        // This is necessary because modal was hidden
        setTimeout(() => {
            modalMap.invalidateSize();
        }, 150);
    }

    function openAlamatModal() {
        document.getElementById('form-method').value = 'POST';
        document.getElementById('alamat-form').action = '{{ route("admin.alamat-toko.store") }}';
        document.getElementById('modal-title').textContent = 'Tambah Alamat Toko';
        document.getElementById('input-id').value = '';
        document.getElementById('input-label').value = '';
        document.getElementById('input-alamat').value = '';
        document.getElementById('input-lat').value = latDefault;
        document.getElementById('input-lng').value = lngDefault;
        document.getElementById('input-active').checked = true;
        document.getElementById('alamat-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (typeof lucide !== 'undefined') lucide.createIcons();
        initModalMap(latDefault, lngDefault);
    }

    function closeAlamatModal() {
        document.getElementById('alamat-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function editAlamat(id) {
        const data = alamatData.find(a => a.id_alamat_toko === id);
        if (!data) return;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('alamat-form').action = '{{ url("admin/alamat-toko") }}/' + id;
        document.getElementById('modal-title').textContent = 'Edit Alamat Toko';
        document.getElementById('input-id').value = id;
        document.getElementById('input-label').value = data.label;
        document.getElementById('input-alamat').value = data.alamat_lengkap;
        document.getElementById('input-lat').value = data.latitude;
        document.getElementById('input-lng').value = data.longitude;
        document.getElementById('input-active').checked = data.is_active;
        document.getElementById('alamat-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        if (typeof lucide !== 'undefined') lucide.createIcons();
        initModalMap(data.latitude, data.longitude);
    }

    document.getElementById('alamat-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeAlamatModal();
    });

    // Update modal map on manual lat/lng input
    document.getElementById('input-lat').addEventListener('input', updateModalMarkerFromInputs);
    document.getElementById('input-lng').addEventListener('input', updateModalMarkerFromInputs);

    function updateModalMarkerFromInputs() {
        if (modalMarker && modalMap) {
            let lat = parseFloat(document.getElementById('input-lat').value);
            let lng = parseFloat(document.getElementById('input-lng').value);
            if (!isNaN(lat) && !isNaN(lng)) {
                modalMarker.setLatLng([lat, lng]);
                modalMap.setView([lat, lng]);
            }
        }
    }

    // Map script
    const latDefault = {{ $konfigurasi->latitude_toko ?? -6.200000 }};
    const lngDefault = {{ $konfigurasi->longitude_toko ?? 106.816666 }};

    let map = L.map('map').setView([latDefault, lngDefault], 14);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        maxZoom: 20
    }).addTo(map);

    let marker = L.marker([latDefault, lngDefault], { draggable: true }).addTo(map);

    // Click map to set pin
    map.on('click', function(e) {
        const newLat = e.latlng.lat;
        const newLng = e.latlng.lng;
        marker.setLatLng([newLat, newLng]);
        updateCoordinates(newLat, newLng);
        reverseGeocode(newLat, newLng);
    });

    // Drag marker pin
    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        updateCoordinates(pos.lat, pos.lng);
        reverseGeocode(pos.lat, pos.lng);
    });

    function updateCoordinates(lat, lng) {
        document.getElementById('latitude_toko').value = lat.toFixed(8);
        document.getElementById('longitude_toko').value = lng.toFixed(8);
    }

    // Reverse Geocode
    function reverseGeocode(lat, lng) {
        const loading = document.getElementById('georeverse-loading');
        loading.classList.remove('hidden');

        const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(res => res.json())
            .then(data => {
                loading.classList.add('hidden');
                if (data.display_name) {
                    document.getElementById('cari-alamat-toko').value = data.display_name;
                    document.getElementById('alamat_toko').value = data.display_name;
                }
            })
            .catch(err => {
                loading.classList.add('hidden');
                console.error(err);
            });
    }

    // Autocomplete Search
    const searchInput = document.getElementById('cari-alamat-toko');
    const suggestions = document.getElementById('daftar-saran');
    const searchBtn = document.getElementById('btn-cari');
    let timer;

    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        const query = this.value;
        if (query.length < 3) {
            suggestions.classList.add('hidden');
            return;
        }

        timer = setTimeout(() => {
            fetchSuggestions(query);
        }, 500);
    });

    searchBtn.addEventListener('click', () => fetchSuggestions(searchInput.value));

    function fetchSuggestions(query) {
        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`;
        
        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(res => res.json())
            .then(data => {
                suggestions.innerHTML = '';
                if (data.length === 0) {
                    suggestions.classList.add('hidden');
                    return;
                }

                data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'p-3 hover:bg-amber-50/50 cursor-pointer text-xs font-bold text-zinc-700 transition-colors';
                    div.textContent = item.display_name;
                    
                    div.addEventListener('click', function () {
                        searchInput.value = item.display_name;
                        document.getElementById('alamat_toko').value = item.display_name;
                        suggestions.classList.add('hidden');

                        const lat = parseFloat(item.lat);
                        const lon = parseFloat(item.lon);

                        map.setView([lat, lon], 15);
                        marker.setLatLng([lat, lon]);
                        updateCoordinates(lat, lon);
                    });

                    suggestions.appendChild(div);
                });
                suggestions.classList.remove('hidden');
            })
            .catch(err => console.error(err));
    }

    // Hide dropdown on click outside
    document.addEventListener('click', function (e) {
        if (e.target !== searchInput && e.target !== suggestions) {
            suggestions.classList.add('hidden');
        }
    });
</script>
@endsection
