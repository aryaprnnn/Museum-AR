<x-layout title="{{ $post['title'] }}">
<div class="blog-detail-page-wrapper">
    <!-- HERO IMAGE SECTION -->
    <section class="blog-hero-section">
        <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" class="blog-hero-image">
        <div class="blog-hero-overlay"></div>
    </section>

    <!-- BLOG CONTENT SECTION -->
    <section class="blog-detail-content">
        <div class="container" style="max-width: 900px; margin: 0 auto; padding: 60px 20px;">
            <!-- BLOG TITLE & META -->
            <div class="blog-detail-header">
                <h1 class="blog-detail-title">{{ $post['title'] }}</h1>
                <div class="blog-detail-meta">
                    <span class="meta-item">
                        <i class="fas fa-calendar"></i>
                        {{ $post['date'] }}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-pen"></i>
                        {{ $post['author'] }}
                    </span>
                    <span class="meta-badge">{{ $post['category'] }}</span>
                </div>
            </div>

            <!-- BLOG FEATURED IMAGE -->
            <div class="blog-featured-image" style="margin: 50px 0;">
                <img src="{{ asset($post['image']) }}" alt="{{ $post['title'] }}" style="width: 100%; border-radius: 10px; object-fit: cover; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            </div>

            <!-- BLOG DESCRIPTION -->
            <div class="blog-detail-description">
                <div class="blog-text-content">
                    {{ $post['content'] }}
                </div>
            </div>

            <!-- BACK TO BLOGS BUTTON -->
            <div class="blog-back-button" style="margin-top: 60px; text-align: center;">
                <a href="{{ route('blogs') }}" class="btn-back">← Kembali ke Daftar Blog</a>
            </div>
        </div>
    </section>
</div>
</x-layout>
