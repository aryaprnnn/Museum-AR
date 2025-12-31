<!-- BLOGS PREVIEW SECTION -->
<section id="blogs-preview">
    <div class="section-header-top">
        <h2><b>{{ __('content.blogs_preview.heading') }}</b></h2>
        <p>{{ __('content.blogs_preview.subheading') }}</p>
    </div>

    <div class="blogs-horizontal-scroll">
        <div class="blogs-carousel">
            @forelse($blogs as $blog)
            <div class="blog-card-horizontal">
                <div class="blog-image">
                    <img src="{{ \Illuminate\Support\Str::startsWith($blog['image'], ['http://', 'https://']) ? $blog['image'] : asset('storage/'.$blog['image']) }}" alt="{{ $blog['title'] }}">
                    <span class="blog-date">{{ $blog['date'] }}</span>
                </div>
                <div class="blog-content">
                    <h3>{{ $blog['title'] }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($blog['excerpt'], 100) }}</p>
                    <a href="{{ route('blogs.show', $blog['id']) }}" class="read-more">{{ __('content.blogs_preview.read_more') }}</a>
                </div>
            </div>
            @empty
            <p style="grid-column: 1/-1; text-align: center; padding: 40px;">Belum ada blog yang dipublikasikan.</p>
            @endforelse
        </div>
    </div>

    <div class="section-cta-blogs">
        <a href="{{ route('blogs') }}" class="btn btn-about">{{ __('content.blogs_preview.cta') }}</a>
    </div>
</section>

