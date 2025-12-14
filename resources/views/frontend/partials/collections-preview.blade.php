<!-- COLLECTIONS PREVIEW SECTION -->
<?php
$collections = __('content.collections_preview.items');
?>

<section id="collections-preview">
    <div class="section-header-top">
        <h2><b>{{ __('content.collections_preview.heading') }}</b></h2>
        <p>{{ __('content.collections_preview.subheading') }}</p>
    </div>

    <div class="collections-carousel-wrapper">
        <div class="collections-carousel">
            <?php foreach ($collections as $item): ?>
            <div class="collection-item">
                <div class="collection-card">
                    <div class="collection-image">
                        <img src="{{ asset('<?php echo $item['image']; ?>') }}" alt="<?php echo $item['name']; ?>">
                        <div class="collection-overlay">
                            <a href="{{ route('information', $item['id']) }}" class="btn-view">{{ __('content.collections_preview.view_detail') }}</a>
                        </div>
                    </div>
                    <h3><?php echo $item['name']; ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-cta-collections">
        <a href="{{ route('search') }}" class="btn btnbawah">{{ __('content.collections_preview.cta') }}</a>
    </div>
</section>

{{-- External JavaScript --}}
<script src="{{ asset('js/collections-carousel.js') }}"></script>
