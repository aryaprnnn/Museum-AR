<!-- CTA SECTION -->
<?php
$konten = [
    'cta_judul' => __('content.cta.title')
];
?>

<section id="cta">
    <div class="cta-content">
        <h2><b><?php echo $konten['cta_judul']; ?></b></h2>
        <a href="{{ route('search') }}" class="btnbawah">{{ __('content.cta.cta') }}</a>
    </div>
</section>
