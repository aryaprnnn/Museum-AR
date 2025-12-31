<x-layout title="About Us">

<div class="about-page-wrapper">
    <!-- IMAGE CAROUSEL SECTION -->
    <section class="about-carousel-section">
        <div class="about-carousel">
            <div class="carousel-slide active">
                <img src="{{ asset('img/4.jpg') }}" alt="Museum 1">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/5.JPG') }}" alt="Museum 2">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/1.jpg') }}" alt="Museum 3">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/3.png') }}" alt="Museum 4">
            </div>
        </div>
        <div class="carousel-indicators">
            <span class="indicator active" data-slide="0"></span>
            <span class="indicator" data-slide="1"></span>
            <span class="indicator" data-slide="2"></span>
            <span class="indicator" data-slide="3"></span>
        </div>
    </section>

    <section class="about-content-section">
        <div class="container">
            <!-- STORY SECTION 1: Image Left, Text Right -->
            <div class="story-section story-section-1">
                <div class="story-image">
                    <img src="{{ asset('img/3.jpg') }}" alt="Museum Virtual AR">
                </div>
                <div class="story-text">
                    <h2>{{ __('content.about_page.story_title') }}</h2>
                    <p>{{ __('content.about_page.story_description_1') }}</p>
                    <p>{{ __('content.about_page.story_description_2') }}</p>
                </div>
            </div>

            <!-- STORY SECTION 2: Text Left, Image Right -->
            <div class="story-section story-section-2">
                <div class="story-text">
                    <h2>{{ __('content.about_page.history_title') }}</h2>
                    <p>{{ __('content.about_page.history_description_1') }}</p>
                    <p>{{ __('content.about_page.history_description_2') }}</p>
                </div>
                <div class="story-image">
                    <img src="{{ asset('img/7.JPG') }}" alt="Sejarah Museum">
                </div>
            </div>

            <!-- ACHIEVEMENTS SECTION -->
            <div class="achievements-section">
                <h2>{{ __('content.about_page.achievements_title') }}</h2>
                <p class="section-intro">{{ __('content.about_page.achievements_intro') }}</p>
                
                <div class="achievements-list">
                    @forelse($aboutContents['achievement'] ?? [] as $achievement)
                    <div class="achievement-item">
                        <div class="achievement-image">
                            @if($achievement->image)
                                <img src="{{ asset('storage/'.$achievement->image) }}" alt="{{ $achievement->title }}">
                            @else
                                <img src="{{ asset('img/placeholder.png') }}" alt="{{ $achievement->title }}">
                            @endif
                        </div>
                        <div class="achievement-info">
                            @php($locale = app()->getLocale())
                            <h3>{{ $locale === 'en' ? ($achievement->title_en ?? $achievement->title) : ($achievement->title) }}</h3>
                            <p>{{ $locale === 'en' ? ($achievement->content_en ?? $achievement->content) : ($achievement->content) }}</p>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 60px 20px; color: #666;">
                        <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Belum ada pencapaian</h3>
                        <p style="margin: 0; font-size: 0.95rem;">Pencapaian akan segera ditambahkan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- CTA SECTION -->
            <div class="about-cta">
                <h2>{{ __('content.about_page.cta_title') }}</h2>
                <a href="{{ route('search') }}" class="btn btnbawah">{{ __('content.about_page.cta_button') }}</a>
            </div>
        </div>
    </section>
</div>

{{-- External JavaScript --}}
<script src="{{ asset('js/about-carousel.js') }}"></script>

</x-layout>
