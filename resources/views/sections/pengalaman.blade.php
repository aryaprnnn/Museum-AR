<!-- PENGALAMAN SECTION -->
<?php
$konten = [
    'pengalaman_judul' => "Pengalaman Museum di genggaman anda!",
    'pengalaman_deskripsi' => "Ini adalah deskripsi yang ditarik dari array PHP. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
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
