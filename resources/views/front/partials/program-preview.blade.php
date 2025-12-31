<section class="program-section">
    <div class="section-header">
        <div class="section-header-content">
            <div class="section-header-left">
                <p class="eyebrow">{{ __('content.program_preview.title') }}</p>
            </div>
            <div class="section-header-right">
                <p class="section-subtitle">{{ __('content.program_preview.subtitle') }}</p>
            </div>
        </div>
    </div>

    <div class="program-grid">
        {{-- Exhibitions Program --}}
        <a href="{{ route('exhibitions') }}" class="program-card" style="background-image: url('{{ asset('img/exhibitions-photo.jpg') }}');">
            <div class="program-overlay">
                <div class="program-text">
                    <h3>{{ __('nav.exhibitions') }}</h3>
                </div>
            </div>
        </a>

        {{-- Art Class Program --}}
        <a href="{{ route('artclass') }}" class="program-card" style="background-image: url('{{ asset('img/artclass-photo.jpg') }}');">
            <div class="program-overlay">
                <div class="program-text">
                    <h3>{{ __('nav.art_class') }}</h3>
                </div>
            </div>
        </a>

        {{-- Educational Program --}}
        <a href="{{ route('educational-program') }}" class="program-card" style="background-image: url('{{ asset('img/edu-photo.jpg') }}');">
            <div class="program-overlay">
                <div class="program-text">
                    <h3>{{ __('nav.educational_program') }}</h3>
                </div>
            </div>
        </a>
    </div>
</section>

<style>
.program-section {
    padding: 80px 40px;
    background: #fff;
}

.section-header-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 60px;
    max-width: 1400px;
    margin: 0 auto 60px;
}

.section-header-left {
    flex-shrink: 0;
}

.section-header-right {
    flex: 1;
    max-width: 600px;
}

.eyebrow {
    font-size: 5.5rem;
    font-weight: 600;
    letter-spacing: 0.02em;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.2;
}

.section-subtitle {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #555;
    margin: 0;
}

.program-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
}

.program-card {
    position: relative;
    height: 450px;
    background-size: cover;
    background-position: center;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
    text-decoration: none;
    display: block;
}

.program-card:hover {
    transform: translateY(-5px);
}

.program-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    transition: background 0.3s ease;
}

.program-card:hover .program-overlay {
    background: rgba(0, 0, 0, 0.5);
}

.program-text {
    color: #fff;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    text-align: center;
}

.program-card:hover .program-text {
    opacity: 1;
    transform: translateY(0);
}

.program-text h3 {
    font-size: 2.5rem;
    font-weight: 600;
    margin: 0;
    color: #fff;
}

@media (max-width: 1024px) {
    .section-header-content {
        flex-direction: column;
        gap: 30px;
    }
    
    .section-header-right {
        text-align: left;
    }
}

@media (max-width: 640px) {
    .program-section {
        padding: 60px 20px;
    }
    
    .program-grid {
        gap: 20px;
    }
    
    .program-card {
        height: 250px;
    }
    
    .section-header-content {
        margin-bottom: 40px;
    }
    
    .program-text h3 {
        font-size: 1.8rem;
    }
}
</style>