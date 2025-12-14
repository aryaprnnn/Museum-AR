<!-- BLOGS PREVIEW SECTION -->
<?php
$blogs = __('content.blogs_preview.items');
?>

<section id="blogs-preview">
    <div class="section-header-top">
        <h2><b>{{ __('content.blogs_preview.heading') }}</b></h2>
        <p>{{ __('content.blogs_preview.subheading') }}</p>
    </div>

    <div class="blogs-horizontal-scroll">
        <div class="blogs-carousel">
            <?php foreach ($blogs as $blog): ?>
            <div class="blog-card-horizontal">
                <div class="blog-image">
                    <img src="{{ asset('<?php echo $blog['image']; ?>') }}" alt="<?php echo $blog['title']; ?>">
                    <span class="blog-date"><?php echo $blog['date']; ?></span>
                </div>
                <div class="blog-content">
                    <h3><?php echo $blog['title']; ?></h3>
                    <p><?php echo $blog['excerpt']; ?></p>
                    <a href="{{ route('blogs.show', $blog['id']) }}" class="read-more">{{ __('content.blogs_preview.read_more') }}</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-cta-blogs">
        <a href="{{ route('blogs') }}" class="btn btnbawah">{{ __('content.blogs_preview.cta') }}</a>
    </div>
</section>

