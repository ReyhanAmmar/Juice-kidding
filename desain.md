# DESAIN SISTEM — JUICE KIDDING
### Design Document v2.0 | Laravel + Tailwind CSS
### Color palette diekstrak langsung dari logo & nama brand resmi

---

## 1. IDENTITAS BRAND

**Juice Kidding** adalah aplikasi pemesanan jus segar yang menyasar kalangan muda usia 18–24 tahun. Visual brand didasarkan pada **logo dan nama brand resmi** yang sudah ada — karakter boks jus pelangi dengan ekspresi ceria, thumbs up, dan halo pelangi di atasnya.

**Kepribadian brand:** Fun · Colorful · Friendly · Fresh · Playful

**Prinsip visual:**
- Warna **rainbow/pelangi** dari logo adalah inti — jangan batasi ke satu warna saja
- Font rounded dan ramah — hindari font geometric kaku
- Nuansa cerah dan menyenangkan, bukan serius atau korporat
- Maskot (boks jus pelangi) dapat digunakan sebagai elemen dekoratif di splash screen, empty state, dan onboarding

---

## 2. PALET WARNA

> Semua warna diekstrak langsung dari piksel nama brand teks "Juice Kidding"
> dan maskot boks jus pelangi menggunakan analisis warna saturasi tinggi.
### 2.1 Rainbow Palette — Dari Logo

Warna-warna ini muncul secara berurutan di teks logo (kiri → kanan):

| Nama | Hex | RGB | Posisi di Logo |
|------|-----|-----|----------------|
| Jus Merah | `#E11919` | 225, 25, 25 | Huruf "J" |
| Jus Oranye | `#E17D19` | 225, 125, 25 | Huruf "u", "i" |
| Jus Kuning | `#E1C819` | 225, 200, 25 | Huruf "c", "e" |
| Jus Hijau Tua | `#96C84B` | 150, 200, 75 | Huruf "K" |
| Jus Biru | `#194B96` | 25, 75, 150 | Huruf "i", "d" |
| Jus Ungu | `#7D4B96` | 125, 75, 150 | Huruf "d", "i" |
| Jus Pink | `#E14B7D` | 225, 75, 125 | Huruf "n" |
| Jus Hijau Muda | `#AFC84B` | 175, 200, 75 | Huruf "g" |

### 2.2 Warna Peran (Functional Colors)

Dipilih dari palette rainbow di atas untuk peran UI yang spesifik:

| Peran | Hex | Sumber | Dipakai Di |
|-------|-----|--------|-----------|
| **Primary** | `#E17D19` | Oranye logo | CTA button, ikon aktif, harga, badge |
| **Primary Light** | `#FDF3E7` | Turunan oranye | Background chip aktif, hover ringan |
| **Primary Dark** | `#C45E0A` | Oranye gelap | Hover button, pressed state |
| **Secondary** | `#96C84B` | Hijau logo | Status "Tersedia", sukses, konfirmasi |
| **Secondary Light** | `#EEF7D8` | Turunan hijau | Background badge hijau |
| **Accent Blue** | `#194B96` | Biru logo | Link, info badge, edit button |
| **Accent Purple** | `#7D4B96` | Ungu logo | Tag kategori, gradient aksen |
| **Accent Pink** | `#E14B7D` | Pink logo | Notif badge, promo tag |

### 2.3 Warna Netral

| Nama | Hex | Class Tailwind | Fungsi |
|------|-----|----------------|--------|
| Dark | `#1A1820` | `gray-900` | Sidebar admin, heading utama |
| Body | `#3D3A4A` | `gray-700` | Teks body, label form |
| Muted | `#9B97A8` | `gray-400` | Placeholder, caption, breadcrumb |
| Border | `#E8E6F0` | `gray-200` | Garis pembatas, border card |
| Surface | `#F8F7FC` | `gray-50` | Background halaman |
| White | `#FFFFFF` | `white` | Card, modal, input |

### 2.4 Warna Status

| Status | Hex | Nama | Dipakai |
|--------|-----|------|---------|
| Sukses | `#96C84B` | Hijau Jus | Selesai, Tersedia, konfirmasi ✓ |
| Peringatan | `#E1C819` | Kuning Jus | Diproses, menunggu |
| Error | `#E11919` | Merah Jus | Dibatalkan, stok habis, error form |
| Info | `#194B96` | Biru Jus | Informasi, pengiriman |

### 2.5 Konfigurasi `tailwind.config.js`

