<x-layout title="About Us">

<div class="about-page-wrapper">
    <!-- IMAGE CAROUSEL SECTION -->
    <section class="about-carousel-section">
        <div class="about-carousel">
            <div class="carousel-slide active">
                <img src="{{ asset('img/gap.jpg') }}" alt="Museum 1">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/bawah.JPG') }}" alt="Museum 2">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/hp.jpg') }}" alt="Museum 3">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/timun.png') }}" alt="Museum 4">
            </div>
        </div>
        <div class="carousel-indicators">
            <span class="indicator active" data-slide="0"></span>
            <span class="indicator" data-slide="1"></span>
            <span class="indicator" data-slide="2"></span>
            <span class="indicator" data-slide="3"></span>
        </div>
    </section>

    <section class="about-content-section">
        <div class="container">
            <!-- STORY SECTION 1: Image Left, Text Right -->
            <div class="story-section story-section-1">
                <div class="story-image">
                    <img src="{{ asset('img/gap.jpg') }}" alt="Museum Virtual AR">
                </div>
                <div class="story-text">
                    <h2>Tentang Museum Virtual AR</h2>
                    <p>Museum Virtual AR adalah platform inovatif yang menghadirkan pengalaman museum digital terdepan di Indonesia. Kami berdedikasi untuk melestarikan dan membagikan warisan budaya serta sejarah kepada masyarakat luas melalui teknologi augmented reality dan 3D modeling yang canggih.</p>
                    <p>Dengan koleksi artefak bersejarah yang dipilih secara teliti oleh para ahli, kami memastikan setiap pengunjung mendapatkan pengalaman edukatif yang mendalam dan interaktif. Teknologi terkini memungkinkan Anda menjelajahi setiap detail koleksi dari rumah Anda sendiri.</p>
                </div>
            </div>

            <!-- STORY SECTION 2: Text Left, Image Right -->
            <div class="story-section story-section-2">
                <div class="story-text">
                    <h2>Sejarah Berdirinya Museum</h2>
                    <p>Museum Virtual AR didirikan pada tahun 2023 sebagai respons terhadap kebutuhan akan akses digital terhadap koleksi budaya. Kami memulai dengan visi sederhana namun kuat: membuat warisan budaya Indonesia dapat diakses oleh siapa saja, di mana saja, kapan saja.</p>
                    <p>Perjalanan kami dimulai dengan mengumpulkan artefak dari berbagai daerah di Indonesia, bekerja sama dengan museum tradisional, komunitas lokal, dan para kolektor pribadi. Setiap artefak di-scan menggunakan teknologi 3D terdepan untuk menghadirkan pengalaman yang immersive dan akurat.</p>
                </div>
                <div class="story-image">
                    <img src="{{ asset('img/bawah.JPG') }}" alt="Sejarah Museum">
                </div>
            </div>

            <!-- ACHIEVEMENTS SECTION -->
            <div class="achievements-section">
                <h2>Prestasi & Capaian Kami</h2>
                <p class="section-intro">Kami bangga telah mencapai berbagai milestone dalam perjalanan membawa museum digital ke Indonesia</p>
                
                <div class="achievements-list">
                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/timun.png') }}" alt="500+ Koleksi">
                        </div>
                        <div class="achievement-info">
                            <h3>500+ Koleksi Artefak</h3>
                            <p>Kami telah berhasil mengkurasi dan meng-digitalisasi lebih dari 500 artefak bersejarah dari berbagai wilayah Indonesia dengan detail 3D yang akurat.</p>
                        </div>
                    </div>

                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="100K+ Pengunjung">
                        </div>
                        <div class="achievement-info">
                            <h3>100,000+ Pengunjung</h3>
                            <p>Platform kami telah dikunjungi oleh lebih dari 100 ribu pengunjung dari berbagai negara yang tertarik menjelajahi koleksi budaya Indonesia.</p>
                        </div>
                    </div>

                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="Penghargaan Inovasi">
                        </div>
                        <div class="achievement-info">
                            <h3>Penghargaan Inovasi Digital 2024</h3>
                            <p>Diakui sebagai inovasi terbaik dalam kategori digital heritage oleh Indonesian Digital Innovation Summit 2024.</p>
                        </div>
                    </div>

                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="Kerjasama">
                        </div>
                        <div class="achievement-info">
                            <h3>15+ Kerjasama Institusi</h3>
                            <p>Kami telah menjalin kerjasama dengan 15 institusi budaya, museum tradisional, dan universitas untuk memperkaya koleksi kami.</p>
                        </div>
                    </div>

                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="AR Technology">
                        </div>
                        <div class="achievement-info">
                            <h3>Teknologi AR Terdepan</h3>
                            <p>Menggunakan teknologi augmented reality dan machine learning terkini untuk memberikan pengalaman yang paling immersive di kelasnya.</p>
                        </div>
                    </div>

                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="Program Edukasi">
                        </div>
                        <div class="achievement-info">
                            <h3>Program Edukasi 50 Sekolah</h3>
                            <p>Telah bermitra dengan 50 sekolah di Indonesia untuk mengintegrasikan platform kami dalam kurikulum pendidikan sejarah dan budaya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA SECTION -->
            <div class="about-cta">
                <h2>Siap Menjelajahi Koleksi Kami?</h2>
                <a href="{{ route('search') }}" class="btn btnbawah">Mulai Jelajah Sekarang</a>
            </div>
        </div>
    </section>
</div>

<script>
// Auto carousel for about page
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const indicators = document.querySelectorAll('.indicator');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        indicators[i].classList.remove('active');
    });
    
    slides[index].classList.add('active');
    indicators[index].classList.add('active');
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

// Auto advance every 3 seconds
setInterval(nextSlide, 3000);

// Manual control
indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentSlide = index;
        showSlide(currentSlide);
    });
});
</script>

</x-layout>
