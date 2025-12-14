<x-layout title="Search">

    <div class="page-content-wrapper">

    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/bawah.JPG') }}" alt="Collections">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>{{ __('content.collections_page.hero_title') }}</h1>
            <p>{{ __('content.collections_page.hero_subtitle') }}</p>
        </div>
    </section>

    <main class="selection-main">
        <h2><b>{{ __('content.collections_page.select_prompt') }}</b></h2>

        <div class="grid-container">
            @foreach ($items as $id => $item)
                <div class="museum-card">
                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" class="gambar">
                    <h3><b>{{ $item['nama'] }}</b></h3>
                    <a href="{{ route('information', $id) }}" class="btn">{{ __('content.collections_page.enter') }}</a>
                </div>
            @endforeach
        </div>

        <div class="back-button-container">
            <a href="{{ url('/') }}" class="btnkembali">{{ __('content.collections_page.back_home') }}</a>
        </div>
    </main>

</x-layout>
