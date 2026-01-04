document.addEventListener('DOMContentLoaded', function () {
    const carouselTrack = document.querySelector('.collections-carousel');
    const scrollContainer = document.querySelector('.collections-carousel-wrapper');

    if (!carouselTrack || !scrollContainer) return;

    // Configuration
    const scrollSpeed = 2; // Speed adjusted for smooth flow (was 5 in debug)

    // Initial Setup
    let originalItemsCount = carouselTrack.children.length;
    if (originalItemsCount === 0) return;

    // Clone items for seamless loop
    const originalItems = Array.from(carouselTrack.children);

    // First set of clones
    originalItems.forEach(item => {
        const clone = item.cloneNode(true);
        clone.classList.add('carousel-clone');
        carouselTrack.appendChild(clone);
    });

    // Second set of clones (ensure sufficient width for seamless scrolling on large screens)
    originalItems.forEach(item => {
        const clone = item.cloneNode(true);
        clone.classList.add('carousel-clone');
        carouselTrack.appendChild(clone);
    });

    // Metrics
    let singleSetWidth = 0;

    function updateMetrics() {
        const firstItem = carouselTrack.children[0];
        const firstClone = carouselTrack.children[originalItemsCount];

        if (firstItem && firstClone) {
            singleSetWidth = firstClone.offsetLeft - firstItem.offsetLeft;
        }
    }

    window.addEventListener('load', updateMetrics);
    window.addEventListener('resize', updateMetrics);
    updateMetrics();

    // Auto-scroll Loop
    function loop() {
        requestAnimationFrame(loop);

        if (singleSetWidth <= 0) {
            updateMetrics();
            if (singleSetWidth <= 0) return;
        }

        if (scrollContainer.scrollLeft >= singleSetWidth) {
            scrollContainer.scrollLeft -= singleSetWidth;
        }

        scrollContainer.scrollLeft += scrollSpeed;
    }

    loop();
});
