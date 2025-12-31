<x-layout title="Educational Programs" :mainClass="'light-bg'">
    <div class="program-page">
        <header class="program-header">
            <p class="program-kicker">Program</p>
            <h1>Educational Program</h1>
            <p class="program-subtitle">Workshop dan seminar untuk memperdalam pengetahuan sejarah, seni, dan konservasi.</p>
        </header>

        <div class="program-filters" data-filter-scope="edu">
            <button class="filter-pill active" data-filter="all">Semua</button>
            <button class="filter-pill" data-filter="workshop">Workshop</button>
            <button class="filter-pill" data-filter="seminar">Seminar</button>
        </div>

        <div class="program-grid">
            @forelse($programs as $program)
                @php
                    $imageUrl = $program->image
                        ? (\Illuminate\Support\Str::startsWith($program->image, ['http://', 'https://'])
                            ? $program->image
                            : asset('storage/'.$program->image))
                        : asset('img/placeholder.png');
                @endphp
                <div class="program-card" data-category="{{ $program->type }}">
                    <div class="program-thumb" style="background-image:url('{{ $imageUrl }}');background-size:cover;background-position:center;"></div>
                    <div class="program-body">
                        <h3>{{ $program->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($program->description, 100) }}</p>
                        <a href="{{ route('educational-program.show', $program->slug) }}" class="btn program-btn">Lihat Selengkapnya</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Belum ada program edukasi yang aktif</h3>
                    <p style="margin: 0; font-size: 0.95rem;">Program edukasi akan segera tersedia</p>
                </div>
            @endforelse
        </div>
                <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const scope = document.querySelector('.program-filters[data-filter-scope="edu"]');
                    if(!scope) return;
                    const buttons = scope.querySelectorAll('.filter-pill');
                    const cards = document.querySelectorAll('.program-grid .program-card');
                    buttons.forEach(btn=>{
                        btn.addEventListener('click',()=>{
                            buttons.forEach(b=>b.classList.remove('active'));
                            btn.classList.add('active');
                            const filter = btn.getAttribute('data-filter');
                            cards.forEach(card=>{
                                const cat = card.getAttribute('data-category');
                                const show = (filter==='all') || (cat===filter);
                                card.style.display = show ? '' : 'none';
                            });
                        });
                    });
                });
                </script>
        </div>
</x-layout>
