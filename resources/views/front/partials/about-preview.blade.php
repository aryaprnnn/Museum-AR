<!-- ABOUT US PREVIEW SECTION -->
<?php
$konten = [
    'about_judul' => __('content.about_preview.title'),
    'about_deskripsi' => __('content.about_preview.description'),
];
?>

<section id="about-preview">
    <div class="container">
        <div class="about-wrapper">
            <div class="about-image">
                <img src="{{ asset('img/4.jpg') }}" alt="Museum Virtual">
            </div>
            <div class="about-content">
                <h2><b><?php echo $konten['about_judul']; ?></b></h2>
                <p><?php echo $konten['about_deskripsi']; ?></p>
                <a href="{{ route('about') }}" class="btn btn-about">{{ __('content.about_preview.cta') }}</a>
            </div>
        </div>
    </div>
</section>
