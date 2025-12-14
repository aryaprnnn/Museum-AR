(function(){
  const heroCard = document.querySelector('.artclass-hero-card');
  if(!heroCard) {
    console.log('artclass-hero-card not found');
    return;
  }
  const track = heroCard.querySelector('.artclass-slider');
  if(!track) {
    console.log('artclass-slider not found');
    return;
  }
  const slides = Array.from(track.children);
  const prevBtn = heroCard.querySelector('.artclass-nav-left');
  const nextBtn = heroCard.querySelector('.artclass-nav-right');
  let index = 0;
  let autoPlayInterval;

  console.log('Slider initialized with', slides.length, 'slides');

  function slideWidth(){
    // Get the actual container width minus padding
    const w = heroCard.offsetWidth - 40; // minus left+right padding 20px each
    return w;
  }

  function update(){
    const w = slideWidth();
    const offset = -index * w;
    track.style.transform = `translateX(${offset}px)`;
    track.setAttribute('data-index', String(index));
    console.log('Slide to index:', index, 'offset:', offset);
  }

  function clamp(i){
    if(i < 0) return slides.length - 1;
    if(i >= slides.length) return 0;
    return i;
  }

  function sizeSlides(){
    const w = slideWidth();
    slides.forEach(s => {
      s.style.width = w + 'px';
      s.style.minWidth = w + 'px';
    });
  }

  function onResize(){
    sizeSlides();
    update();
  }

  function goToNext(){
    index = clamp(index + 1);
    update();
  }

  function goToPrev(){
    index = clamp(index - 1);
    update();
  }

  function startAutoPlay(){
    stopAutoPlay();
    autoPlayInterval = setInterval(goToNext, 5000); // Auto slide every 5 seconds
  }

  function stopAutoPlay(){
    if(autoPlayInterval){
      clearInterval(autoPlayInterval);
      autoPlayInterval = null;
    }
  }

  function resetAutoPlay(){
    stopAutoPlay();
    startAutoPlay();
  }

  if(prevBtn) {
    prevBtn.addEventListener('click', ()=>{ 
      goToPrev();
      resetAutoPlay(); // Reset timer when manually navigating
      console.log('Prev clicked, new index:', index);
    });
  }
  
  if(nextBtn) {
    nextBtn.addEventListener('click', ()=>{ 
      goToNext();
      resetAutoPlay(); // Reset timer when manually navigating
      console.log('Next clicked, new index:', index);
    });
  }

  // Pause auto-play on hover
  heroCard.addEventListener('mouseenter', stopAutoPlay);
  heroCard.addEventListener('mouseleave', startAutoPlay);

  window.addEventListener('resize', onResize);
  
  // Initialize
  sizeSlides();
  update();
  startAutoPlay(); // Start auto-play
  console.log('Slider ready with auto-play');
})();
