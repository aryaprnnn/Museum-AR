<x-layout title="Blogs">
<div class="blogs-page-wrapper">
    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/1.jpg') }}" alt="Blogs">
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
                    <option value="Cerita Artefak" @if($selectedCategory === 'Cerita Artefak') selected @endif>Cerita Artefak</option>
                    <option value="News & Event" @if($selectedCategory === 'News & Event') selected @endif>News & Event</option>
                </select>
            </div>

            <!-- BLOGS LIST -->
            <div class="blogs-list">
                @forelse($posts as $blog)
                <div class="blog-card">
                    <div class="blog-image">
                        @php
                            $imageUrl = $blog->image
                                ? (\Illuminate\Support\Str::startsWith($blog->image, ['http://', 'https://'])
                                    ? $blog->image
                                    : asset('storage/'.$blog->image))
                                : asset('img/placeholder.png');
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $blog->title }}">
                        <span class="blog-category">{{ $blog->category ?? 'Umum' }}</span>
                    </div>
                    <div class="blog-content">
                        <h3>{{ $blog->title }}</h3>
                        <div class="blog-meta">
                            <span class="blog-author">Museum AR</span>
                            <span class="blog-date">{{ optional($blog->created_at)->format('d M Y') }}</span>
                        </div>
                        <p>{{ \Illuminate\Support\Str::limit($blog->excerpt, 100) }}</p>
                        <a href="{{ route('blogs.show', $blog->id) }}" class="read-more">{{ __('content.blogs_page.read_more') }}</a>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Belum ada artikel</h3>
                    <p style="margin: 0; font-size: 0.95rem;">Artikel akan segera tersedia</p>
                </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if($posts->hasPages())
            <div style="margin-top: 40px;">
                {{ $posts->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </section>
</div>

{{-- External JavaScript --}}
<script>
    const blogsRoute = "{{ route('blogs') }}";
</script>
<script src="{{ asset('js/blogs-filter.js') }}"></script>
</x-layout>
