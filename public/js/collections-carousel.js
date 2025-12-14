// Auto-scroll carousel untuk collections dengan continuous smooth scroll
const collectionsCarousel = document.querySelector('.collections-carousel');
let autoScrollInterval;
let isMouseOverCarousel = false;
let isAtEnd = false;

function autoScrollCollection() {
    if (collectionsCarousel && !isMouseOverCarousel) {
        const itemWidth = 320; // width + gap
        const maxScroll = collectionsCarousel.scrollWidth - collectionsCarousel.clientWidth;
        
        if (isAtEnd) {
            // Jika sudah di akhir, scroll kembali ke awal dengan smooth
            collectionsCarousel.scrollBy({
                left: -maxScroll,
                behavior: 'smooth'
            });
            isAtEnd = false;
        } else {
            // Scroll ke kanan
            collectionsCarousel.scrollBy({
                left: itemWidth,
                behavior: 'smooth'
            });
            
            // Cek apakah sudah mencapai akhir
            setTimeout(() => {
                if (collectionsCarousel.scrollLeft >= maxScroll - 10) {
                    isAtEnd = true;
                }
            }, 500);
        }
    }
}

function startAutoScroll() {
    autoScrollInterval = setInterval(autoScrollCollection, 4000);
}

function stopAutoScroll() {
    clearInterval(autoScrollInterval);
}

if (collectionsCarousel) {
    collectionsCarousel.addEventListener('mouseenter', () => {
        isMouseOverCarousel = true;
        stopAutoScroll();
    });
    
    collectionsCarousel.addEventListener('mouseleave', () => {
        isMouseOverCarousel = false;
        startAutoScroll();
    });
    
    startAutoScroll();
}
