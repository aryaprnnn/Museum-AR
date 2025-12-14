<x-layout title="Blogs">
<div class="blogs-page-wrapper">
    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/gap.jpg') }}" alt="Blogs">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>{{ __('content.blogs_page.hero_title') }}</h1>
            <p>{{ __('content.blogs_page.hero_subtitle') }}</p>
        </div>
    </section>

    <section style="padding: 60px 20px; background-color: #FFF0DC;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <!-- CATEGORY FILTER DROPDOWN -->
            <div class="filter-header">
                <label for="categorySelect">{{ __('content.blogs_page.filter_label') }}</label>
                <select id="categorySelect" class="category-dropdown" onchange="filterByCategory(this.value)">
                    <option value="semua" @if($selectedCategory === 'semua') selected @endif>{{ __('content.blogs_page.filters.all') }}</option>
                    <option value="Sejarah" @if($selectedCategory === 'Sejarah') selected @endif>{{ __('content.blogs_page.filters.history') }}</option>
                    <option value="Teknik" @if($selectedCategory === 'Teknik') selected @endif>{{ __('content.blogs_page.filters.tech') }}</option>
                    <option value="Budaya" @if($selectedCategory === 'Budaya') selected @endif>{{ __('content.blogs_page.filters.culture') }}</option>
                    <option value="Seni" @if($selectedCategory === 'Seni') selected @endif>{{ __('content.blogs_page.filters.art') }}</option>
                </select>
            </div>

            <!-- BLOGS LIST -->
            <div class="blogs-list">
                @foreach($posts as $id => $blog)
                <div class="blog-card">
                    <div class="blog-image">
                        <img src="{{ asset($blog['image']) }}" alt="{{ $blog['title'] }}">
                        <span class="blog-category">{{ $blog['category'] }}</span>
                    </div>
                    <div class="blog-content">
                        <h3>{{ $blog['title'] }}</h3>
                        <div class="blog-meta">
                            <span>📅 {{ $blog['date'] }}</span>
                            <span>✍️ {{ $blog['author'] }}</span>
                        </div>
                        <p>{{ $blog['excerpt'] }}</p>
                        <a href="{{ route('blogs.show', $id) }}" class="read-more">{{ __('content.blogs_page.read_more') }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

{{-- External JavaScript --}}
<script>
    const blogsRoute = "{{ route('blogs') }}";
</script>
<script src="{{ asset('js/blogs-filter.js') }}"></script>
</x-layout>
