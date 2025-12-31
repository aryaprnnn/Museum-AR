<x-layout title="Search Results">

<div class="search-page-wrapper">
    <!-- HERO SECTION -->
    <section class="page-hero-image">
        <img src="{{ asset('img/gap.jpg') }}" alt="Search">
        <div class="hero-overlay"></div>
        <div class="hero-text-content">
            <h1>{{ __('content.search.title') }}</h1>
            <p>{{ __('content.search.subtitle') }}</p>
        </div>
    </section>

    <!-- SEARCH FORM -->
    <section style="padding: 40px 20px; background-color: #ffffff;">
        <div class="container" style="max-width: 1000px; margin: 0 auto;">
            <form method="GET" action="{{ route('search') }}" style="display: flex; gap: 10px; margin-bottom: 30px;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $query }}" 
                    placeholder="{{ __('content.search.placeholder') }}" 
                    style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;"
                >
                <button type="submit" class="btn" style="padding: 12px 30px;">{{ __('content.search.button') }}</button>
            </form>

            @if(empty($query))
                <p style="text-align: center; color: #666;">{{ __('content.search.empty_hint') }}</p>
            @else
                <p style="color: #666; margin-bottom: 30px;">
                    {{ __('content.search.results_for') }} <strong>"{{ $query }}"</strong>
                    <br>
                    Total: <strong>{{ $blogs->total() + $collections->total() + $artClasses->total() + $programs->total() }}</strong> hasil
                </p>

                <!-- BLOGS SECTION -->
                @if($blogs->count() > 0)
                <div style="margin-bottom: 50px;">
                    <h2 style="color: #543A14; margin-bottom: 20px; border-bottom: 2px solid #f0bb78; padding-bottom: 10px;">
                        📰 Blog ({{ $blogs->total() }})
                    </h2>
                    <div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($blogs as $blog)
                        <div class="search-result-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            @if($blog->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($blog->image, ['http://', 'https://']) ? $blog->image : asset('storage/'.$blog->image) }}" 
                                 alt="{{ $blog->title }}" 
                                 style="width: 100%; height: 200px; object-fit: cover;">
                            @endif
                            <div style="padding: 15px;">
                                <h3 style="color: #543A14; margin: 10px 0; font-size: 1.1rem;">{{ $blog->title }}</h3>
                                <p style="color: #666; font-size: 0.9rem; margin: 10px 0;">{{ \Illuminate\Support\Str::limit($blog->excerpt, 80) }}</p>
                                <small style="color: #999;">{{ $blog->created_at->format('d M Y') }}</small>
                                <br>
                                <a href="{{ route('blogs.show', $blog->id) }}" class="btn" style="margin-top: 10px; display: inline-block; padding: 8px 15px; font-size: 0.9rem;">Baca Selengkapnya</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px;">
                        {{ $blogs->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

                <!-- COLLECTIONS SECTION -->
                @if($collections->count() > 0)
                <div style="margin-bottom: 50px;">
                    <h2 style="color: #543A14; margin-bottom: 20px; border-bottom: 2px solid #f0bb78; padding-bottom: 10px;">
                        🏺 {{ __('content.search.collections') }} ({{ $collections->total() }})
                    </h2>
                    <div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($collections as $collection)
                        <div class="search-result-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            @if($collection->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($collection->image, ['http://', 'https://']) ? $collection->image : asset('storage/'.$collection->image) }}" 
                                 alt="{{ $collection->name }}" 
                                 style="width: 100%; height: 200px; object-fit: cover;">
                            @endif
                            <div style="padding: 15px;">
                                <h3 style="color: #543A14; margin: 10px 0; font-size: 1.1rem;">{{ $collection->name }}</h3>
                                <p style="color: #666; font-size: 0.9rem; margin: 10px 0;">{{ \Illuminate\Support\Str::limit($collection->description, 80) }}</p>
                                <small style="color: #999;">{{ $collection->category }} • {{ $collection->origin }}</small>
                                <br>
                                <a href="{{ route('collections.show', $collection->id) }}" class="btn" style="margin-top: 10px; display: inline-block; padding: 8px 15px; font-size: 0.9rem;">{{ __('content.search.view_detail') }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px;">
                        {{ $collections->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

                <!-- ART CLASSES SECTION -->
                @if($artClasses->count() > 0)
                <div style="margin-bottom: 50px;">
                    <h2 style="color: #543A14; margin-bottom: 20px; border-bottom: 2px solid #f0bb78; padding-bottom: 10px;">
                        🎨 {{ __('content.search.artclasses') }} ({{ $artClasses->total() }})
                    </h2>
                    <div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($artClasses as $artClass)
                        <div class="search-result-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <div style="padding: 15px; background: linear-gradient(135deg, #FFF0DC 0%, #f5efe6 100%);">
                                <h3 style="color: #543A14; margin: 10px 0; font-size: 1.1rem;">{{ $artClass->title }}</h3>
                                <p style="color: #666; font-size: 0.9rem; margin: 10px 0;">{{ \Illuminate\Support\Str::limit($artClass->description, 80) }}</p>
                                <small style="color: #999;">📍 {{ $artClass->level }} • 👨‍🏫 {{ $artClass->instructor }}</small>
                                <br>
                                <a href="{{ route('artclass.detail', $artClass->slug) }}" class="btn" style="margin-top: 10px; display: inline-block; padding: 8px 15px; font-size: 0.9rem;">{{ __('content.search.view_detail') }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px;">
                        {{ $artClasses->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

                <!-- PROGRAMS SECTION -->
                @if($programs->count() > 0)
                <div style="margin-bottom: 50px;">
                    <h2 style="color: #543A14; margin-bottom: 20px; border-bottom: 2px solid #f0bb78; padding-bottom: 10px;">
                        📚 {{ __('content.search.educational_programs') }} ({{ $programs->total() }})
                    </h2>
                    <div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                        @foreach($programs as $program)
                        <div class="search-result-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                            <div style="padding: 15px; background: linear-gradient(135deg, #FFF0DC 0%, #f5efe6 100%);">
                                <h3 style="color: #543A14; margin: 10px 0; font-size: 1.1rem;">{{ $program->title }}</h3>
                                <p style="color: #666; font-size: 0.9rem; margin: 10px 0;">{{ \Illuminate\Support\Str::limit($program->description, 80) }}</p>
                                <small style="color: #999;">📍 {{ $program->type }} • 👨‍🏫 {{ $program->facilitator }}</small>
                                <br>
                                <a href="{{ route('educational-program.detail', $program->slug) }}" class="btn" style="margin-top: 10px; display: inline-block; padding: 8px 15px; font-size: 0.9rem;">{{ __('content.search.view_detail') }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px;">
                        {{ $programs->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif

                @if($blogs->count() == 0 && $collections->count() == 0 && $artClasses->count() == 0 && $programs->count() == 0)
                <div style="text-align: center; padding: 40px;">
                    <h3 style="color: #543A14;">Tidak ada hasil yang ditemukan</h3>
                    <p style="color: #666;">Coba gunakan kata kunci yang berbeda</p>
                </div>
                @endif
            @endif
        </div>
    </section>
</div>

</x-layout>
