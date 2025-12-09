<x-layout title="Search">

    <div class="page-content-wrapper">

    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/bawah.JPG') }}" alt="Collections">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>Koleksi Kami</h1>
            <p>Jelajahi koleksi artefak bersejarah pilihan kami</p>
        </div>
    </section>

    <main class="selection-main">
        <h2><b>Pilih Salah Satu Benda untuk Melihat Lebih Jelas!</b></h2>

        <div class="grid-container">
            @foreach ($items as $id => $item)
                <div class="museum-card">
                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" class="gambar">
                    <h3><b>{{ $item['nama'] }}</b></h3>
                    <a href="{{ url('/information/'.$id) }}" class="btn">Masuk ke Museum</a>
                </div>
            @endforeach
        </div>

        <div class="back-button-container">
            <a href="{{ url('/') }}" class="btnkembali">Kembali ←</a>
        </div>
    </main>

</x-layout>
