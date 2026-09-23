(function () {
  'use strict';

  const SELECTOR = '.baji-hero-swiper';
  const INTERVAL = 4200;
  let timer = null;
  let index = 0;
  let slides = [];
  let bullets = [];
  let startX = 0;

  function clearTimer() {
    if (timer) {
      window.clearInterval(timer);
      timer = null;
    }
  }

  function show(next, userAction) {
    if (!slides.length) return;

    index = (next + slides.length) % slides.length;

    slides.forEach((slide, i) => {
      const active = i === index;
      slide.classList.toggle('baji-hero-is-active', active);
      slide.setAttribute('aria-hidden', active ? 'false' : 'true');
    });

    bullets.forEach((bullet, i) => {
      const active = i === index;
      bullet.classList.toggle('is-active', active);
      bullet.setAttribute('aria-current', active ? 'true' : 'false');
    });

    if (userAction) restart();
  }

  function restart() {
    clearTimer();
    if (slides.length > 1 && !document.hidden) {
      timer = window.setInterval(() => show(index + 1, false), INTERVAL);
    }
  }

  function buildPagination(container) {
    let pagination = container.querySelector('.baji-hero-pagination');

    if (!pagination) {
      pagination = document.createElement('div');
      pagination.className = 'baji-hero-pagination';
      container.appendChild(pagination);
    }

    pagination.innerHTML = '';
    bullets = slides.map((slide, i) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'baji-hero-manual-bullet';
      button.setAttribute('aria-label', 'اسلاید ' + (i + 1));
      button.addEventListener('click', () => show(i, true));
      pagination.appendChild(button);
      return button;
    });
  }

  function init() {
    const container = document.querySelector(SELECTOR);
    if (!container) return;

    /* Destroy a previous Swiper instance if another script initialized it. */
    if (container.swiper && typeof container.swiper.destroy === 'function') {
      try {
        container.swiper.destroy(true, true);
      } catch (e) {}
    }

    container.classList.remove('swiper-initialized', 'swiper-horizontal', 'swiper-rtl', 'swiper-fade');
    container.classList.add('baji-hero-manual');

    const wrapper = container.querySelector('.swiper-wrapper');
    if (!wrapper) return;

    wrapper.removeAttribute('style');
    slides = Array.from(wrapper.children).filter((node) => node.classList.contains('swiper-slide'));

    if (!slides.length) return;

    slides.forEach((slide) => {
      slide.removeAttribute('style');
      slide.classList.remove(
        'swiper-slide-active',
        'swiper-slide-next',
        'swiper-slide-prev',
        'swiper-slide-visible',
        'swiper-slide-fully-visible'
      );
    });

    buildPagination(container);
    show(0, false);
    restart();

    container.addEventListener('touchstart', (event) => {
      if (!event.touches || !event.touches[0]) return;
      startX = event.touches[0].clientX;
      clearTimer();
    }, { passive: true });

    container.addEventListener('touchend', (event) => {
      const touch = event.changedTouches && event.changedTouches[0];
      if (!touch) {
        restart();
        return;
      }

      const delta = touch.clientX - startX;
      if (Math.abs(delta) > 45) {
        show(index + (delta < 0 ? 1 : -1), false);
      }
      restart();
    }, { passive: true });

    container.addEventListener('mouseenter', clearTimer);
    container.addEventListener('mouseleave', restart);

    document.addEventListener('visibilitychange', () => {
      if (document.hidden) clearTimer();
      else restart();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();