<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $posts = $this->posts();
        $category = $request->query('category', 'semua');
        
        // Filter berdasarkan kategori
        if ($category !== 'semua') {
            $posts = array_filter($posts, function($post) use ($category) {
                return $post['category'] === $category;
            });
        }
        
        return view('frontend.pages.blogs.index', ['posts' => $posts, 'selectedCategory' => $category]);
    }

    public function show(int $id)
    {
        $posts = $this->posts();

        if (!isset($posts[$id])) {
            abort(404);
        }

        return view('frontend.pages.blogs.show', ['post' => $posts[$id], 'id' => $id]);
    }

    private function posts(): array
    {
        return [
            1 => [
                'id' => 1,
                'title' => 'Sejarah Keramik Kuno',
                'author' => 'Dr. Siti Nurhaliza',
                'date' => '15 Desember 2024',
                'category' => 'Sejarah',
                'image' => 'img/placeholder.png',
                'excerpt' => 'Pelajari tentang evolusi keramik dari zaman kuno hingga modern...',
                'content' => 'Keramik kuno merupakan salah satu dari sedikit bukti material yang telah bertahan hingga sekarang dari masa lalu umat manusia. Evolusi keramik dimulai dari yang paling sederhana pada zaman prasejarah dan berkembang menjadi bentuk yang lebih kompleks seiring dengan perkembangan peradaban.

Pada periode awal, keramik dibuat dengan tangan tanpa menggunakan roda putar. Desain yang sederhana dengan fungsi utama untuk penyimpanan makanan dan minuman. Namun seiring waktu, teknik pembuatan berkembang dan menciptakan produk yang lebih halus dan dekoratif.

Keramik dari berbagai wilayah di Indonesia menunjukkan keunikan budaya lokal masing-masing. Dari Sumatra hingga Papua, setiap daerah memiliki ciri khas tersendiri dalam pembuatan keramik yang mencerminkan kepercayaan dan nilai-nilai masyarakat setempat.'
            ],
            2 => [
                'id' => 2,
                'title' => 'Teknik Pembuatan Patung Batu',
                'author' => 'Budi Santoso',
                'date' => '10 Desember 2024',
                'category' => 'Teknik',
                'image' => 'img/placeholder.png',
                'excerpt' => 'Menggali lebih dalam tentang teknik dan alat yang digunakan para pengrajin...',
                'content' => 'Patung batu adalah salah satu karya seni tertua yang dikenal manusia. Proses pembuatannya memerlukan keahlian, kesabaran, dan pemahaman mendalam tentang material.

Para pengrajin kuno menggunakan alat-alat sederhana seperti batu dan kayu untuk mengukir batu keras. Teknik yang digunakan meliputi memukulkan, mengikis, dan mengasah permukaan batu secara perlahan untuk membentuk gambar atau patung yang diinginkan.

Setiap patung batu menceritakan kisah unik tentang kepercayaan, budaya, dan nilai estetika masyarakat pada masa itu. Dengan mempelajari teknik-teknik ini, kita dapat memahami tingkat kecanggihan dan apresiasi seni pada zaman dahulu.'
            ],
            3 => [
                'id' => 3,
                'title' => 'Koleksi Topeng Tradisional',
                'author' => 'Prof. Ani Wijaya',
                'date' => '5 Desember 2024',
                'category' => 'Budaya',
                'image' => 'img/placeholder.png',
                'excerpt' => 'Menjelajahi makna budaya dan artistik di balik setiap topeng tradisional...',
                'content' => 'Topeng tradisional adalah simbol penting dalam budaya Indonesia. Setiap topeng memiliki makna dan fungsi tersendiri dalam upacara adat, pertunjukan teater, dan ritual keagamaan.

Topeng tidak hanya berfungsi sebagai penutup wajah, tetapi juga sebagai medium untuk mengekspresikan emosi, karakter, dan nilai-nilai spiritual. Berbagai jenis topeng seperti topeng Cirebon, topeng Bali, dan topeng Betawi menunjukkan keragaman budaya Indonesia yang kaya.

Dalam koleksi museum kami, Anda dapat melihat detail-detail indah dari setiap topeng, mulai dari ukiran, pewarnaan, hingga bahan-bahan yang digunakan. Setiap topeng adalah karya seni yang memiliki cerita tersendiri tentang komunitas dan masa depan budaya Indonesia.'
            ],
            4 => [
                'id' => 4,
                'title' => 'Perkembangan Tekstil Tradisional',
                'author' => 'Ibu Martini',
                'date' => '1 Desember 2024',
                'category' => 'Seni',
                'image' => 'img/placeholder.png',
                'excerpt' => 'Mendalami seni pembuatan tekstil tradisional dari berbagai nusantara...',
                'content' => 'Tekstil tradisional adalah hasil karya yang menakjubkan dari keahlian turun-temurun yang telah berkembang selama berabad-abad. Setiap daerah di Indonesia memiliki motif dan teknik tenun yang unik dan khas.

Batik, songket, dan tenun tradisional merupakan warisan budaya yang sangat berharga. Proses pembuatannya memerlukan waktu, dedikasi, dan penguasaan teknik yang mendalam. Motif yang dihasilkan sering kali memiliki makna filosofis yang dalam, mencerminkan kepercayaan, harapan, dan aspirasi masyarakat.

Dengan adanya museum virtual AR kami, generasi muda dapat melihat dan memahami keindahan serta kompleksitas tekstil tradisional Indonesia, dan semoga terinspirasi untuk melestarikan warisan budaya ini.'
            ],
            5 => [
                'id' => 5,
                'title' => 'Artefak Logam Bersejarah',
                'author' => 'Dr. Akhmad Suryanto',
                'date' => '20 November 2024',
                'category' => 'Sejarah',
                'image' => 'img/placeholder.png',
                'excerpt' => 'Mengungkap misteri di balik artefak logam dari masa-masa keemasan...',
                'content' => 'Artefak logam memberikan wawasan berharga tentang tingkat teknologi dan kemampuan masyarakat pada masa lalu. Dari perhiasan emas yang indah hingga senjata besi yang kokoh, setiap artefak logam memiliki cerita yang penting untuk dipelajari.

Proses pembuatan logam pada masa lalu melibatkan pengetahuan metalurgi yang canggih. Para pengrajin mampu menggabungkan berbagai logam untuk menciptakan alat, senjata, dan benda dekoratif yang tidak hanya fungsional tetapi juga indah dipandang.

Studi terhadap artefak logam juga membantu arkeolog memahami rute perdagangan, hubungan antarbudaya, dan perkembangan teknologi dalam sejarah manusia.'
            ]
        ];
    }
}
