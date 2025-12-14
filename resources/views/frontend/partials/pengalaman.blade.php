<!-- PENGALAMAN SECTION -->
<?php
$konten = [
    'pengalaman_judul' => __('content.experience.title'),
    'pengalaman_deskripsi' => __('content.experience.description'),
];
?>

<section id="pengalaman">
    <div class="text-content">
        <h1><b><?php echo $konten['pengalaman_judul']; ?></b></h1>
        <p><?php echo $konten['pengalaman_deskripsi']; ?></p>
    </div>
    <div class="image-content">
        <img src="{{ asset('img/hp.jpg') }}" alt="Tangan memegang smartphone" width="400" height="300">
    </div>
</section>
