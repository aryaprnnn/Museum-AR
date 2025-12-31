<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update admin user
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@museum.com'],
            [
                'name' => 'Admin Museum',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'whatsapp' => '081234567890'
            ]
        );

        // Create sample user
        \App\Models\User::updateOrCreate(
            ['email' => 'user@museum.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('user123'),
                'role' => 'user',
                'whatsapp' => '081234567891'
            ]
        );

        // Sample blogs
        \App\Models\Blog::create([
            'title' => 'Welcome to ARtifact Museum',
            'slug' => 'welcome-to-artifact-museum',
            'excerpt' => 'Discover the future of museum experience',
            'content' => 'Welcome to our museum where history meets technology...',
            'category' => 'News & Event',
            'is_published' => true
        ]);

        // Sample collections
        \App\Models\Collection::create([
            'name' => 'Keramik Nusantara',
            'slug' => 'keramik-nusantara',
            'description' => 'Koleksi keramik langka dari berbagai era',
            'category' => 'Keramik',
            'era' => '15th Century',
            'origin' => 'Indonesia',
            'is_published' => true
        ]);

        // Sample art classes
        \App\Models\ArtClass::create([
            'title' => 'Sketsa Dasar',
            'slug' => 'sketsa-dasar',
            'description' => 'Belajar garis, bentuk, dan shading untuk fondasi menggambar.',
            'level' => 'pemula',
            'instructor' => 'Rina Santoso',
            'schedule' => 'Sabtu, 10:00 - 12:00 WIB',
            'quota' => 15,
            'available' => 12,
            'price' => 350000,
            'is_active' => true
        ]);

        // Sample educational programs
        \App\Models\EducationalProgram::create([
            'title' => 'Seminar Sejarah Keramik',
            'slug' => 'seminar-sejarah-keramik',
            'description' => 'Memahami kronologi dan gaya keramik dari berbagai era.',
            'type' => 'seminar',
            'facilitator' => 'Dr. Adi Pratama',
            'schedule' => 'Minggu, 13:00 - 15:00 WIB',
            'location' => 'Auditorium Museum',
            'is_active' => true
        ]);

        // Sample exhibitions
        \App\Models\Exhibition::create([
            'title' => 'Jejak Keramik Nusantara',
            'slug' => 'jejak-keramik-nusantara',
            'description' => 'Pameran keramik langka dengan narasi perjalanan maritim.',
            'curator' => 'Tim Kurasi Museum',
            'start_date' => '2025-01-20',
            'end_date' => '2025-02-20',
            'time' => '10:00 - 18:00 WIB',
            'location' => 'Galeri Utama',
            'status' => 'upcoming',
            'is_active' => true
        ]);

        // Sample about content
        \App\Models\AboutContent::create([
            'section' => 'hero',
            'title' => 'Tentang Museum Virtual Kami',
            'content' => 'Selamat datang di Museum Virtual ARtifact - platform inovatif yang menghadirkan pengalaman bersejarah ke dalam genggaman Anda.',
            'order' => 1,
            'is_active' => true
        ]);

        \App\Models\AboutContent::create([
            'section' => 'mission',
            'title' => 'Misi Kami',
            'content' => 'Membuat warisan budaya dan sejarah Indonesia dapat diakses oleh semua orang di mana pun mereka berada melalui teknologi augmented reality.',
            'order' => 1,
            'is_active' => true
        ]);

        \App\Models\AboutContent::create([
            'section' => 'vision',
            'title' => 'Visi Kami',
            'content' => 'Menjadi platform museum virtual terdepan di Asia Tenggara yang menghubungkan warisan budaya dengan generasi digital melalui teknologi terkini.',
            'order' => 2,
            'is_active' => true
        ]);

        \App\Models\AboutContent::create([
            'section' => 'achievement',
            'title' => '500+ Koleksi Artefak',
            'content' => 'Kami telah berhasil mengkurasi dan meng-digitalisasi lebih dari 500 artefak bersejarah dari berbagai wilayah Indonesia dengan detail 3D yang akurat.',
            'order' => 1,
            'is_active' => true
        ]);

        \App\Models\AboutContent::create([
            'section' => 'achievement',
            'title' => '100,000+ Pengunjung',
            'content' => 'Platform kami telah dikunjungi oleh lebih dari 100 ribu pengunjung dari berbagai negara yang tertarik menjelajahi koleksi budaya Indonesia.',
            'order' => 2,
            'is_active' => true
        ]);

        \App\Models\AboutContent::create([
            'section' => 'achievement',
            'title' => 'Penghargaan Inovasi',
            'content' => 'Menerima berbagai penghargaan internasional untuk inovasi dalam pendidikan digital dan preservasi warisan budaya.',
            'order' => 3,
            'is_active' => true
        ]);
    }
}
