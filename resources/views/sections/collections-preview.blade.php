<!-- COLLECTIONS PREVIEW SECTION -->
<?php
$collections = [
    [
        'id' => 1,
        'nama' => 'Timun Bersejarah',
        'gambar' => 'img/timun.png'
    ],
    [
        'id' => 2,
        'nama' => 'Vas Kuno',
        'gambar' => 'img/placeholder.png'
    ],
    [
        'id' => 3,
        'nama' => 'Patung Batu',
        'gambar' => 'img/placeholder.png'
    ],
    [
        'id' => 4,
        'nama' => 'Topeng Klasik',
        'gambar' => 'img/placeholder.png'
    ],
    [
        'id' => 5,
        'nama' => 'Guci Emas',
        'gambar' => 'img/placeholder.png'
    ]
];
?>

<section id="collections-preview">
    <div class="section-header-top">
        <h2><b>Koleksi Unggulan Kami</b></h2>
        <p>Jelajahi koleksi artefak bersejarah yang telah dikurasi dengan cermat</p>
    </div>

    <div class="collections-carousel-wrapper">
        <div class="collections-carousel">
            <?php foreach ($collections as $item): ?>
            <div class="collection-item">
                <div class="collection-card">
                    <div class="collection-image">
                        <img src="{{ asset('<?php echo $item['gambar']; ?>') }}" alt="<?php echo $item['nama']; ?>">
                        <div class="collection-overlay">
                            <a href="{{ route('information', $item['id']) }}" class="btn-view">Lihat Detail</a>
                        </div>
                    </div>
                    <h3><?php echo $item['nama']; ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-cta-collections">
        <a href="{{ route('search') }}" class="btn btnbawah">Jelajahi Semua Koleksi</a>
    </div>
</section>

<script>
// Auto-scroll carousel untuk collections dengan continuous smooth scroll
const collectionsCarousel = document.querySelector('.collections-carousel');
let autoScrollInterval;
let isMouseOverCarousel = false;
let isAtEnd = false;

function autoScrollCollection() {
    if (collectionsCarousel && !isMouseOverCarousel) {
        const itemWidth = 320; // width + gap
        const maxScroll = collectionsCarousel.scrollWidth - collectionsCarousel.clientWidth;
        
        if (isAtEnd) {
            // Jika sudah di akhir, scroll kembali ke awal dengan smooth
            collectionsCarousel.scrollBy({
                left: -maxScroll,
                behavior: 'smooth'
            });
            isAtEnd = false;
        } else {
            // Scroll ke kanan
            collectionsCarousel.scrollBy({
                left: itemWidth,
                behavior: 'smooth'
            });
            
            // Cek apakah sudah mencapai akhir
            setTimeout(() => {
                if (collectionsCarousel.scrollLeft >= maxScroll - 10) {
                    isAtEnd = true;
                }
            }, 500);
        }
    }
}

function startAutoScroll() {
    autoScrollInterval = setInterval(autoScrollCollection, 4000);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval);
}

if (collectionsCarousel) {
    collectionsCarousel.addEventListener('mouseenter', () => {
        isMouseOverCarousel = true;
        stopAutoScroll();
    });
    
    collectionsCarousel.addEventListener('mouseleave', () => {
        isMouseOverCarousel = false;
        startAutoScroll();
    });
    
    startAutoScroll();
}
</script>

