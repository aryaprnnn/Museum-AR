<!-- ABOUT US PREVIEW SECTION -->
<?php
$konten = [
    'about_judul' => "Tentang Kami",
    'about_deskripsi' => "Museum Virtual kami adalah platform inovatif yang menghadirkan pengalaman bersejarah ke dalam genggaman Anda. Dengan teknologi 3D terkini, kami membuat artefak bersejarah dapat diakses oleh semua orang di mana pun mereka berada. Koleksi kami mencakup berbagai benda bersejarah yang telah dikurasi dengan cermat oleh para ahli.",
];
?>

<section id="about-preview">
    <div class="container">
        <div class="about-wrapper">
            <div class="about-image">
                <img src="{{ asset('img/bawah.JPG') }}" alt="Museum Virtual">
            </div>
            <div class="about-content">
                <h2><b><?php echo $konten['about_judul']; ?></b></h2>
                <p><?php echo $konten['about_deskripsi']; ?></p>
                <a href="{{ route('about') }}" class="btn btn-about">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </div>
</section>
