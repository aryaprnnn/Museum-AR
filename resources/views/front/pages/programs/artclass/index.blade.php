<x-layout :title="__('content.artclass_page.title')" :mainClass="'light-bg'">
    <div class="program-page">
        <header class="program-header">
            <p class="program-kicker">{{ __('content.artclass_page.kicker') }}</p>
            <h1>{{ __('content.artclass_page.title') }}</h1>
            <p class="program-subtitle">{{ __('content.artclass_page.subtitle') }}</p>
        </header>

        <div class="program-filters" data-filter-scope="artclass">
            <button class="filter-pill active" data-filter="all">{{ __('content.artclass_page.filter_all') }}</button>
            <button class="filter-pill" data-filter="pemula">{{ __('content.artclass_page.filter_beginner') }}</button>
            <button class="filter-pill" data-filter="menengah">{{ __('content.artclass_page.filter_intermediate') }}</button>
            <button class="filter-pill" data-filter="lanjutan">{{ __('content.artclass_page.filter_advanced') }}</button>
        </div>

        <div class="program-grid">
            @forelse($classes as $class)
                @php
                    $imageUrl = $class->image
                        ? (\Illuminate\Support\Str::startsWith($class->image, ['http://', 'https://'])
                            ? $class->image
                            : asset('storage/'.$class->image))
                        : asset('img/placeholder.png');
                @endphp
                <div class="program-card" data-category="{{ $class->level }}">
                    <div class="program-thumb" style="background-image:url('{{ $imageUrl }}');background-size:cover;background-position:center;"></div>
                    <div class="program-body">
                        <h3>{{ $class->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($class->description, 100) }}</p>
                        <a href="{{ route('artclass.show', $class->slug) }}" class="btn program-btn">{{ __('content.artclass.view_detail') }}</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd"/>
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">{{ __('content.artclass_page.empty_title') }}</h3>
                    <p style="margin: 0; font-size: 0.95rem;">{{ __('content.artclass_page.empty_message') }}</p>
                </div>
            @endforelse
        </div>
                <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const scope = document.querySelector('.program-filters[data-filter-scope="artclass"]');
                    if(!scope) return;
                    
                    const buttons = scope.querySelectorAll('.filter-pill');
                    const cards = document.querySelectorAll('.program-grid .program-card');
                    const grid = document.querySelector('.program-grid');
                    
                    // Create empty message element
                    const emptyMsg = document.createElement('div');
                    emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666; display: none; width: 100%;';
                    emptyMsg.innerHTML = `
                        <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd"/>
                        </svg>
                        <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Tidak ada program</h3>
                        <p style="margin: 0; font-size: 0.95rem;">Tidak ada program untuk kategori ini saat ini.</p>
                    `;
                    grid.appendChild(emptyMsg);

                    buttons.forEach(btn=>{
                        btn.addEventListener('click',()=>{
                            buttons.forEach(b=>b.classList.remove('active'));
                            btn.classList.add('active');
                            const filter = btn.getAttribute('data-filter');
                            
                            let visibleCount = 0;
                            cards.forEach(card=>{
                                const cat = card.getAttribute('data-category');
                                const show = (filter==='all') || (cat===filter);
                                card.style.display = show ? '' : 'none';
                                if(show) visibleCount++;
                            });
                            
                            // Show/hide empty message
                            if(visibleCount === 0) {
                                emptyMsg.style.display = 'block';
                            } else {
                                emptyMsg.style.display = 'none';
                            }
                        });
                    });
                });
                </script>
        </div>
</x-layout>
