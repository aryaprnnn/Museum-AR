<x-layout title="About Us">

<div class="about-page-wrapper">
    <!-- IMAGE CAROUSEL SECTION -->
    <section class="about-carousel-section">
        <div class="about-carousel">
            <div class="carousel-slide active">
                <img src="{{ asset('img/gap.jpg') }}" alt="Museum 1">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/bawah.JPG') }}" alt="Museum 2">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/hp.jpg') }}" alt="Museum 3">
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('img/timun.png') }}" alt="Museum 4">
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
                    <img src="{{ asset('img/gap.jpg') }}" alt="Museum Virtual AR">
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
                    <img src="{{ asset('img/bawah.JPG') }}" alt="Sejarah Museum">
                </div>
            </div>

            <!-- ACHIEVEMENTS SECTION -->
            <div class="achievements-section">
                <h2>{{ __('content.about_page.achievements_title') }}</h2>
                <p class="section-intro">{{ __('content.about_page.achievements_intro') }}</p>
                
                <div class="achievements-list">
                    @foreach(__('content.about_page.achievements') as $achievement)
                    <div class="achievement-item">
                        <div class="achievement-image">
                            <img src="{{ asset('img/placeholder.png') }}" alt="{{ $achievement['title'] }}">
                        </div>
                        <div class="achievement-info">
                            <h3>{{ $achievement['title'] }}</h3>
                            <p>{{ $achievement['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
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
