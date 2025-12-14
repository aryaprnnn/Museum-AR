<section class="exhibition-section">
    <div class="section-header">
        <p class="eyebrow">EXHIBITIONS</p>
        <p class="section-subtitle">Step into rotating exhibitions featuring timeless pieces and contemporary voices.</p>
    </div>

    <div class="exhibition-grid">
        <div class="exhibition-card" style="background-image: url('{{ asset('img/bawah.JPG') }}');">
            <div class="exhibition-overlay">
                <div class="exhibition-text">
                    <h3>Inspired by Indonesian Heritage</h3>
                </div>
            </div>
        </div>

        <div class="exhibition-card" style="background-image: url('{{ asset('img/bekgron.jpg') }}');">
            <div class="exhibition-overlay">
                <div class="exhibition-text">
                    <h3>Botanical Reveries</h3>
                </div>
            </div>
        </div>

        <div class="exhibition-card" style="background-image: url('{{ asset('img/hp.jpg') }}');">
            <div class="exhibition-overlay">
                <div class="exhibition-text">
                    <h3>Modern Echoes</h3>
                </div>
            </div>
        </div>

        <div class="exhibition-card" style="background-image: url('{{ asset('img/motong.JPG') }}');">
            <div class="exhibition-overlay">
                <div class="exhibition-text">
                    <h3>Textile Narratives</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="section-cta-exhibitions">
        <a href="{{ route('search') }}" class="btn btnbawah btn-exhibitions">VIEW ALL EXHIBITIONS</a>
    </div>
</section>
