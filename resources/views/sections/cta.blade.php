<!-- CTA SECTION -->
<?php
$konten = [
    'cta_judul' => "Sudah Siap untuk masuk ke Museum Virtualnya?"
];
?>

<section id="cta">
    <div class="cta-content">
        <h2><b><?php echo $konten['cta_judul']; ?></b></h2>
        <a href="{{ route('search') }}" class="btnbawah">Klik Disini!</a>
    </div>
</section>