```js
// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // Primary — Oranye Jus (dari logo)
        primary: {
          DEFAULT: '#E17D19',
          light:   '#FDF3E7',
          dark:    '#C45E0A',
        },
        // Secondary — Hijau Jus (dari logo)
        secondary: {
          DEFAULT: '#96C84B',
          light:   '#EEF7D8',
          dark:    '#6E9A2A',
        },
        // Accent colors dari pelangi logo
        accent: {
          red:    '#E11919',
          yellow: '#E1C819',
          blue:   '#194B96',
          purple: '#7D4B96',
          pink:   '#E14B7D',
          green:  '#AFC84B',
        },
        // Brand dark (sidebar admin)
        brand: {
          dark: '#1A1820',
        },
      },
      fontFamily: {
        sans: ['Nunito', 'Poppins', 'ui-sans-serif', 'system-ui'],
        // Nunito lebih cocok karena rounded seperti logo
      },
      borderRadius: {
        '2xl': '1rem',
        '3xl': '1.5rem',
        '4xl': '2rem',
      },
      boxShadow: {
        'card':     '0 2px 16px 0 rgba(0,0,0,0.07)',
        'card-lg':  '0 8px 32px 0 rgba(0,0,0,0.10)',
        'nav':      '0 -2px 16px 0 rgba(0,0,0,0.08)',
        'btn':      '0 4px 16px 0 rgba(225,125,25,0.35)',
        'btn-green':'0 4px 16px 0 rgba(150,200,75,0.35)',
      },
    },
  },
  plugins: [],
}
```

### 2.6 Inline Tailwind Config (untuk CDN / prototyping cepat)

```html
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary:   { DEFAULT: '#E17D19', light: '#FDF3E7', dark: '#C45E0A' },
        secondary: { DEFAULT: '#96C84B', light: '#EEF7D8', dark: '#6E9A2A' },
        accent: {
          red: '#E11919', yellow: '#E1C819',
          blue: '#194B96', purple: '#7D4B96',
          pink: '#E14B7D', green: '#AFC84B',
        },
        brand: { dark: '#1A1820' },
      },
      fontFamily: { sans: ['Nunito', 'Poppins', 'sans-serif'] },
      boxShadow: {
        card: '0 2px 16px 0 rgba(0,0,0,0.07)',
        btn:  '0 4px 16px 0 rgba(225,125,25,0.35)',
        nav:  '0 -2px 16px 0 rgba(0,0,0,0.08)',
      },
    }
  }
}
</script>
```

---

## 3. TIPOGRAFI

Logo menggunakan font **rounded & playful** — pilihan terbaik yang cocok dengan karakter ini:

