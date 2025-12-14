<section class="artclass-section">
    <div class="artclass-hero">
        <div class="artclass-hero-text">
            <div class="artclass-title-wrapper">
                <span class="eyebrow">ART CLASS</span>
                <p class="section-subtitle">Spend an inspiring afternoon in our wonderful art studio, unleashing your creativity in a welcoming and collaborative environment. All materials are provided, no experience needed. Join us for an unforgettable artistic journey.</p>
            </div>
            <h2 style="display: none;">Come meet us in our wonderful art studio</h2>
        </div>

        <div class="artclass-hero-card">
            <button class="artclass-nav artclass-nav-left" aria-label="Previous class">
                <span>&lsaquo;</span>
            </button>

            <div class="artclass-slider" data-index="0">
                <div class="artclass-card">
                    <div class="artclass-card-media">
                        <img src="{{ asset('img/item2.jpg') }}" alt="Resin Ocean Painting Class" loading="lazy">
                    </div>
                    <div class="artclass-card-body">
                        <h3>Resin Ocean<br>Painting Class</h3>
                        <p class="pill">1,5 hours</p>
                        <p class="card-desc">Fully guide resin ocean painting class</p>
                        <div class="card-actions">
                            <a class="text-link" href="#">More info</a>
                            <a class="btn btn-light" href="#">Book now</a>
                        </div>
                    </div>
                </div>

                <div class="artclass-card">
                    <div class="artclass-card-media">
                        <img src="{{ asset('img/item1.jpg') }}" alt="Watercolor Basics" loading="lazy">
                    </div>
                    <div class="artclass-card-body">
                        <h3>Watercolor<br>Basics</h3>
                        <p class="pill">2 hours</p>
                        <p class="card-desc">Learn washes, layering, and blending with guided practice.</p>
                        <div class="card-actions">
                            <a class="text-link" href="#">More info</a>
                            <a class="btn btn-light" href="#">Book now</a>
                        </div>
                    </div>
                </div>

                <div class="artclass-card">
                    <div class="artclass-card-media">
                        <img src="{{ asset('img/item3.jpg') }}" alt="Acrylic Palette Knife" loading="lazy">
                    </div>
                    <div class="artclass-card-body">
                        <h3>Acrylic<br>Palette Knife</h3>
                        <p class="pill">1,5 hours</p>
                        <p class="card-desc">Create textured artworks using bold strokes and color.</p>
                        <div class="card-actions">
                            <a class="text-link" href="#">More info</a>
                            <a class="btn btn-light" href="#">Book now</a>
                        </div>
                    </div>
                </div>
            </div>

            <button class="artclass-nav artclass-nav-right" aria-label="Next class">
                <span>&rsaquo;</span>
            </button>
        </div>
    </div>

    <div class="section-cta-artclass">
        <a href="{{ route('search') }}" class="btn btnbawah">VIEW ALL ART CLASSES</a>
    </div>
</section>

<script defer src="{{ asset('js/artclass-slider.js') }}"></script>
