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
                    <div class="collection-image">
                        <img src="{{ \Illuminate\Support\Str::startsWith($item['gambar'], ['http://', 'https://']) ? $item['gambar'] : asset('storage/'.$item['gambar']) }}" alt="{{ $item['nama'] }}">
                        <div class="collection-overlay">
                            <a href="{{ route('collections.show', $item['id']) }}" class="btn-view">{{ __('content.collections_preview.view_detail') }}</a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('collectionsCarousel');
    const itemCount = parseInt(carousel.dataset.itemCount) || 0;
    
    // Clone items untuk seamless looping
    if (itemCount > 0) {
        const items = carousel.querySelectorAll('.collection-item');
        items.forEach(item => {
            const clone = item.cloneNode(true);
            carousel.appendChild(clone);
        });
        
        // Set animation dynamically
        const totalWidth = (300 * itemCount) + (25 * itemCount);
        const style = document.createElement('style');
        style.textContent = `
            .collections-carousel {
                animation: scrollLeft 35s linear infinite !important;
            }
            
            @keyframes scrollLeft {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-${totalWidth}px);
                }
            }
            
            .collections-carousel-wrapper:hover .collections-carousel {
                animation-play-state: paused !important;
            }
        `;
        document.head.appendChild(style);
    }
});
</script>

{{-- External JavaScript --}}
<script src="{{ asset('js/collections-carousel.js') }}"></script>
