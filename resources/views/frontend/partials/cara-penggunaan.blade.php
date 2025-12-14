<!-- CARA PENGGUNAAN SECTION -->
<?php
$konten = [
    'cara_judul_item' => __('content.how_to.item_title'),
    'cara_deskripsi' => __('content.how_to.description'),
];
?>

<section id="cara-penggunaan">
    <div class="container">
        <h2><b>{{ __('content.how_to.heading') }}</b></h2>
        
        <div class="cara-wrapper">
            <div class="cara-card">
                <img src="{{ asset('img/timun.png') }}" alt="Placeholder Timun Bersejarah">
                
                <h3><b><?php echo $konten['cara_judul_item']; ?></b></h3>
                <a href="{{ route('search') }}" class="btn">{{ __('content.how_to.cta') }}</a>
            </div>

            <div class="cara-text">
                <p><?php echo $konten['cara_deskripsi']; ?></p>
            </div>
        </div>
    </div>
</section>
