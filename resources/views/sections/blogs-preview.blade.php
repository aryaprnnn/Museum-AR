<!-- BLOGS PREVIEW SECTION -->
<?php
$blogs = [
    [
        'id' => 1,
        'title' => 'Sejarah Koleksi Pertama',
        'excerpt' => 'Kisah singkat tentang koleksi perdana museum yang menjadi fondasi perjalanan kami.',
        'image' => 'img/item1.jpg',
        'date' => '15 Desember 2024'
    ],
    [
        'id' => 2,
        'title' => 'Perjalanan Kurator Museum',
        'excerpt' => 'Catatan perjalanan kurator mencari dan mengumpulkan artefak unik dari berbagai belahan dunia.',
        'image' => 'img/item2.jpg',
        'date' => '10 Desember 2024'
    ],
    [
        'id' => 3,
        'title' => 'Teknologi 3D dalam Museum',
        'excerpt' => 'Bagaimana teknologi 3D viewer mengubah cara kita melihat dan mempelajari artefak bersejarah.',
        'image' => 'img/item3.jpg',
        'date' => '5 Desember 2024'
    ]
];
?>

<section id="blogs-preview">
    <div class="section-header-top">
        <h2><b>Blog Terbaru Kami</b></h2>
        <p>Pelajari lebih lanjut tentang koleksi dan sejarah museum kami</p>
    </div>

    <div class="blogs-horizontal-scroll">
        <div class="blogs-carousel">
            <?php foreach ($blogs as $blog): ?>
            <div class="blog-card-horizontal">
                <div class="blog-image">
                    <img src="{{ asset('<?php echo $blog['image']; ?>') }}" alt="<?php echo $blog['title']; ?>">
                    <span class="blog-date"><?php echo $blog['date']; ?></span>
                </div>
                <div class="blog-content">
                    <h3><?php echo $blog['title']; ?></h3>
                    <p><?php echo $blog['excerpt']; ?></p>
                    <a href="{{ route('blogs.show', $blog['id']) }}" class="read-more">Baca Selengkapnya →</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-cta-blogs">
        <a href="{{ route('blogs') }}" class="btn btnbawah">Lihat Semua Blog</a>
    </div>
</section>