**Font Utama: [Nunito](https://fonts.google.com/specimen/Nunito)** — rounded, friendly, mudah dibaca
**Font Fallback: [Poppins](https://fonts.google.com/specimen/Poppins)** — jika Nunito tidak tersedia

```html
<!-- Tambahkan di <head> semua layout -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
```

### Skala Tipografi

| Peran | Size | Weight | Class Tailwind | Contoh |
|-------|------|--------|----------------|--------|
| Display / Hero | 36–48px | 900 | `text-4xl font-black` | Headline landing page |
| H1 | 24px | 800 | `text-2xl font-extrabold` | Judul halaman |
| H2 | 20px | 700 | `text-xl font-bold` | Judul section |
| H3 | 16px | 700 | `text-base font-bold` | Judul card |
| Body | 14px | 500 | `text-sm font-medium` | Teks isi |
| Body Small | 12px | 400 | `text-xs font-normal` | Caption, meta |
| Label / Badge | 11px | 700 | `text-[11px] font-bold` | Badge, chip, tag |
| Price | 20px | 800 | `text-xl font-extrabold text-primary` | Harga produk |

### Aturan Tipografi

- **Heading:** selalu `font-bold` ke atas, warna `text-gray-900`
- **Body:** `font-medium` (Nunito 500 lebih mudah dibaca dari 400)
- **Muted:** `text-gray-400 font-normal`
- **Harga:** `text-primary font-extrabold` — warna oranye logo
- **Line height:** `leading-relaxed` untuk body, `leading-tight` untuk heading display
- **Jangan** pakai font weight 300 (terlalu tipis untuk brand yang fun & bold)

---

## 4. PENGGUNAAN LOGO & nama brand

### 4.1 File Tersedia (Tanpa Background)

```
/public/images/nama_brand.png      ← Logo teks "Juice Kidding" (PNG transparan)
/public/images/logo_maskot.png    ← Maskot boks jus pelangi (PNG transparan)
```

### 4.2 Panduan Penggunaan Logo

```html
<!-- Navbar / Header — versi horizontal -->
<img src="{{ asset('images/logo.png') }}"
     alt="Juice Kidding"
     class="h-8 w-auto object-contain">

<!-- Splash Screen — versi besar -->
<img src="{{ asset('images/logo.png') }}"
     alt="Juice Kidding"
     class="h-16 w-auto object-contain">

<!-- Admin Sidebar — versi putih (CSS filter) -->
<img src="{{ asset('images/nama_brand.png') }}"
     alt="Juice Kidding"
     class="h-7 w-auto brightness-0 invert opacity-90">
```

### 4.3 Panduan Penggunaan Maskot

```html
<!-- Splash Screen — maskot besar di tengah -->
<img src="{{ asset('images/logo_maskot.png') }}"
     alt="Maskot Juice Kidding"
     class="w-48 h-48 object-contain mx-auto
            animate-bounce-slow">

<!-- Empty State — ukuran sedang -->
<img src="{{ asset('images/logo_maskot.png') }}"
     alt=""
     class="w-32 h-32 object-contain mx-auto opacity-60">

<!-- Onboarding slide decoration — pojok -->
<img src="{{ asset('images/logo_maskot.png') }}"
     alt=""
     class="w-40 h-40 object-contain absolute -right-4 -bottom-4
            opacity-20 pointer-events-none">
```

### 4.4 Area Eksklusif Maskot (Pakai Hemat)

Maskot hanya tampil di: Splash Screen, Onboarding (maks. 1x), Empty State keranjang kosong, Halaman konfirmasi pesanan sukses. **Jangan** taruh maskot di setiap halaman — kesan spesialnya akan hilang.

---

## 5. ELEMEN DEKORATIF RAINBOW

Terinspirasi dari garis pelangi di maskot dan gradasi teks logo:

### 5.1 Rainbow Gradient Bar

```html
<!-- Bar pelangi tipis sebagai aksen dekoratif -->
<div class="h-1 w-full rounded-full"
     style="background: linear-gradient(90deg,
       #E11919 0%, #E17D19 17%, #E1C819 33%,
       #96C84B 50%, #194B96 67%, #7D4B96 83%, #E14B7D 100%);">
</div>
```

Gunakan di: bawah navbar, atas card hero, divider section landing page.

### 5.2 Rainbow Text (Judul Hero)

```html
<span class="font-black text-4xl"
      style="background: linear-gradient(90deg,
        #E11919, #E17D19, #E1C819, #96C84B, #194B96, #7D4B96);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;">
  Segar & Colorful!
</span>
```

### 5.3 Rainbow Dot Indicators

```html
<!-- Gunakan sebagai bullet point atau step indicator -->
<div class="flex gap-1.5">
  <span class="w-2 h-2 rounded-full bg-accent-red"></span>
  <span class="w-2 h-2 rounded-full bg-primary"></span>
  <span class="w-2 h-2 rounded-full bg-accent-yellow"></span>
  <span class="w-2 h-2 rounded-full bg-secondary"></span>
  <span class="w-2 h-2 rounded-full bg-accent-blue"></span>
  <span class="w-2 h-2 rounded-full bg-accent-purple"></span>
</div>
```

### 5.4 Batasan Dekoratif Rainbow

- Gunakan **maksimal 1 elemen rainbow per halaman** (bar / text / dots — pilih satu)
- Jangan buat seluruh halaman rainbow — akan terlalu ramai
- Background tetap putih/abu muda, rainbow hanya sebagai aksen kecil

---

## 6. SPACING & LAYOUT

### Grid System

```
Mobile (< 640px):   1–2 kolom, px-4
Tablet (640–1024px): 2–3 kolom, px-6
Desktop (> 1024px):  3–4 kolom, px-8
```

### Layout Utama per Platform

**Mobile Customer & Mitra:**
```html
<div class="max-w-sm mx-auto min-h-screen bg-gray-50 relative flex flex-col shadow-2xl">
```

**Admin Desktop:**
```
flex h-screen
├── sidebar: w-64 fixed bg-brand-dark
└── main: ml-64 flex-1 overflow-y-auto bg-gray-50
    ├── topbar: sticky h-16 bg-white shadow-sm
    └── content: px-8 py-6
```

---

## 7. KOMPONEN UI

### 7.1 Button

**Primary — Oranye Jus**
```html
<button class="w-full bg-primary hover:bg-primary-dark active:scale-95
               text-white font-bold text-sm
               py-3 px-6 rounded-full shadow-btn
               transition-all duration-150">
  Pesan Sekarang
</button>
```

**Secondary — Hijau Jus**
```html
<button class="w-full bg-secondary hover:bg-secondary-dark active:scale-95
               text-white font-bold text-sm
               py-3 px-6 rounded-full shadow-btn-green
               transition-all duration-150">
  Konfirmasi Pesanan
</button>
```

**Outline — Border Oranye**
```html
<button class="w-full border-2 border-primary text-primary
               hover:bg-primary-light font-bold text-sm
               py-3 px-6 rounded-full transition-all duration-150">
  Lihat Menu
</button>
```

**Danger — Merah Jus**
```html
<button class="bg-accent-red hover:opacity-90 text-white
               font-bold text-sm py-2.5 px-5 rounded-xl
               transition-all duration-150 active:scale-95">
  Hapus
</button>
```

**Icon Button — Add to Cart**
```html
<button class="w-8 h-8 rounded-full bg-primary text-white
               flex items-center justify-center flex-shrink-0
               hover:bg-primary-dark active:scale-90 shadow-btn
               transition-all duration-150">
  <i data-lucide="plus" class="w-4 h-4"></i>
</button>
```

---

### 7.2 Card Produk (Mobile, 2 Kolom)

```html
<div class="bg-white rounded-2xl shadow-card overflow-hidden
            hover:shadow-card-lg transition-shadow duration-200">
  <!-- Thumbnail -->
  <div class="relative">
    <img src="https://picsum.photos/seed/jus1/200/140"
         class="w-full h-32 object-cover" alt="Jus Alpukat">
    <!-- Badge habis -->
    {{-- @if(!$produk->tersedia) --}}
    <div class="absolute inset-0 bg-gray-900/60 flex items-center justify-center rounded-t-2xl">
      <span class="text-white text-xs font-bold bg-gray-700 px-2.5 py-1 rounded-full">
        Habis
      </span>
    </div>
    {{-- @endif --}}
  </div>
  <!-- Info -->
  <div class="p-3">
    <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-1">
      Jus Alpukat Susu
    </h3>
    <div class="flex items-center justify-between mt-2">
      <span class="text-primary font-extrabold text-base">Rp 18.000</span>
      <button class="w-7 h-7 rounded-full bg-primary text-white
                     flex items-center justify-center shadow-btn
                     hover:bg-primary-dark active:scale-90 transition-all">
        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
      </button>
    </div>
  </div>
</div>
```

---

### 7.3 Badge & Status

```html
<!-- Selesai — Hijau Jus -->
<span class="inline-flex items-center gap-1 text-[11px] font-bold
             text-secondary-dark bg-secondary-light px-2.5 py-1 rounded-full">
  ● Selesai
</span>

<!-- Diproses — Kuning Jus -->
<span class="inline-flex items-center gap-1 text-[11px] font-bold
             text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">
  ● Diproses
</span>

<!-- Dibatalkan — Merah Jus -->
<span class="inline-flex items-center gap-1 text-[11px] font-bold
             text-accent-red bg-red-100 px-2.5 py-1 rounded-full">
  ● Dibatalkan
</span>

<!-- Baru — Biru Jus -->
<span class="inline-flex items-center gap-1 text-[11px] font-bold
             text-accent-blue bg-blue-100 px-2.5 py-1 rounded-full">
  ● Pesanan Baru
</span>

<!-- Habis — Abu -->
<span class="inline-flex items-center gap-1 text-[11px] font-bold
             text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
  ● Habis
</span>
```

**Chip Kategori:**
```html
<!-- Tidak aktif -->
<button class="text-sm font-semibold text-gray-500 bg-white
               border-2 border-gray-200 px-4 py-1.5 rounded-full
               hover:border-primary hover:text-primary transition-all">
  Jus Buah
</button>

<!-- Aktif -->
<button class="text-sm font-bold text-white bg-primary
               px-4 py-1.5 rounded-full shadow-btn">
  Semua
</button>
```

---

### 7.4 Form Input

```html
<!-- Input standar -->
<div class="mb-4">
  <label class="block text-xs font-bold text-gray-700 mb-1.5 tracking-wide">
    Email
  </label>
  <input type="email" placeholder="contoh@email.com"
    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3
           text-sm font-medium text-gray-900 placeholder-gray-300
           focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/15
           transition-all bg-white">
</div>

<!-- Error state -->
<input class="... border-accent-red focus:border-accent-red focus:ring-red-100">
<p class="text-xs font-semibold text-accent-red mt-1.5 flex items-center gap-1">
  <i data-lucide="alert-circle" class="w-3 h-3"></i>
  Email tidak valid.
</p>
```

**Toggle Switch:**
```html
<label class="relative inline-flex items-center cursor-pointer gap-3">
  <input type="checkbox" class="sr-only peer" checked>
  <div class="w-12 h-6 bg-gray-200 rounded-full
              peer-checked:bg-secondary
              relative transition-colors duration-200
              after:content-[''] after:absolute after:top-0.5 after:left-0.5
              after:bg-white after:rounded-full after:h-5 after:w-5
              after:shadow-sm after:transition-transform duration-200
              peer-checked:after:translate-x-6">
  </div>
  <span class="text-sm font-bold text-gray-700 peer-checked:text-secondary-dark">
    Tersedia
  </span>
</label>
```

---

### 7.5 Bottom Navigation Bar (Mobile)

```html
<nav class="fixed bottom-0 left-0 right-0 max-w-sm mx-auto
            bg-white border-t-2 border-gray-100 shadow-nav
            flex items-center justify-around h-16 z-50 px-2">

  <!-- Aktif -->
  <a href="#" class="flex flex-col items-center gap-0.5 min-w-[56px]">
    <div class="w-8 h-8 rounded-xl bg-primary-light flex items-center justify-center">
      <i data-lucide="home" class="w-4 h-4 text-primary"></i>
    </div>
    <span class="text-[10px] font-bold text-primary">Beranda</span>
  </a>

  <!-- Tidak aktif -->
  <a href="#" class="flex flex-col items-center gap-0.5 min-w-[56px]">
    <div class="w-8 h-8 rounded-xl flex items-center justify-center">
      <i data-lucide="grid" class="w-4 h-4 text-gray-400"></i>
    </div>
    <span class="text-[10px] font-semibold text-gray-400">Menu</span>
  </a>

  <!-- Dengan badge notif -->
  <a href="#" class="flex flex-col items-center gap-0.5 min-w-[56px] relative">
    <div class="w-8 h-8 rounded-xl flex items-center justify-center relative">
      <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400"></i>
      <span class="absolute -top-1 -right-1 w-4 h-4 bg-accent-red text-white
                   text-[9px] font-black rounded-full flex items-center justify-center">3</span>
    </div>
    <span class="text-[10px] font-semibold text-gray-400">Pesanan</span>
  </a>

  <a href="#" class="flex flex-col items-center gap-0.5 min-w-[56px]">
    <div class="w-8 h-8 rounded-xl flex items-center justify-center">
      <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
    </div>
    <span class="text-[10px] font-semibold text-gray-400">Profil</span>
  </a>
</nav>
```

---

### 7.6 Header Mobile

```html
<header class="sticky top-0 z-40 bg-white border-b-2 border-gray-100 px-4 h-14
               flex items-center justify-between">
  <!-- Logo -->
  <img src="{{ asset('images/logo.png') }}"
       alt="Juice Kidding" class="h-7 w-auto object-contain">
  <!-- Actions -->
  <div class="flex items-center gap-3">
    <button class="relative w-8 h-8 flex items-center justify-center">
      <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
      <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-accent-pink
                   rounded-full border-2 border-white"></span>
    </button>
    <button class="relative w-8 h-8 flex items-center justify-center">
      <i data-lucide="shopping-cart" class="w-5 h-5 text-gray-500"></i>
      <span class="absolute -top-1 -right-1 w-4.5 h-4.5 bg-primary text-white
                   text-[9px] font-black rounded-full flex items-center justify-center
                   min-w-[18px] px-1">2</span>
    </button>
  </div>
</header>
```

---

### 7.7 Sidebar Admin (Desktop)

```html
<aside class="w-64 min-h-screen bg-brand-dark flex flex-col fixed left-0 top-0 z-40">
  <!-- Logo -->
  <div class="px-6 py-5 border-b border-white/10">
    <img src="{{ asset('images/logo.png') }}"
         alt="Juice Kidding"
         class="h-7 w-auto brightness-0 invert opacity-90">
    <span class="block text-white/30 text-[10px] font-bold tracking-widest uppercase mt-1">
      Admin Panel
    </span>
    <!-- Rainbow bar kecil -->
    <div class="h-0.5 w-full mt-3 rounded-full"
         style="background:linear-gradient(90deg,#E11919,#E17D19,#E1C819,#96C84B,#194B96,#7D4B96)">
    </div>
  </div>

  <!-- Nav Menu -->
  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

    <!-- Aktif -->
    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       bg-primary text-white font-bold text-sm
                       shadow-btn transition-all">
      <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
      Dashboard
    </a>

    <!-- Tidak aktif -->
    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       text-white/50 hover:text-white hover:bg-white/10
                       font-semibold text-sm transition-all">
      <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0"></i>
      Kelola Artikel
    </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       text-white/50 hover:text-white hover:bg-white/10
                       font-semibold text-sm transition-all">
      <i data-lucide="package" class="w-4 h-4 flex-shrink-0"></i>
      Kelola Produk
    </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       text-white/50 hover:text-white hover:bg-white/10
                       font-semibold text-sm transition-all">
      <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
      Kelola Pengguna
    </a>

    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl
                       text-white/50 hover:text-white hover:bg-white/10
                       font-semibold text-sm transition-all">
      <i data-lucide="receipt" class="w-4 h-4 flex-shrink-0"></i>
      Kelola Transaksi
    </a>

  </nav>

  <!-- User info -->
  <div class="px-4 py-4 border-t border-white/10">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center
                  text-white font-black text-sm flex-shrink-0">A</div>
      <div class="min-w-0">
        <p class="text-white text-xs font-bold truncate">Admin JK</p>
        <p class="text-white/30 text-[10px] truncate">admin@juicekidding.id</p>
      </div>
      <button class="ml-auto text-white/30 hover:text-accent-red transition-all flex-shrink-0">
        <i data-lucide="log-out" class="w-4 h-4"></i>
      </button>
    </div>
  </div>
</aside>
```

---

### 7.8 Kartu Statistik Admin

```html
<!-- Grid 4 kartu -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

  <!-- Kartu 1: Oranye -->
  <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-primary">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pesanan Hari Ini</p>
        <p class="text-3xl font-black text-gray-900 mt-1">142</p>
        <p class="text-xs font-semibold text-secondary mt-1">▲ 12% dari kemarin</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-primary-light flex items-center justify-center">
        <i data-lucide="shopping-bag" class="w-5 h-5 text-primary"></i>
      </div>
    </div>
  </div>

  <!-- Kartu 2: Hijau -->
  <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-secondary">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pendapatan</p>
        <p class="text-3xl font-black text-gray-900 mt-1">2,4jt</p>
        <p class="text-xs font-semibold text-secondary mt-1">▲ 8% dari kemarin</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-secondary-light flex items-center justify-center">
        <i data-lucide="trending-up" class="w-5 h-5 text-secondary-dark"></i>
      </div>
    </div>
  </div>

  <!-- Kartu 3: Biru -->
  <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-accent-blue">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pick-up</p>
        <p class="text-3xl font-black text-gray-900 mt-1">89</p>
        <p class="text-xs font-semibold text-gray-400 mt-1">→ Sama seperti kemarin</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center">
        <i data-lucide="store" class="w-5 h-5 text-accent-blue"></i>
      </div>
    </div>
  </div>

  <!-- Kartu 4: Ungu -->
  <div class="bg-white rounded-2xl shadow-card p-5 border-l-4 border-accent-purple">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Delivery</p>
        <p class="text-3xl font-black text-gray-900 mt-1">53</p>
        <p class="text-xs font-semibold text-secondary mt-1">▲ 5% dari kemarin</p>
      </div>
      <div class="w-11 h-11 rounded-2xl bg-purple-50 flex items-center justify-center">
        <i data-lucide="truck" class="w-5 h-5 text-accent-purple"></i>
      </div>
    </div>
  </div>

</div>
```

---

### 7.9 Modal Konfirmasi

```html
<div id="modal-hapus" class="fixed inset-0 z-50 flex items-center justify-center
                              bg-black/50 backdrop-blur-sm px-4 hidden">
  <div class="bg-white rounded-3xl shadow-card-lg w-full max-w-sm p-6">
    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto">
      <i data-lucide="trash-2" class="w-7 h-7 text-accent-red"></i>
    </div>
    <h3 class="text-lg font-black text-gray-900 text-center mt-4">Hapus Produk?</h3>
    <p class="text-sm font-medium text-gray-500 text-center mt-2 leading-relaxed">
      Tindakan ini tidak dapat dibatalkan.<br>Produk akan dihapus secara permanen.
    </p>
    <div class="flex gap-3 mt-6">
      <button onclick="document.getElementById('modal-hapus').classList.add('hidden')"
        class="flex-1 border-2 border-gray-200 text-gray-700 font-bold
               py-3 rounded-2xl hover:bg-gray-50 text-sm transition-all">
        Batal
      </button>
      <button class="flex-1 bg-accent-red hover:opacity-90 text-white font-bold
                     py-3 rounded-2xl text-sm transition-all active:scale-95">
        Hapus
      </button>
    </div>
  </div>
</div>
```

---

### 7.10 Toast Notifikasi

```html
<div id="toast"
     class="fixed top-4 left-1/2 -translate-x-1/2 z-[60]
            bg-brand-dark text-white text-sm font-bold
            px-5 py-3 rounded-2xl shadow-card-lg
            flex items-center gap-2.5 min-w-max
            opacity-0 -translate-y-16 transition-all duration-300 ease-out"
     aria-live="polite">
  <span class="text-base">🔔</span>
  <span id="toast-msg">Pesanan Baru Masuk!</span>
  <!-- Rainbow underline -->
  <div class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full"
       style="background:linear-gradient(90deg,#E11919,#E17D19,#96C84B,#194B96,#7D4B96)">
  </div>
</div>

<script>
function showToast(msg, emoji = '🔔', duration = 3500) {
  const t = document.getElementById('toast');
  const m = document.getElementById('toast-msg');
  m.textContent = msg;
  t.querySelector('span:first-child').textContent = emoji;
  t.classList.remove('opacity-0', '-translate-y-16');
  t.classList.add('opacity-100', 'translate-y-0');
  setTimeout(() => {
    t.classList.add('opacity-0', '-translate-y-16');
    t.classList.remove('opacity-100', 'translate-y-0');
  }, duration);
}
// Contoh: showToast('Pesanan Baru Masuk!', '🔔')
//         showToast('Stok diperbarui!', '✅')
</script>
```

---

### 7.11 Progress Tracker Pesanan

```html
<div class="space-y-0 px-2">

  <!-- Step Selesai (hijau) -->
  <div class="flex gap-4 items-start">
    <div class="flex flex-col items-center flex-shrink-0">
      <div class="w-9 h-9 rounded-full bg-secondary flex items-center justify-center shadow-btn-green">
        <i data-lucide="check" class="w-4 h-4 text-white"></i>
      </div>
      <div class="w-0.5 h-10 bg-secondary mt-1"></div>
    </div>
    <div class="pt-1.5 pb-6">
      <p class="text-sm font-bold text-gray-900">Pesanan Dikonfirmasi</p>
      <p class="text-xs font-medium text-gray-400 mt-0.5">13:45 · Pesanan diterima sistem</p>
    </div>
  </div>

  <!-- Step Aktif (oranye, animasi) -->
  <div class="flex gap-4 items-start">
    <div class="flex flex-col items-center flex-shrink-0">
      <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center shadow-btn
                  ring-4 ring-primary/20 animate-pulse">
        <i data-lucide="chef-hat" class="w-4 h-4 text-white"></i>
      </div>
      <div class="w-0.5 h-10 bg-gray-200 mt-1"></div>
    </div>
    <div class="pt-1.5 pb-6">
      <p class="text-sm font-black text-primary">Sedang Disiapkan</p>
      <p class="text-xs font-medium text-gray-400 mt-0.5">Estimasi siap pukul 14:10</p>
    </div>
  </div>

  <!-- Step Belum (abu) -->
  <div class="flex gap-4 items-start">
    <div class="flex flex-col items-center flex-shrink-0">
      <div class="w-9 h-9 rounded-full bg-gray-100 border-2 border-dashed border-gray-300
                  flex items-center justify-center">
        <i data-lucide="truck" class="w-4 h-4 text-gray-300"></i>
      </div>
      <div class="w-0.5 h-10 bg-gray-200 mt-1"></div>
    </div>
    <div class="pt-1.5 pb-6">
      <p class="text-sm font-semibold text-gray-300">Sedang Diantar</p>
    </div>
  </div>

  <!-- Step Belum Terakhir -->
  <div class="flex gap-4 items-start">
    <div class="flex-shrink-0">
      <div class="w-9 h-9 rounded-full bg-gray-100 border-2 border-dashed border-gray-300
                  flex items-center justify-center">
        <i data-lucide="smile" class="w-4 h-4 text-gray-300"></i>
      </div>
    </div>
    <div class="pt-1.5">
      <p class="text-sm font-semibold text-gray-300">Selesai</p>
    </div>
  </div>

</div>
```

---

### 7.12 Tabel Admin

```html
<div class="bg-white rounded-2xl shadow-card overflow-hidden">
  <!-- Header tabel -->
  <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
    <h3 class="font-black text-gray-900">Daftar Produk</h3>
    <button class="bg-primary hover:bg-primary-dark text-white text-sm font-bold
                   px-4 py-2 rounded-xl shadow-btn transition-all active:scale-95">
      + Tambah Produk
    </button>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Produk</th>
          <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Kategori</th>
          <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Harga</th>
          <th class="text-left px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
          <th class="text-right px-6 py-3 text-[11px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        <tr class="hover:bg-gray-50/60 transition-colors">
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              <img src="https://picsum.photos/seed/jus1/40" class="w-10 h-10 rounded-xl object-cover" alt="">
              <span class="font-bold text-gray-900">Jus Alpukat Susu</span>
            </div>
          </td>
          <td class="px-6 py-4 text-gray-500 font-medium">Jus Buah</td>
          <td class="px-6 py-4 font-extrabold text-primary">Rp 18.000</td>
          <td class="px-6 py-4">
            <span class="text-[11px] font-bold text-secondary-dark bg-secondary-light px-2.5 py-1 rounded-full">
              Tersedia
            </span>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-1.5">
              <button class="p-2 rounded-xl hover:bg-blue-50 text-accent-blue transition-all">
                <i data-lucide="pencil" class="w-4 h-4"></i>
              </button>
              <button class="p-2 rounded-xl hover:bg-red-50 text-accent-red transition-all">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
```

---

## 8. ANIMASI

```css
/* resources/css/app.css — tambahkan di bawah @tailwind base/components/utilities */

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up { animation: fadeInUp 0.35s ease-out forwards; }

@keyframes scaleIn {
  from { transform: scale(0.7); opacity: 0; }
  to   { transform: scale(1);   opacity: 1; }
}
.animate-scale-in { animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }

@keyframes bounceSlow {
  0%, 100% { transform: translateY(0); }
  50%       { transform: translateY(-8px); }
}
.animate-bounce-slow { animation: bounceSlow 2.5s ease-in-out infinite; }

@keyframes rainbowSlide {
  0%   { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
.animate-rainbow {
  background: linear-gradient(90deg, #E11919, #E17D19, #E1C819, #96C84B, #194B96, #7D4B96, #E14B7D, #E11919);
  background-size: 200% auto;
  animation: rainbowSlide 4s linear infinite;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
```

| Situasi | Class | Durasi |
|---------|-------|--------|
| Masuk halaman | `animate-fade-in-up` | 350ms |
| Modal muncul | `animate-scale-in` | 400ms |
| Maskot splash | `animate-bounce-slow` | loop |
| Centang sukses | `animate-scale-in` | 400ms |
| Teks rainbow hero | `animate-rainbow` | loop |
| Button diklik | `active:scale-95` | 150ms |
| Step aktif tracking | `animate-pulse` | loop |

---

## 9. TEMPLATE BLADE

### Layout Customer Mobile (`layouts/app.blade.php`)

```html
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>@yield('title', 'Juice Kidding')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          primary:   { DEFAULT: '#E17D19', light: '#FDF3E7', dark: '#C45E0A' },
          secondary: { DEFAULT: '#96C84B', light: '#EEF7D8', dark: '#6E9A2A' },
          accent: { red:'#E11919', yellow:'#E1C819', blue:'#194B96', purple:'#7D4B96', pink:'#E14B7D', green:'#AFC84B' },
          brand: { dark: '#1A1820' },
        },
        fontFamily: { sans: ['Nunito','sans-serif'] },
        boxShadow: { card:'0 2px 16px 0 rgba(0,0,0,0.07)', btn:'0 4px 16px 0 rgba(225,125,25,0.35)', nav:'0 -2px 16px 0 rgba(0,0,0,0.08)' },
        borderRadius: { '2xl':'1rem','3xl':'1.5rem','4xl':'2rem' },
      }}
    }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  @yield('head')
</head>
<body class="bg-gray-100 font-sans antialiased">
  <div class="max-w-sm mx-auto min-h-screen bg-white relative flex flex-col shadow-2xl overflow-hidden">
    @yield('header')
    <main class="flex-1 overflow-y-auto @yield('main-class','pb-20')">
      @yield('content')
    </main>
    @yield('bottom-nav')
  </div>
  <script>lucide.createIcons();</script>
  @yield('scripts')
</body>
</html>
```

### Layout Admin Desktop (`layouts/admin.blade.php`)

```html
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Admin') — Juice Kidding</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>/* tailwind config sama seperti customer layout */</script>
  <script src="https://unpkg.com/lucide@latest"></script>
  @yield('head')
</head>
<body class="bg-gray-50 font-sans antialiased">
  <div class="flex h-screen overflow-hidden">
    @include('admin.partials.sidebar')
    <div class="flex-1 ml-64 flex flex-col overflow-hidden">
      <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30">
        <div>
          <h1 class="text-lg font-black text-gray-900">@yield('page-title','Dashboard')</h1>
        </div>
        <div class="flex items-center gap-3">
          <button class="relative"><i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-accent-red rounded-full"></span>
          </button>
          <div class="w-9 h-9 rounded-full bg-primary text-white font-black text-sm flex items-center justify-center shadow-btn">A</div>
        </div>
      </header>
      <main class="flex-1 overflow-y-auto px-8 py-6">
        @yield('content')
      </main>
    </div>
  </div>
  <script>lucide.createIcons();</script>
  @yield('scripts')
</body>
</html>
```

---

## 10. CHECKLIST KONSISTENSI DESAIN

**Brand & Warna:**
- [ ] Font Nunito terpasang di semua layout
- [ ] Primary `#E17D19` dipakai konsisten sebagai warna CTA utama
- [ ] Rainbow gradient bar muncul maksimal 1x per halaman sebagai aksen
- [ ] Warna status (hijau/kuning/merah/biru) konsisten di semua badge

**Komponen:**
- [ ] Semua CTA button utama menggunakan `rounded-full`
- [ ] Semua card menggunakan `rounded-2xl shadow-card`
- [ ] Semua input menggunakan `border-2 border-gray-200 rounded-2xl focus:border-primary`
- [ ] `lucide.createIcons()` dipanggil sebelum `</body>` di semua layout
- [ ] Logo PNG transparan sudah di `/public/images/logo_maskot.png`
- [ ] Nama brand PNG transparan sudah di `/public/images/nama_brand.png`

**Layout:**
- [ ] Mobile: wrapper `max-w-sm mx-auto` + `pb-20` untuk ruang bottom nav
- [ ] Admin: sidebar `w-64 fixed` + main content `ml-64`
- [ ] Landing page responsive dari mobile ke desktop

**UX:**
- [ ] Empty state memakai maskot + pesan + tombol CTA
- [ ] Semua form memiliki error state (border merah + pesan teks)
- [ ] Semua button punya `hover:` dan `active:scale-95`
- [ ] Modal konfirmasi sebelum hapus/batalkan
- [ ] Tombol submit punya loading state (disabled + teks berubah)

**Aksesibilitas:**
- [ ] Semua `<img>` punya `alt` text
- [ ] Semua `<input>` punya `<label>` terpasang
- [ ] Ukuran tap area minimum `min-h-[44px]` untuk mobile
- [ ] Kontras teks memenuhi WCAG AA (tidak abu muda di atas putih)
