<x-layout title="Exhibitions" :mainClass="'light-bg'">
    <div class="program-page">
        <header class="program-header">
            <p class="program-kicker">Program</p>
            <h1>Exhibitions</h1>
            <p class="program-subtitle">Kurasi pameran terkini hingga yang akan datang, lengkap dengan pengalaman AR.</p>
        </header>

        <div class="program-filters" data-filter-scope="exhibitions">
            <button class="filter-pill active" data-filter="all">All</button>
            <button class="filter-pill" data-filter="ongoing">On Going</button>
            <button class="filter-pill" data-filter="upcoming">Upcoming</button>
        </div>

        <div class="program-grid">
            @forelse($exhibitions as $exhibition)
                @php
                    $imageUrl = $exhibition->image
                        ? (\Illuminate\Support\Str::startsWith($exhibition->image, ['http://', 'https://'])
                            ? $exhibition->image
                            : asset('storage/'.$exhibition->image))
                        : asset('img/placeholder.png');
                @endphp
                <div class="program-card" data-category="{{ $exhibition->status }}">
                    <div class="program-thumb" style="background-image:url('{{ $imageUrl }}');background-size:cover;background-position:center;"></div>
                    <div class="program-body">
                        <h3>{{ $exhibition->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($exhibition->description, 100) }}</p>
                        <a href="{{ route('exhibitions.show', $exhibition->slug) }}" class="btn program-btn">Lihat Selengkapnya</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666;">
                    <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Belum ada pameran yang aktif</h3>
                    <p style="margin: 0; font-size: 0.95rem;">Pameran baru akan segera hadir</p>
                </div>
            @endforelse
        </div>
                <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const scope = document.querySelector('.program-filters[data-filter-scope="exhibitions"]');
                    if(!scope) return;
                    
                    const buttons = scope.querySelectorAll('.filter-pill');
                    const cards = document.querySelectorAll('.program-grid .program-card');
                    const grid = document.querySelector('.program-grid');
                    
                    // Create empty message element
                    const emptyMsg = document.createElement('div');
                    emptyMsg.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #666; display: none; width: 100%;';
                    emptyMsg.innerHTML = `
                        <svg style="width: 80px; height: 80px; margin: 0 auto 20px; opacity: 0.3;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                        </svg>
                        <h3 style="font-size: 1.3rem; margin-bottom: 8px; color: #333;">Tidak ada pameran</h3>
                        <p style="margin: 0; font-size: 0.95rem;">Tidak ada pameran untuk kategori ini saat ini.</p>
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
