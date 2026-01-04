<!-- AR FEATURES HIGHLIGHT SECTION -->
<section id="ar-features">
    <div class="ar-features-container">
        <div class="ar-features-header">
            <h2>{{ __('content.ar_features.title') }}</h2>
            <p class="ar-subtitle">{{ __('content.ar_features.subtitle') }}</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1: 360 View -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h3>{{ __('content.ar_features.card_1_title') }}</h3>
                <p>{{ __('content.ar_features.card_1_desc') }}</p>
            </div>

            <!-- Feature 2: AR Experience -->
            <div class="feature-card featured">
                <div class="feature-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <h3>{{ __('content.ar_features.card_2_title') }}</h3>
                <p>{{ __('content.ar_features.card_2_desc') }}</p>
                <span class="feature-badge">{{ __('content.ar_features.badge_featured') }}</span>
            </div>

            <!-- Feature 3: High Detail -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search-plus"></i>
                </div>
                <h3>{{ __('content.ar_features.card_3_title') }}</h3>
                <p>{{ __('content.ar_features.card_3_desc') }}</p>
            </div>

            <!-- Feature 4: Learn Interactive -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3>{{ __('content.ar_features.card_4_title') }}</h3>
                <p>{{ __('content.ar_features.card_4_desc') }}</p>
            </div>
        </div>

        <div class="ar-cta">
            <a href="{{ route('search') }}" class="btn btn-primary-large">
                <i class="fas fa-cube"></i>
                {{ __('content.ar_features.cta') }}
            </a>
        </div>
    </div>
</section>

<style>
#ar-features {
    background: #FFF0DC;
    padding: 100px 40px;
    position: relative;
    overflow: hidden;
    border-bottom: 2px solid #131010;
}

#ar-features::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -10%;
    width: 520px;
    height: 520px;
    background: radial-gradient(circle at 30% 30%, rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.02), transparent 70%);
    border-radius: 50%;
    z-index: 0;
    filter: blur(10px);
}

.ar-features-container {
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

.ar-features-header {
    text-align: center;
    margin-bottom: 70px;
}

.ar-features-header h2 {
    font-size: 3rem;
    font-weight: 800;
    color: #111111;
    margin-bottom: 15px;
    letter-spacing: -0.02em;
    margin-bottom: 15px;
    letter-spacing: -0.02em;
}

.ar-subtitle {
    font-size: 1.15rem;
    color: #4b5563;
    font-weight: 400;
    font-weight: 400;
    letter-spacing: 0.02em;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    margin-bottom: 60px;
}

.feature-card {
    background: #F0BB78;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 40px 30px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    position: relative;
    cursor: pointer;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
}

.feature-card:hover {
    transform: translateY(-12px) scale(1.02);
    background: #e6dbceff;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
    border-color: #868686ff;
}

.feature-card.featured {
    background: linear-gradient(145deg, #f3f4f6, #f5dcbcff);
    border: 2px solid #d1d5db;
    transform: scale(1.03);
}

.feature-card.featured:hover {
    transform: scale(1.05) translateY(-12px);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.18);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: #e5e7eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    transition: all 0.4s ease;
    position: relative;
    box-shadow: inset 0 0 0 1px #d1d5db;
}

.feature-card:hover .feature-icon {
    background: #f3f4f6;
    transform: rotateY(360deg) scale(1.08);
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.12);
}

.feature-card.featured .feature-icon {
    background: #d1d5db;
    box-shadow: inset 0 0 0 2px #9ca3af;
}

.feature-icon i {
    font-size: 2rem;
    color: #111111;
}

.feature-card h3 {
    font-size: 1.35rem;
    font-weight: 700;
    color: #111111;
    margin-bottom: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.feature-card:hover h3 {
    color: #1f2937;
    text-shadow: 0 0 20px rgba(0, 0, 0, 0.12);
}

.feature-card p {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #4b5563;
    margin: 0;
    transition: all 0.3s ease;
}

.feature-card:hover p {
    color: #111111;
}

.feature-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #111111;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    animation: badgePulse 2s ease-in-out infinite;
}

@keyframes badgePulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
    }
}

.ar-cta {
    text-align: center;
    margin-top: 50px;
}

.btn-primary-large {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 40px;
    background: #131010;
    color: #ffffff;
    border: none;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    position: relative;
    overflow: hidden;
}

.btn-primary-large::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.15);
    transition: left 0.4s ease;
}

.btn-primary-large:hover::before {
    left: 100%;
}

.btn-primary-large:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 55px rgba(0, 0, 0, 0.35);
    border-radius: 50px; /* keep shape consistent on hover */
}

.btn-primary-large i {
    font-size: 1.3rem;
    transition: all 0.4s ease;
}

.btn-primary-large:hover i {
    transform: scale(1.1);
}

@media (max-width: 1200px) {
    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .feature-card.featured {
        transform: scale(1);
    }
}

@media (max-width: 768px) {
    #ar-features {
        padding: 60px 20px;
    }
    
    .ar-features-header h2 {
        font-size: 2rem;
    }
    
    .ar-subtitle {
        font-size: 1rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .feature-card.featured {
        transform: scale(1);
    }
}
</style>
