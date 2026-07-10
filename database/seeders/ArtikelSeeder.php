<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori Artikel
        $kategori_kesehatan = DB::table('kategori_artikel')->insertGetId(['nama_kategori' => 'Kesehatan']);
        $kategori_resep = DB::table('kategori_artikel')->insertGetId(['nama_kategori' => 'Resep Jus']);
        $kategori_diet = DB::table('kategori_artikel')->insertGetId(['nama_kategori' => 'Diet & Fitness']);

        // 2. Cek apakah ada user admin/penulis (fallback ke id 1)
        $penulis = DB::table('users')->where('role_id', 1)->first();
        $id_penulis = $penulis ? $penulis->id_user : (DB::table('users')->first()->id_user ?? 1);

        // 3. Buat Artikel
        $artikels = [
            [
                'id_kategori_artikel' => $kategori_kesehatan,
                'id_penulis' => $id_penulis,
                'judul' => '3 Alasan Mengapa Kamu Harus Detox Gula Mulai Hari Ini',
                'slug' => Str::slug('3 Alasan Mengapa Kamu Harus Detox Gula Mulai Hari Ini'),
                'thumbnail' => null,
                'ringkasan' => 'Gula berlebih tidak hanya menyebabkan kenaikan berat badan, tetapi juga memicu peradangan pada tubuh. Cari tahu alasan mengapa kamu perlu detox gula sekarang.',
                'konten' => '
                    <p>Konsumsi gula berlebih telah terbukti menjadi salah satu penyebab utama berbagai penyakit kronis masa kini. Mulai dari obesitas, diabetes tipe 2, hingga penyakit jantung.</p>
                    <h2>1. Menurunkan Risiko Peradangan Tubuh</h2>
                    <p>Gula olahan dapat memicu produksi sitokin, molekul inflamasi dalam tubuh. Dengan mengurangi asupan gula, kamu dapat menekan tingkat peradangan yang berdampak pada nyeri sendi dan kelelahan kronis.</p>
                    <h2>2. Kulit Lebih Bersih dan Awet Muda</h2>
                    <p>Proses glikasi yang disebabkan oleh gula dapat merusak kolagen dan elastin, dua protein penting yang menjaga kulit tetap kencang dan kenyal. Detox gula adalah kunci kulit <em>glowing</em> alami.</p>
                    <h2>3. Energi Lebih Stabil Sepanjang Hari</h2>
                    <p>Pernah merasa <em>sugar crash</em>? Ya, lonjakan gula darah yang cepat akan diikuti oleh penurunan drastis, membuatmu merasa lemas dan ngantuk. Mengganti gula dengan buah utuh memastikan energi lebih stabil.</p>
                    <blockquote>"Kesehatan adalah investasi terbaik. Kurangi gula, perbanyak nutrisi alami!"</blockquote>
                ',
                'id_status_artikel' => 1,
                'dilihat' => 125,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id_kategori_artikel' => $kategori_resep,
                'id_penulis' => $id_penulis,
                'judul' => 'Resep Cold-Pressed Juice: Green Ninja untuk Immune Booster',
                'slug' => Str::slug('Resep Cold-Pressed Juice: Green Ninja untuk Immune Booster'),
                'thumbnail' => null,
                'ringkasan' => 'Paduan bayam, apel hijau, seledri, dan jahe ini kaya akan antioksidan. Sangat cocok diminum di pagi hari untuk meningkatkan kekebalan tubuh.',
                'konten' => '
                    <p>Menjaga daya tahan tubuh sangat penting di tengah cuaca yang tak menentu. Salah satu cara termudah dan paling segar adalah dengan rutin meminum jus hijau kaya serat dan antioksidan.</p>
                    <h2>Bahan-bahan "Green Ninja":</h2>
                    <ul>
                        <li>2 genggam bayam segar (cuci bersih)</li>
                        <li>1 buah apel hijau malang (buang biji)</li>
                        <li>2 batang seledri besar</li>
                        <li>1 ruas ibu jari jahe segar</li>
                        <li>1/2 buah lemon (peras airnya saja)</li>
                    </ul>
                    <h2>Cara Membuat:</h2>
                    <ol>
                        <li>Potong-potong semua bahan agar mudah masuk ke dalam <em>juicer</em> atau <em>blender</em>.</li>
                        <li>Masukkan perlahan mulai dari bayam, seledri, apel, lalu jahe.</li>
                        <li>Jika menggunakan blender biasa, tambahkan sedikit air es. Jika menggunakan <em>cold-pressed juicer</em>, cukup sari aslinya saja.</li>
                        <li>Aduk rata dengan perasan air lemon.</li>
                        <li>Sajikan dingin dan langsung minum agar nutrisinya maksimal.</li>
                    </ol>
                    <p>Ramuan ini kaya akan Vitamin C dari lemon, zat besi dari bayam, dan sifat anti-inflamasi dari jahe. Selamat mencoba!</p>
                ',
                'id_status_artikel' => 1,
                'dilihat' => 84,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'id_kategori_artikel' => $kategori_diet,
                'id_penulis' => $id_penulis,
                'judul' => 'Mitos dan Fakta Seputar Kalori Jus Buah: Apakah Bikin Gemuk?',
                'slug' => Str::slug('Mitos dan Fakta Seputar Kalori Jus Buah: Apakah Bikin Gemuk?'),
                'thumbnail' => null,
                'ringkasan' => 'Banyak yang takut minum jus buah karena anggapan tinggi kalori dan gula. Padahal, jika dikonsumsi dengan benar, jus buah justru membantu program dietmu.',
                'konten' => '
                    <p>Seringkali jus buah dihindari oleh pejuang diet dengan alasan tinggi gula (fruktosa). Apakah benar jus buah bikin gemuk? Yuk kita bahas mitos dan faktanya!</p>
                    <h2>Mitos: Semua Jus Buah Tinggi Kalori</h2>
                    <p><strong>Fakta:</strong> Tergantung pada buah apa yang kamu campurkan. Memang benar mangga, pisang, dan alpukat memiliki kalori yang padat. Namun buah seperti semangka, jeruk nipis, beri-berian, dan apel hijau memiliki kalori yang relatif rendah dan tinggi kadar air.</p>
                    <h2>Mitos: Jus Sama Saja dengan Minuman Bersoda</h2>
                    <p><strong>Fakta:</strong> Sangat berbeda! Walaupun sama-sama memiliki gula, gula dalam minuman bersoda adalah pemanis buatan tanpa gizi. Sementara fruktosa pada jus buah asli hadir bersama dengan vitamin, mineral, enzim, dan fitonutrien yang sangat dibutuhkan tubuh.</p>
                    <h2>Tips Minum Jus Saat Diet:</h2>
                    <ul>
                        <li>Gunakan formula 80/20: 80% sayur dan 20% buah untuk menjaga asupan kalori dan gula tetap terkontrol.</li>
                        <li>Jangan tambahkan gula pasir, sirup kental manis, atau madu secara berlebihan.</li>
                        <li>Konsumsi beserta serat aslinya (bisa dicampur dengan chia seeds) untuk menunda rasa lapar.</li>
                    </ul>
                    <p>Jangan takut pada jus, tapi jadilah cerdas dalam memilih racikannya!</p>
                ',
                'id_status_artikel' => 1,
                'dilihat' => 205,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'id_kategori_artikel' => $kategori_kesehatan,
                'id_penulis' => $id_penulis,
                'judul' => 'Rahasia Enzim pada Cold-Pressed Juice',
                'slug' => Str::slug('Rahasia Enzim pada Cold-Pressed Juice'),
                'thumbnail' => null,
                'ringkasan' => 'Mengapa cold-pressed juice lebih mahal dari jus biasa? Temukan rahasia teknologi penekanan dingin yang menjaga struktur molekul nutrisi tetap utuh.',
                'konten' => '
                    <p>Banyak yang bertanya, kenapa harus pilih <em>cold-pressed</em>? Bedanya apa dengan jus blender biasa?</p>
                    <p>Jawabannya ada pada <strong>suhu dan oksidasi</strong>. Blender konvensional menggunakan pisau yang berputar sangat cepat. Putaran ini menghasilkan panas (suhu tinggi) dan memasukkan banyak udara ke dalam cairan (oksidasi).</p>
                    <p>Panas dan udara adalah musuh utama dari enzim dan vitamin tertentu, terutama Vitamin C, yang sangat mudah terurai.</p>
                    <h2>Teknologi Cold-Pressed</h2>
                    <p>Sesuai namanya, teknologi ini menggunakan mesin pres hidrolik bertekanan tinggi (tanpa panas) untuk mengekstraksi sari buah. Proses ini 100% mencegah kerusakan enzim dan nutrisi.</p>
                    <p>Hasilnya? Jus yang dihasilkan lebih kental, warnanya lebih cerah, rasanya lebih murni, dan kandungan nutrisinya bisa 3x lipat lebih kaya dibandingkan jus biasa.</p>
                ',
                'id_status_artikel' => 1,
                'dilihat' => 45,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ]
        ];

        DB::table('artikel')->insert($artikels);
    }
}
