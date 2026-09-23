(function () {
    'use strict';

    let hero = null;
    let retryTimer = null;
    let watchdogTimer = null;
    let attempts = 0;

    function startAutoplay() {
        if (!hero || hero.destroyed || !hero.autoplay) return;
        if (!hero.autoplay.running) {
            hero.autoplay.start();
        }
    }

    function initHero() {
        const el = document.querySelector('.baji-hero-swiper');

        if (!el || typeof window.Swiper === 'undefined') {
            attempts += 1;
            if (attempts < 50) {
                retryTimer = window.setTimeout(initHero, 120);
            }
            return;
        }

        if (el.swiper && !el.swiper.destroyed) {
            el.swiper.destroy(true, true);
        }

        hero = new window.Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 750,
            observer: true,
            observeParents: true,
            watchSlidesProgress: true,
            autoplay: {
                delay: 4200,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
                waitForTransition: true
            },
            pagination: {
                el: el.querySelector('.baji-hero-pagination'),
                clickable: true
            },
            on: {
                init(swiper) {
                    swiper.autoplay.start();
                },
                touchEnd(swiper) {
                    window.setTimeout(() => {
                        if (!swiper.destroyed && swiper.autoplay && !swiper.autoplay.running) {
                            swiper.autoplay.start();
                        }
                    }, 100);
                }
            }
        });

        window.clearInterval(watchdogTimer);
        watchdogTimer = window.setInterval(() => {
            if (!document.hidden) startAutoplay();
        }, 1500);
    }

    document.addEventListener('visibilitychange', () => {
        if (!hero || hero.destroyed || !hero.autoplay) return;

        if (document.hidden) {
            hero.autoplay.stop();
        } else {
            hero.autoplay.start();
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHero, { once: true });
    } else {
        initHero();
    }

    window.addEventListener('load', () => {
        if (!hero || hero.destroyed) initHero();
        else startAutoplay();
    }, { once: true });
})();