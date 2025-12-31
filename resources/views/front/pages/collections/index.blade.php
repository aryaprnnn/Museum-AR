<x-layout title="Search" :mainClass="'light-bg'">

    <div class="page-content-wrapper">

    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/2.JPG') }}" alt="Collections">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>{{ __('content.collections_page.hero_title') }}</h1>
            <p>{{ __('content.collections_page.hero_subtitle') }}</p>
        </div>
    </section>

    <main class="selection-main">
        <h2><b>{{ __('content.collections_page.select_prompt') }}</b></h2>

        <div class="grid-container">
            @forelse ($items as $item)
                @php
                    $imageUrl = $item->image
                        ? (\Illuminate\Support\Str::startsWith($item->image, ['http://', 'https://'])
                            ? $item->image
                            : asset('storage/'.$item->image))
                        : asset('img/placeholder.png');
                @endphp
                <div class="museum-card">
                    <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="gambar">
                    <h3><b>{{ $item->name }}</b></h3>
                    <p style="min-height:48px;color:#555;font-size:0.95rem;">{{ \Illuminate\Support\Str::limit($item->description, 90) }}</p>
                    <a href="{{ route('collections.show', $item->id) }}" class="btn">{{ __('content.collections_page.enter') }}</a>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Belum ada koleksi</h3>
                    <p style="margin: 0; font-size: 0.95rem;">Koleksi akan segera ditambahkan</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if($items->hasPages())
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $items->appends(request()->query())->links() }}
        </div>
        @endif

        <div class="back-button-container">
            <a href="{{ url('/') }}" class="btnkembali">{{ __('content.collections_page.back_home') }}</a>
        </div>
    </main>

</x-layout>
