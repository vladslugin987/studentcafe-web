document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.slider-container');
  if (!container) return;

  const mainImage = container.querySelector('.main-image img');
  const thumbnails = Array.from(container.querySelectorAll('.thumbnails img'));
  const prevBtn = container.querySelector('.slider-arrow.prev');
  const nextBtn = container.querySelector('.slider-arrow.next');

  if (!mainImage || thumbnails.length === 0) return;

  let currentIndex = 0;
  let timerId;

  const setActive = (idx) => {
    currentIndex = (idx + thumbnails.length) % thumbnails.length;
    const { src, alt } = thumbnails[currentIndex];
    mainImage.src = src;
    mainImage.alt = alt || 'Slider Bild';
    thumbnails.forEach((thumb, i) =>
      thumb.classList.toggle('active', i === currentIndex)
    );
  };

  const goNext = () => setActive(currentIndex + 1);
  const goPrev = () => setActive(currentIndex - 1);

  const restartTimer = () => {
    clearInterval(timerId);
    timerId = setInterval(goNext, 5000);
  };

  thumbnails.forEach((thumb, idx) => {
    thumb.addEventListener('click', () => {
      setActive(idx);
      restartTimer();
    });
  });

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      goPrev();
      restartTimer();
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      goNext();
      restartTimer();
    });
  }

  setActive(0);
  timerId = setInterval(goNext, 5000);
});
