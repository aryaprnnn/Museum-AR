<x-layout title="Blogs">
<div class="blogs-page-wrapper">
    <!-- HERO IMAGE WITH TEXT OVERLAY -->
    <section class="page-hero-image">
        <img src="{{ asset('img/gap.jpg') }}" alt="Blogs">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>Blog & Artikel</h1>
            <p>Baca artikel menarik tentang sejarah dan koleksi kami</p>
        </div>
    </section>

    <section style="padding: 60px 20px; background-color: #FFF0DC;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <!-- CATEGORY FILTER DROPDOWN -->
            <div class="filter-header">
                <label for="categorySelect">Filter Kategori:</label>
                <select id="categorySelect" class="category-dropdown" onchange="filterByCategory(this.value)">
                    <option value="semua" @if($selectedCategory === 'semua') selected @endif>Semua Kategori</option>
                    <option value="Sejarah" @if($selectedCategory === 'Sejarah') selected @endif>Sejarah</option>
                    <option value="Teknik" @if($selectedCategory === 'Teknik') selected @endif>Teknik</option>
                    <option value="Budaya" @if($selectedCategory === 'Budaya') selected @endif>Budaya</option>
                    <option value="Seni" @if($selectedCategory === 'Seni') selected @endif>Seni</option>
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
                        <a href="{{ route('blogs.show', $id) }}" class="read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<script>
    function filterByCategory(category) {
        if (category === 'semua') {
            window.location.href = "{{ route('blogs') }}";
        } else {
            window.location.href = "{{ route('blogs', ['category' => '']) }}" + category;
        }
    }
</script>
</x-layout>
