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

  // Some browsers are picky about key events on non-interactive elements like <img>.
  // We handle keyboard activation both on the thumbnail itself and via event delegation on the container.
  const isActivateKey = (e) =>
    e.key === 'Enter' ||
    e.key === ' ' ||
    e.key === 'Spacebar' ||
    e.code === 'Enter' ||
    e.code === 'Space' ||
    e.code === 'NumpadEnter';

  thumbnails.forEach((thumb, idx) => {
    if (!thumb.hasAttribute('tabindex')) thumb.setAttribute('tabindex', '0');
    if (!thumb.hasAttribute('role')) thumb.setAttribute('role', 'button');
    thumb.dataset.sliderIndex = String(idx);

    thumb.addEventListener('click', () => {
      setActive(idx);
      restartTimer();
    });

    thumb.addEventListener('keydown', (e) => {
      if (isActivateKey(e)) {
        e.preventDefault();
        setActive(idx);
        restartTimer();
      }
    });

    thumb.addEventListener('keyup', (e) => {
      if (isActivateKey(e)) {
        e.preventDefault();
        setActive(idx);
        restartTimer();
      }
    });
  });

  container.addEventListener('keydown', (e) => {
    if (!isActivateKey(e)) return;
    const target = e.target;
    if (!(target instanceof Element)) return;
    const thumb = target.closest('.thumbnails img');
    if (!thumb) return;
    const idxStr = thumb.getAttribute('data-slider-index');
    const idx = idxStr ? Number(idxStr) : NaN;
    if (!Number.isFinite(idx)) return;
    e.preventDefault();
    setActive(idx);
    restartTimer();
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
