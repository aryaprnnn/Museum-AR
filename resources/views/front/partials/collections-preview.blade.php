<!-- COLLECTIONS PREVIEW SECTION -->
<section id="collections-preview">
    <div class="section-header-top">
        <h2><b>{{ __('content.collections_preview.heading') }}</b></h2>
        <p>{{ __('content.collections_preview.subheading') }}</p>
    </div>

    <div class="collections-carousel-wrapper">
        <div class="collections-carousel" id="collectionsCarousel" data-item-count="{{ count($collections) }}">
            @forelse($collections as $item)
            <div class="collection-item">
                <div class="collection-card">
                    <div class="collection-image-wrapper">
                        <div class="collection-image-inner">
                            <img src="{{ \Illuminate\Support\Str::startsWith($item['gambar'], ['http://', 'https://']) ? $item['gambar'] : asset('storage/'.$item['gambar']) }}" alt="{{ $item['nama'] }}">
                        </div>
                    </div>
                    <h3>{{ $item['nama'] }}</h3>
                </div>
            </div>
            @empty
            <p style="grid-column: 1/-1; text-align: center; padding: 40px;">{{ __('content.collections_preview.empty') }}</p>
            @endforelse
        </div>
    </div>

    <div class="section-cta-collections">
        <a href="{{ route('search') }}" class="btn btnbawah">{{ __('content.collections_preview.cta') }}</a>
    </div>
</section>



{{-- External JavaScript --}}
<script src="{{ asset('js/collections-carousel.js') }}?v=FINAL_V3"></script>
