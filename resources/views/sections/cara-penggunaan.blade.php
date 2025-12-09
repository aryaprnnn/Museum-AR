<!-- CARA PENGGUNAAN SECTION -->
<?php
$konten = [
    'cara_judul_item' => "Timun Bersejarah",
    'cara_deskripsi' => "Deskripsi cara penggunaan ini juga diambil dari PHP. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.",
];
?>

<section id="cara-penggunaan">
    <div class="container">
        <h2><b>Bagaimana Cara Menggunakannya?</b></h2>
        
        <div class="cara-wrapper">
            <div class="cara-card">
                <img src="{{ asset('img/timun.png') }}" alt="Placeholder Timun Bersejarah">
                
                <h3><b><?php echo $konten['cara_judul_item']; ?></b></h3>
                <a href="{{ route('search') }}" class="btn">Masuk Ke Museum</a>
            </div>

            <div class="cara-text">
                <p><?php echo $konten['cara_deskripsi']; ?></p>
            </div>
        </div>
    </div>
</section>
