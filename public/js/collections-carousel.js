document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('.collections-carousel');
    const wrapper = document.querySelector('.collections-carousel-wrapper');

    if (!carousel || !wrapper) return;

    // Wait for images to load (optional but recommended for correct width calculation)
    // or just run calculation since we likely have fixed/min widths

    function initCarousel() {
        // Get original items
        const originalItems = Array.from(carousel.children);

        if (originalItems.length === 0) return;

        // Calculate width of one original set including gaps
        // We'll calculate the position of the last item + its width
        const lastItem = originalItems[originalItems.length - 1];

        // Ensure we include the gap. CSS flex gap is tricky to measure directly.
        // Best approach: Measure distance from first item start to last item end.
        const firstItemRect = originalItems[0].getBoundingClientRect();
        const lastItemRect = lastItem.getBoundingClientRect();

        // Current width of all items + gaps
        // Note: this depends on them being laid out horizontally already
        // But if they are wrapping or not wide enough, we need to be careful.
        // Assuming they are in a flex row.

        // Better Marquee Logic:
        // 1. Calculate the width of ONE single logical "set" of items.
        //    (We assume the current content is that set)
        // 2. Clone it enough times to fill (Screen Width * 2) + Buffer.

        // Let's measure the scrollWidth of the container before cloning
        // (Assuming no wrapping)

        // Reset container style for measurement
        carousel.style.width = 'max-content';
        carousel.style.display = 'flex';
        carousel.style.flexWrap = 'nowrap';

        // Get width of one set
        const singleSetWidth = carousel.scrollWidth;

        // We need 2 sets minimum for a seamless loop (Set A transitions out, Set A' transitions in)
        // Actually we need to translate from 0 to -singleSetWidth.
        // So we need visually: [Set A][Set A']...
        // When it reaches -singleSetWidth, we reset to 0.
        // Both need to be visible.

        // So we just clone the entire initial set ONCE.
        originalItems.forEach(item => {
            const clone = item.cloneNode(true);
            carousel.appendChild(clone);
        });

        // Add dynamic Keyframe
        const style = document.createElement('style');
        style.textContent = `
            @keyframes seamlessScroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-${singleSetWidth}px); }
            }
            
            .collections-carousel {
                display: flex;
                flex-wrap: nowrap;
                width: max-content; /* Ensure it doesn't wrap */
                animation: seamlessScroll 30s linear infinite;
            }
            
            .collections-carousel:hover {
                animation-play-state: paused;
            }
        `;
        document.head.appendChild(style);

        // Optional: Adjust speed based on width to keep speed consistent?
        // 30s for whatever width might be too fast/slow.
        // Let's optimize: Aim for e.g. 50 pixels per second.
        const duration = singleSetWidth / 50; // seconds
        // Update the duration in the injected CSS is hard, lets rely on inline style or update the textContent

        // Re-inject for better speed control
        style.textContent = `
            @keyframes seamlessScroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-${singleSetWidth}px); }
            }
            
            .collections-carousel {
                display: flex;
                flex-wrap: nowrap;
                gap: 25px; /* Ensure gap is consistent */
                width: max-content;
                animation: seamlessScroll ${Math.max(20, duration)}s linear infinite;
            }
            
            .collections-carousel:hover {
                animation-play-state: paused;
            }
        `;
    }

    // Run initialization
    // Run initialization only after all resources (images) are loaded
    window.addEventListener('load', initCarousel);
});
